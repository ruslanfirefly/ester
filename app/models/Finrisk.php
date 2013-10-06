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
        $newdogovor = $this->getDI()->get("db")->fetchOne("select saveDogovor(
        :familia,
        :imya,
        :otchestvo,
        :dateb,
        :tel,
        :seria_pass,
        :nomer_pass,
        :vidan_pass,
        :propiska,
        :tarif,
        :summa,
        :summa_pro,
        :premiya,
        :premiya_pro,
        :insur_from,
        :insur_to,
        :userid,
        :dogovor,
        :dog_time
        ) as newDog", Phalcon\Db::FETCH_ASSOC, array("familia"=>$this->familia,"imya"=>$this->imya,
            "otchestvo"=>$this->otchestvo,"dateb"=>$this->dateB,
            "tel"=>$this->tel,"seria_pass"=>$this->seria_pass,
            "nomer_pass"=>$this->nomer_pass,"vidan_pass"=>$this->vidan_pass,
            "propiska"=>$this->propiska,
            "tarif"=>$this->tarif,"summa"=>$this->summa,
            "summa_pro"=>$this->summa_pro,"premiya"=>$this->premiya,
            "premiya_pro"=>$this->premiya_pro,"insur_from"=>$this->insur_from,
            "insur_to"=>$this->insur_to,"userid"=>$this->user,
            "dogovor"=>$this->dogovor ,"dog_time"=>$this->time));

        $this->id =$newdogovor['newDog'];

        return $this->id;


    }

    public function getAllDogovors(){
        $role = $this->getDI()->get('session')->get("role");
        if($role<3){
            return $this->getDI()->get('db')->fetchAll('SELECT ester_finriski.id,
                                             ester_finriski.familia, ester_finriski.imya,ester_finriski.otchestvo,ester_finriski.dogovor,ester_finriski.dog_time
                                   FROM ester_finriski ORDER BY id DESC
                                  ', Phalcon\Db::FETCH_ASSOC);
        }else{
            $userid = $this->getDI()->get('session')->get("userid");
            return $this->getDI()->get('db')->fetchAll('SELECT ester_finriski.id,
                                             ester_finriski.familia, ester_finriski.imya,ester_finriski.otchestvo,ester_finriski.dogovor,ester_finriski.dog_time
                                   FROM ester_finriski WHERE userid = :id ORDER BY id DESC
                                  ', Phalcon\Db::FETCH_ASSOC, array('id'=>$userid));
        }
    }

    public function getDogById(){
        $role = $this->getDI()->get('session')->get("role");
        if($role<3){
            $dog = $this->getDI()->get('db')->fetchOne('Select * from ester_finriski where id = :id limit 1', Phalcon\Db::FETCH_ASSOC, array('id' => $this->id));
        }else{
            $userid = $this->getDI()->get('session')->get("userid");
            $dog = $this->getDI()->get('db')->fetchOne('Select * from ester_finriski where id = :id AND userid = :userid limit 1', Phalcon\Db::FETCH_ASSOC,
                array('id' => $this->id, 'userid'=>$userid));
        }
        if($dog){
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
            return true;
        }else{
            return false;
        }

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