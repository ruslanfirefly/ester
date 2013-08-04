<?php

class IndexController extends Phalcon\Mvc\Controller{

    public function initialize(){
        if(!$this->session->has("login")){
            $this->response->redirect('login/');
        }
        $this->view->setVar("topLogin", $this->session->get("login"));
        $this->view->setVar("mainTitle", 'Главная');
        if($this->session->get("role")>3){
            $this->view->setVar("menuforactionright", '');
        }else{
            $this->view->setVar("menuforactionright", '<li><a href="/accounts/">Пользователи</a> </li>');
        }
        $this->view->setVar("menuforactionmiddle", '');

    }

    public function indexAction(){

    }



}
