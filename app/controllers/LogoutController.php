<?php


class LogoutController extends Phalcon\Mvc\Controller {

    public function indexAction(){
        $this->session->destroy();
        $this->response->redirect('');
    }

}