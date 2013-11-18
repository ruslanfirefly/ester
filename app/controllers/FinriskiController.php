<?php
use Phalcon\Validation\Validator\PresenceOf as PresenceOf;

class FinriskiController extends Phalcon\Mvc\Controller {

    public function initialize(){
        if(!$this->session->has("login")){
            $this->response->redirect('login/');
        }
		$user = new Users();
		$user->getUserById($this->session->get('userid'));
		$this->view->setVar('currentUser', $user);

        $this->view->setVar("topLogin", $this->session->get("login"));
		$this->view->setVar("mainTitle", 'Финансовые риски');


        if(!in_array($this->session->get("role"), array(Roles::ROLE_SUPERADMIN, Roles::ROLE_ADMIN))) {
            $this->view->setVar("menuforactionright", '');
        }else{
            $this->view->setVar("menuforactionright", '<li><a href="/accounts/">Пользователи</a> </li>');
        }
        $this->view->setVar("menuforactionmiddle", '<li><a href="/finriski/add/">Добавить договор.</a> </li>');
    }

    public function indexAction(){
		$dogovors = new Finrisk();
		$currentPage = (isset($_GET['page']) ? ((int) $_GET['page']) : 1);
		$allDogovors = $dogovors->getAllDogovors();
		var_dump($allDogovors);
		$paginator = new \Phalcon\Paginator\Adapter\NativeArray(
			array(
				"data" => $allDogovors,
				"limit" =>15 ,
				"page" => $currentPage,
			)
		);

		$this->view->setVar("page", $paginator->getPaginate());
    }

    public  function addAction(){
        $this->di->get('db')->begin();
        $dogovor = new Finrisk();
        $message = array();
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

            if($this->request->getPost('start_insur') && $this->request->getPost('end_insur') ){
                $start = DateTime::createFromFormat('d/m/Y',$this->request->getPost("start_insur"));
                $end = DateTime::createFromFormat('d/m/Y',$this->request->getPost("end_insur"));
                $range = $end->getTimestamp() - $start->getTimestamp();
            }

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
            $dogovor->time = date('d/m/Y', time());
            if(!count($message) && $range){
                if($dogovor->saveDogovorFinRisk()){
                    $this->response->redirect("finriski/");
                }else{
                    $error =true;
                }
            }
        }
        $this->view->setVar("test",$dogovor->id);
        $this->view->setVar("dogovor", $dogovor);
        $this->view->setVar("messages", $message);
        $this->view->setVar("m", $range);
        $this->view->setVar("error", $error);

    }

    public function printAction($id=false){
        if (!$id || !preg_match('/^\d{1,}$/',$id)){
            $this->response->redirect('finriski/');
        }
        $dog = new Finrisk();
        $dog->id = $id;
        $dog->getDogById();
                $temp1 =explode('/',$dog->insur_from);
                $temp2 =explode('/',$dog->insur_to);
                $temp3 =explode('/',$dog->time);
                try{
                $document = new DocumentOpenXML('../app/lib/polisFR.docx');
                $documentData = array(
                    't1'        => $dog->dogovor,
                    't2' => $temp3[0].' '.LibFunc::month($temp3[1]).' '.$temp3[2].'г.',
                    't3'      => $dog->familia,
                    't4'         => $dog->imya,
                    't5'    => $dog->otchestvo,
                    't6'     => $dog->propiska,
                    't7'         => $temp1[0],
                    't8'       => LibFunc::month($temp1[1]),
                    't9'        => $temp1[2],
                    't010'         => $temp2[0],
                    't011'       => LibFunc::month($temp2[1]),
                    't012'        => $temp2[2],
                    't013'        => $dog->summa,
                    't014'    => $dog->summa_pro,
                    't015'      => $dog->premiya,
                    't016'  => $dog->premiya_pro,
                    't017'   => $dog->seria_pass,
                    't018'   => $dog->nomer_pass,
                    't019'   => $dog->vidan_pass,
                    't020'        => $dog->dateB,
                    't021'      => $dog->tel,
                );
               $document->set($documentData);
               $this->response->setHeader('Content-type','application/msword');
               $this->response->setHeader('Content-Disposition','attachment; filename="polis_fin_riski.docx"');
               echo $document;
                }catch (Exception $e){
                    echo $e->getMessage();
                }
    }

    public function editAction($id=false){
        if (!$id || !preg_match('/^\d{1,}$/',$id)){
            $this->response->redirect('finriski/');
        }
        $dogovor = new Finrisk();
        $dogovor->id = $id;
        if(!$dogovor->getDogById()){
            $this->response->redirect('finriski/');
        }
		$user = new Users();
		$user->getUserById($dogovor->user);
        $message = array();
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

            if($this->request->getPost('start_insur') && $this->request->getPost('end_insur') ){
                $start = DateTime::createFromFormat('d/m/Y',$this->request->getPost("start_insur"));
                $end = DateTime::createFromFormat('d/m/Y',$this->request->getPost("end_insur"));
                $range = $end->getTimestamp() - $start->getTimestamp();
            }


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
                if($dogovor->updateDogovorFinRisk()){
                    $this->response->redirect("finriski/");
                }else{
                    $error =true;
                }
            }
        }
        $this->view->setVar("dogovor", $dogovor);
		$this->view->setVar('dogovorUser', $dogovorUser);
        $this->view->setVar("messages", $message);
        $this->view->setVar("m", $range);
        $this->view->setVar("error", $error);
    }

}
