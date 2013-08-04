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
        return $this->getDI()->get('db')->query('SELECT ester_users.id,
                                  ester_users.username,
                                  ester_users.firstname,
                                  ester_users.secondname,
                                  ester_rolename.rolename as role,
                                  ester_city.city,
                                  ester_users.dogovor,
                                  ester_users.email,
                                  ester_users.active FROM ester_users, ester_city,ester_rolename
                                  WHERE ester_users.city = ester_city.id AND ester_rolename.id = ester_users.role AND  ester_users.role>='.$this->role)->fetchAll();
    }
    public function saveNewUser(){
        try{
        $this->getDI()->get('db')->beginTransaction();
        $this->getDI()->get('db')->query('INSERT INTO ester_users SET username = "'.$this->login.'",
                                                       firstname = "'.$this->firstName.'",
                                                       secondname = "'.$this->secondName.'",
                                                       role = "'.$this->role.'",
                                                       city = "'.$this->city.'",
                                                       dogovor = "'.$this->dogovor.'",
                                                       email = "'.$this->email.'",
                                                       token = "'.md5(sha1($this->pass)+md5($this->login)).'",
                                                       active = "'.$this->active.'"');
        $this->getDI()->get('db')->commit();
        return true;
        }catch (PDOException $e){
            $this->getDI()->get('db')->rollBack();
            return false;
        }
    }
    public function getUserById($id){
        $arrUser = $this->getDI()->get('db')->query('SELECT ester_users.id,
                                  ester_users.username,
                                  ester_users.firstname,
                                  ester_users.secondname,
                                  ester_users.role,
                                  ester_users.city,
                                  ester_users.dogovor,
                                  ester_users.email,
                                  ester_users.active FROM ester_users WHERE  ester_users.id = "'.$id.'" LIMIT 1')
                            ->fetch();
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
        try{
            $this->getDI()->get('db')->beginTransaction();
            $this->getDI()->get('db')->query('UPDATE ester_users SET
                                                       firstname = "'.$this->firstName.'",
                                                       secondname = "'.$this->secondName.'",
                                                       role = "'.$this->role.'",
                                                       city = "'.$this->city.'",
                                                       dogovor = "'.$this->dogovor.'",
                                                       email = "'.$this->email.'",
                                                       active = "'.$this->active.'"
                                                         WHERE id = "'.$id.'"');
            $this->getDI()->get('db')->commit();
            return true;
        }catch (PDOException $e){
            $this->getDI()->get('db')->rollBack();
            return false;
        }
    }

    public function updatePassUser($id){
        try{
            $this->getDI()->get('db')->beginTransaction();
            $this->getDI()->get('db')->query('UPDATE ester_users SET token = "'.md5(sha1($this->pass)+md5($this->login)).'" WHERE id = "'.$id.'"');
            $this->getDI()->get('db')->commit();
            return true;
        }catch (PDOException $e){
            $this->getDI()->get('db')->rollBack();
            return false;
        }
    }

    public function delUser($id){
        try{
            $this->getDI()->get('db')->beginTransaction();
            $this->getDI()->get('db')->query('DELETE FROM ester_users  WHERE id = "'.$id.'"');
            $this->getDI()->get('db')->commit();
            return true;
        }catch (PDOException $e){
            $this->getDI()->get('db')->rollBack();
            return false;
        }
    }
    public function loginUser(){
       return $this->getDI()->get('db')->query('SELECT id ,count(id) as cnt FROM ester_users WHERE
                                                         token = "'.md5(sha1($this->pass)+md5($this->login)).'"
                                                         AND username = "'.$this->login.'"
                                                         AND active = 1;')->fetch(PDO::FETCH_ASSOC);
    }
}