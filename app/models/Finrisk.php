<?php

class Finrisk extends Phalcon\Mvc\Model{

    public $id;
    public $familia;
    public $imya;
    public $otchestvo;
    public $dateB;
    public $tel;
    public $seria_pass;
    public $nomer_pass;
    public $vidan_pass;
    public $propiska;
    public $tarif;
    public $summa;
    public $summa_pro;
    public $premiya;
    public $premiya_pro;
    public $insur_from;
    public $insur_to;
    public $user;
    public $dogovor;
    public $time;


    public function saveDogovorFinRisk(){
        $dog = $this->getDI()->get('db')->fetchOne("select dogovor from ester_dogovors_finrisk limit 1", Phalcon\Db::FETCH_ASSOC);
        $this->dogovor = $dog["dogovor"];

        $this->getDI()->get("db")->insert("ester_finriski",
            array($this->familia,$this->imya,$this->otchestvo,$this->dateB,$this->tel,$this->seria_pass,$this->nomer_pass,$this->vidan_pass,$this->propiska,
                $this->tarif,$this->summa,$this->summa_pro,$this->premiya,$this->premiya_pro,$this->insur_from,$this->insur_to, $this->user, $this->dogovor, $this->time),
            array("familia","imya","otchestvo","dateb","tel","seria_pass","nomer_pass","vidan_pass","propiska",
                "tarif","summa","summa_pro","premiya","premiya_pro","insur_from","insur_to","userid", "dogovor" ,"dog_time")
        );
        $this->id = $this->getDI()->get("db")->lastInsertId();
        return $this->id;
    }
    public function getAllDogovors(){
       return $this->getDI()->get('db')->fetchAll('SELECT ester_finriski.id,
                                             ester_finriski.familia, ester_finriski.imya,ester_finriski.otchestvo,ester_finriski.dogovor,ester_finriski.dog_time
                                   FROM ester_finriski
                                  ', Phalcon\Db::FETCH_ASSOC);
    }
    public function getDogById(){
         $dog = $this->getDI()->get('db')->fetchOne('Select * from ester_finriski where id = :id limit 1', Phalcon\Db::FETCH_ASSOC, array('id' => $this->id));
        $this->familia = $dog["familia"];
        $this->imya =  $dog["imya"];
        $this->otchestvo = $dog["otchestvo"];
        $this->dateB = $dog["dateb"];
        $this->tel = $dog["tel"];
        $this->seria_pass = $dog["seria_pass"];
        $this->nomer_pass = $dog["nomer_pass"];
        $this->vidan_pass = $dog["vidan_pass"];
        $this->propiska = $dog["propiska"];
        $this->tarif = $dog["tarif"];
        $this->summa = $dog["summa"];
        $this->summa_pro = $dog["summa_pro"];
        $this->insur_from = $dog["insur_from"];
        $this->insur_to = $dog["insur_to"];
        $this->premiya = $dog["premiya"];
        $this->premiya_pro =$dog["premiya_pro"];
        $this->time = $dog["dog_time"];
        $this->user =$dog["userid"];
        $this->dogovor = $dog["dogovor"];

    }
    public function updateDogovorFinRisk(){

       return $this->getDI()->get("db")->update("ester_finriski",
            array("familia","imya","otchestvo","dateb","tel","seria_pass","nomer_pass","vidan_pass","propiska",
                "tarif","summa","summa_pro","premiya","premiya_pro","insur_from","insur_to"),
            array($this->familia,$this->imya,$this->otchestvo,$this->dateB,$this->tel,$this->seria_pass,$this->nomer_pass,$this->vidan_pass,$this->propiska,
                $this->tarif,$this->summa,$this->summa_pro,$this->premiya,$this->premiya_pro,$this->insur_from,$this->insur_to),
           "id = ".$this->id
        );

    }
}