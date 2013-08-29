<?php

class DmsController extends Phalcon\Mvc\Controller{

    public function initialize(){
        if(!$this->session->has("login")){
            $this->response->redirect('login/');
        }
        $this->view->setVar("topLogin", $this->session->get("login"));
        $this->view->setVar("mainTitle", 'ДМС для иностранных граждан');
        if($this->session->get("role")>3){
            $this->view->setVar("menuforactionright", '');
        }else{
            $this->view->setVar("menuforactionright", '<li><a href="/accounts/">Пользователи</a> </li>');
        }
        $this->view->setVar("menuforactionmiddle", '<li><a href="/dms/add/">Добавить договор.</a> </li>');

    }

    public function indexAction(){
        echo 123;
    }
    public function AddAction(){

    }
}
