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


    public function getAllUsers(){
        $this->role = $this->getDI()->get('session')->get('role');
        return $this->getDI()->get('db')->fetchAll('SELECT ester_users.id,
                                  ester_users.username,
                                  ester_users.firstname,
                                  ester_users.secondname,
                                  ester_rolename.rolename as role,
                                  ester_city.city,
                                  ester_users.dogovor,
                                  ester_users.email,
                                  ester_users.active FROM ester_users, ester_city,ester_rolename
                                  WHERE ester_users.city = ester_city.id AND ester_rolename.id = ester_users.role AND  ester_users.role>= :role', Phalcon\Db::FETCH_ASSOC,
                                  array('role' => $this->role));
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
                                                        array($this->firstName,$this->secondName,$this->role,$this->city,$this->dogovor,$this->email,$this->active),
                                                        'id = "'.$id.'"');
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
}