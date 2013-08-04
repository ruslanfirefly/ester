<?php


class Roles extends Phalcon\Mvc\Model {

    public $role;

    public function getAllRoles(){
        return $this->getDI()->get('db')->query('SELECT id, rolename FROM ester_rolename ORDER BY id')->fetchAll();
    }
}