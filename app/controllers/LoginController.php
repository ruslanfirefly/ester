<?php

class LoginController extends Phalcon\Mvc\Controller{

    public function indexAction(){
        $this->view->setVar("menuforactionright", '');
        $user = new Users();
        if($this->session->has("login")){
            $this->response->redirect('');
        }
        if($this->request->getMethod() == "POST"){
            $user->login = trim($this->request->getPost('login'));
            $user->pass = trim($this->request->getPost('pass'));
            $arrUser = $user->loginUser();
            if($arrUser['cnt']){
                $user->getUserById($arrUser['id']);
                $this->session->set("login", $user->login);
                $this->session->set("role", $user->role);
                $this->response->redirect('');
            }
        }
    }


}