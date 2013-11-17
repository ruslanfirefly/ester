<?php


class Roles extends Phalcon\Mvc\Model {
	const ROLE_SUPERADMIN = 1;
	const ROLE_ADMIN      = 2;
	const ROLE_MANAGER    = 3;
	const ROLE_BROKER     = 4;
	const ROLE_FINBROKER  = 5;
	const ROLE_AGENT      = 6;

	public $role;

	static public function getRoleSubroles($roleId)
	{
		$roles = array(
			self::ROLE_SUPERADMIN => array(
				//self::ROLE_SUPERADMIN,
				self::ROLE_ADMIN,
				self::ROLE_MANAGER,
				self::ROLE_BROKER,
				self::ROLE_FINBROKER,
				self::ROLE_AGENT,
			),
			self::ROLE_ADMIN => array(
				//self::ROLE_ADMIN,
				self::ROLE_MANAGER,
				self::ROLE_BROKER,
				self::ROLE_FINBROKER,
				self::ROLE_AGENT,
			),
			self::ROLE_MANAGER => array(
				self::ROLE_BROKER,
				self::ROLE_FINBROKER,
				self::ROLE_AGENT,
			),
			self::ROLE_FINBROKER => array(
				self::ROLE_AGENT,
			),
			self::ROLE_BROKER => array(
				self::ROLE_AGENT,
			),
		);

		return (isset($roles[$roleId]) ? $roles[$roleId] : array());
	}

	public function getSubordinateRoleUsers($roleIds)
	{
		$subRoles = array();
		if (!is_array($roleIds))
		{
			$roleIds = array($roleIds);
		}

		$subRoles = array();		
		foreach($roleIds as $roleId)
		{
			foreach(self::getRoleSubroles($roleId) as $role)
			{
				$subRoles[$role] = $role;
			}
		}

		if (empty($subRoles))
		{
			return array();
		}
		$sql = 'SELECT eu.id,
                                  eu.username,
                                  eu.firstname,
                                  eu.secondname,
								  er.id as role_id,
                                  er.rolename as role,
                                  ec.city,
                                  eu.dogovor,
                                  eu.email,
								  eu.active FROM ester_users as eu, ester_city as ec, ester_rolename as er
			WHERE eu.role = er.id AND eu.city = ec.id AND eu.role IN (' . implode(',', $subRoles) . ')';
		return $this->getDI()->get('db')->fetchAll($sql); 
	}

	public function getRoleById($roleId)
	{
		$data = $this->getDI()->get('db')->fetchOne('SELECT id, rolename FROM ester_rolename WHERE id = :id', Phalcon\Db::FETCH_ASSOC, array('id' => $roleId));

		$this->id       = $data['id'];
		$this->rolename = $data['rolename'];

		return $this;
	}

    public function getAllRoles() {
		$roleIds = self::getRoleSubroles($this->id);
		if (in_array($role, array(Roles::ROLE_SUPERADMIN, Roles::ROLE_ADMIN)))
		{
			$roleIds[] = $role;
		}
        return $this->getDI()->get('db')->fetchAll('SELECT id, rolename FROM ester_rolename WHERE id IN (' . implode(',', $roleIds) . ') ORDER BY id');
    }
}
