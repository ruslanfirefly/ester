<?php


class Db extends \Phalcon\Mvc\Model{

    private static $_instance = null;

    private function __clone() {

    }


    public function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new PDO("mysql:host=localhost; dbname=ester", "root", "12345678", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }
        return self::$_instance;
    }


}