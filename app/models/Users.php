<?php

class Users extends Phalcon\Mvc\Model {

    public $id;
    public $login;
    public $firstName;
    public $secondName;
    public $pass;
    public $active;
    public $role;
    public $city;
    public $dogovor;
	public $email;

	public $subordinateUsers;


    public function getAllUsers(){
        $this->role = $this->getDI()->get('session')->get('role');
		$subRolesIds = Roles::getRoleSubroles($this->role);
		if (empty($subRolesIds))
		{
			return array();
		}
		if (in_array($this->role, array(Roles::ROLE_SUPERADMIN, Roles::ROLE_ADMIN)))
		{
			$subRolesIds[] = $this->role;
		}

		$roles = new Phalcon\Db\RawValue(implode(',', $subRolesIds));
		return $this->getDI()->get('db')->fetchAll('SELECT eu.id,
                                  eu.username,
                                  eu.firstname,
                                  eu.secondname,
								  er.id as role_id,
                                  er.rolename as role,
                                  ec.city,
                                  eu.dogovor,
                                  eu.email,
								  eu.active FROM ester_users as eu, ester_city as ec, ester_rolename as er
								  WHERE eu.city = ec.id AND er.id = eu.role 
								    AND eu.role IN (' . implode(',', $subRolesIds) . ')', Phalcon\Db::FETCH_ASSOC
								    //AND eu.role IN (:roles)', Phalcon\Db::FETCH_ASSOC,
									//	array('roles' => implode(',', $subRolesIds))
								);
    }
    public function saveNewUser(){
        return $this->getDI()->get('db')->insert('ester_users',
                                                       array($this->login,$this->firstName,$this->secondName,$this->role,$this->city,$this->dogovor,$this->email,md5(sha1($this->pass)+md5($this->login)),$this->active),
                                                       array("username","firstname","secondname","role","city","dogovor","email","token","active")
                                                       );


    }
    public function getUserById($id){
        $arrUser = $this->getDI()->get('db')->fetchOne('SELECT ester_users.id,
                                  ester_users.username,
                                  ester_users.firstname,
                                  ester_users.secondname,
                                  ester_users.role,
                                  ester_users.city,
                                  ester_users.dogovor,
                                  ester_users.email,
                                  ester_users.active FROM ester_users WHERE  ester_users.id = :id LIMIT 1', Phalcon\Db::FETCH_ASSOC, array('id' => $id));

        $this->id = $arrUser['id'];
        $this->login = $arrUser['username'];
        $this->firstName = $arrUser['firstname'];
        $this->secondName = $arrUser['secondname'];
        $this->role = $arrUser['role'];
        $this->city = $arrUser['city'];
        $this->dogovor = $arrUser['dogovor'];
        $this->email = $arrUser['email'];
		$this->active = $arrUser['active'];
    }

    public function updateUser($id){
        return  $this->getDI()->get('db')->update('ester_users',
                                                        array("firstname","secondname","role","city","dogovor","email","active"),
														array(
															$this->firstName,
															$this->secondName,
															$this->role,
															$this->city,
															$this->dogovor,
															$this->email,
															$this->active
														),
                                                        'id = "' . $id . '"');
	}

	public function updateSubordinateUsers($id, $subordinateUsers)
	{
		try {
			$connection = $this->getDI()->get('db');

			$connection->begin();

			$connection->delete('ester_subordinate_users', 'user_id = "' . $id . '"');
			foreach($subordinateUsers as $susr)
			{
				$connection->insert('ester_subordinate_users', array($id, $susr), array('user_id', 'subordinate_user_id'));
			}

			$connection->commit();
		}
		catch(Exception $e)
		{
			$connection->rollback();
			return false;
		}
		return true;
	}

    public function updatePassUser($id){
        return  $this->getDI()->get('db')->update('ester_users',array("token"),array(md5(sha1($this->pass)+md5($this->login))), 'id = "'.$id.'"');
    }

    public function delUser($id){
        return $this->getDI()->get('db')->delete('ester_users','id = "'.$id.'"');
    }
    public function loginUser(){
        return $this->getDI()->get('db')->fetchOne('SELECT id ,count(id) as cnt FROM ester_users WHERE
                                                         token = :token
                                                         AND username = :login
                                                         AND active = 1', Phalcon\Db::FETCH_ASSOC,
                                                    array("token"=>md5(sha1($this->pass)+md5($this->login)),
                                                          "login"=>$this->login
                                                        ));
    }

	static public function extractUserIds($subordinateUsers)
	{
		$userIds = array();
		if (isset($subordinateUsers['users']))
		{
			foreach($subordinateUsers['users'] as $su)
			{
				$userIds[$su] = $su;
				if (isset($subordinateUsers[$su]))
				{
					$userIds += self::extractUserIds($subordinateUsers[$su]);
				}
			}
		}

		return array_unique($userIds);
	}
	public function getSubordinateUsers()
	{
		if ($this->id != NULL)
		{
			$rawSubordinateUsers = $this->getDI()->get('db')->fetchAll("
				SELECT
					DISTINCT
					esu1.subordinate_user_id as layer1,
					esu2.subordinate_user_id as layer2,
					esu3.subordinate_user_id as layer3
				FROM ester_subordinate_users esu1
				LEFT JOIN ester_subordinate_users esu2 ON esu1.subordinate_user_id = esu2.user_id
				LEFT JOIN ester_subordinate_users esu3 ON esu2.subordinate_user_id = esu3.user_id
				WHERE esu1.user_id = :uid ORDER BY layer1, layer2, layer3",
				Phalcon\Db::FETCH_ASSOC,
				array('uid' => $this->id)
			);

			$subordinateUsers = array();
			foreach($rawSubordinateUsers as $item)
			{
				if ($item['layer3'] !== NULL) {
					$subordinateUsers[$item['layer1']][$item['layer2']]['users'][$item['layer3']] = $item['layer3'];
				}

				if($item['layer2'] !== NULL) {
					$subordinateUsers[$item['layer1']]['users'][$item['layer2']] = $item['layer2'];
				}

				$subordinateUsers['users'][$item['layer1']] = $item['layer1'];
			}

			return $subordinateUsers;
		}

		return array();
	}
}
