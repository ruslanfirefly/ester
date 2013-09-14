<?php
use Phalcon\Validation\Validator\PresenceOf;


class FinriskiController extends Phalcon\Mvc\Controller {

    public function initialize(){
        if(!$this->session->has("login")){
            $this->response->redirect('login/');
        }
        $this->view->setVar("topLogin", $this->session->get("login"));
        $this->view->setVar("mainTitle", 'Финансовые риски');
        if($this->session->get("role")>3){
            $this->view->setVar("menuforactionright", '');
        }else{
            $this->view->setVar("menuforactionright", '<li><a href="/accounts/">Пользователи</a> </li>');
        }
        $this->view->setVar("menuforactionmiddle", '<li><a href="/finriski/add/">Добавить договор.</a> </li>');
    }

    public function indexAction(){
        echo 123;
    }
    public  function addAction(){
        $dogovor = new Finrisk();
        $message = array();
        $m ='';
        if($this->request->isPost()){
            $validator = new Phalcon\Validation();
            $validator->add("fam",new PresenceOf(array( "message" => "Заполните поле фамилия!" )));
            $validator->add("imya",new PresenceOf(array( "message" => "Заполните поле имя!" )));
            $validator->add("otchestvo",new PresenceOf(array( "message" => "Заполните поле отчество!" )));
            $validator->add("dateb",new PresenceOf(array( "message" => "Заполните поле День рождения!" )));
            $validator->add("tel",new PresenceOf(array( "message" => "Заполните поле телефон!" )));
            $validator->add("seria",new PresenceOf(array( "message" => "Заполните поле серию паспорта!" )));
            $validator->add("nomer",new PresenceOf(array( "message" => "Заполните поле номер паспорта!" )));
            $validator->add("pass_vidan",new PresenceOf(array( "message" => "Заполните поле кем и когда выдан паспорт!" )));
            $validator->add("adress",new PresenceOf(array( "message" => "Заполните поле адрес!" )));
            $validator->add("summa",new PresenceOf(array( "message" => "Заполните поле страховая  сумма!" )));
            $validator->add("summa_pro",new PresenceOf(array( "message" => "Заполните поле страховая  сумма прописью!" )));
            $validator->add("start_insur",new PresenceOf(array( "message" => "Заполните поле начало периода страхования!" )));
            $validator->add("end_insur",new PresenceOf(array( "message" => "Заполните поле конец периода страхования!" )));
            $validator->add("premiya",new PresenceOf(array( "message" => "Заполните поле страховая премия!" )));
            $validator->add("premiya_pro",new PresenceOf(array( "message" => "Заполните поле страховая премия прописью!" )));
            $message = $validator->validate($_POST);

            $start = DateTime::createFromFormat('d/m/Y',$this->request->getPost("start_insur"));
            $end = DateTime::createFromFormat('d/m/Y',$this->request->getPost("end_insur"));
            $range = $end->getTimestamp() - $start->getTimestamp();

            $dogovor->user = $this->session->get('userid');
            $dogovor->familia = $this->request->getPost("fam");
            $dogovor->imya = $this->request->getPost("imya");
            $dogovor->otchestvo = $this->request->getPost("otchestvo");
            $dogovor->dateB = $this->request->getPost("dateb");
            $dogovor->tel = $this->request->getPost("tel");
            $dogovor->seria_pass = $this->request->getPost("seria");
            $dogovor->nomer_pass = $this->request->getPost("nomer");
            $dogovor->vidan_pass = $this->request->getPost("pass_vidan");
            $dogovor->propiska = $this->request->getPost("adress");
            $dogovor->tarif = $this->request->getPost("tariff");
            $dogovor->summa = $this->request->getPost("summa");
            $dogovor->summa_pro = $this->request->getPost("summa_pro");
            $dogovor->insur_from = $this->request->getPost("start_insur");
            $dogovor->insur_to = $this->request->getPost("end_insur");
            $dogovor->premiya = $this->request->getPost("premiya");
            $dogovor->premiya_pro = $this->request->getPost("premiya_pro");
            if(!count($message) && $range){
                $test = 'win';
            }else{
                $test = 'fail';
            }
        }
        $this->view->setVar("dogovor", $dogovor);
        $this->view->setVar("messages", $message);
        $this->view->setVar("m", $range);
        $this->view->setVar("test", $test);
    }

}