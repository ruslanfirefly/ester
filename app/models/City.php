<?php


class City extends Phalcon\Mvc\Model {

    public $city;

    public function getAllCitys(){
        return $this->getDI()->get('db')->fetchAll('SELECT id, city FROM ester_city ORDER BY id');
    }

}