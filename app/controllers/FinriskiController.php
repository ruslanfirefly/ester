<?php
use Phalcon\Validation\Validator\PresenceOf as PresenceOf;

class FinriskiController extends Phalcon\Mvc\Controller {

	public function initialize()
	{
        if(!$this->session->has("login")){
            $this->response->redirect('login/');
        }
		$user = new Users();
		$user->getUserById($this->session->get('userid'));
		$this->view->setVar('currentUser', $user);

        $this->view->setVar("topLogin", $this->session->get("login"));
		$this->view->setVar("mainTitle", 'Финансовые риски');


		$subRoles = Roles::getRoleSubroles($this->session->get("role"));
        if(empty($subRoles)){
            $this->view->setVar("menuforactionright", '');
        }else{
            $this->view->setVar("menuforactionright", '<li><a href="/accounts/">Пользователи</a> </li>');
        }
        $this->view->setVar("menuforactionmiddle", '<li><a href="/finriski/add/">Добавить договор.</a> </li>');
    }

	public function indexAction()
	{
		$dogovors = new Finrisk();
		$filter      = (isset($_GET['filter']) ? $_GET['filter'] : array());
		$currentPage = (isset($_GET['filter']['page']) ? ((int) $_GET['filter']['page']) : 1);

		// Convert to array with keys Y,m,d for request
		if (!empty($filter['date']['from']))
		{
			$filter['date']['from']  = array_combine(array('d', 'm', 'Y'), explode('/', $filter['date']['from']));
		}
		if (!empty($filter['date']['until']))
		{
			$filter['date']['until'] = array_combine(array('d', 'm', 'Y'), explode('/', $filter['date']['until']));
		}
		$allDogovors = $dogovors->getAllDogovors($filter);

		if (is_array($filter['date']['from']))  $filter['date']['from']  = implode('/', $filter['date']['from']);
		if (is_array($filter['date']['until'])) $filter['date']['until'] = implode('/', $filter['date']['until']);
		$paginator = new \Phalcon\Paginator\Adapter\NativeArray(
			array(
				"data" => $allDogovors,
				"limit" =>15 ,
				"page" => $currentPage,
			)
		);

		$this->view->setVar("page", $paginator->getPaginate());
		$this->view->setVar('filter', $filter);
    }

	public  function addAction()
	{
        $this->di->get('db')->begin();
        $dogovor = new Finrisk();
		$user = new Users();
		$user->getUserById($this->session->get('userid'));
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
			if ($user->tariff_rate == NULL)
			{
	            $dogovor->tarif = $this->request->getPost("tariff");
			}
			else
			{
				$dogovor->tarif = $user->tariff_rate;
			}
            $dogovor->summa = $this->request->getPost("summa");
            $dogovor->summa_pro = $this->request->getPost("summa_pro");
            $dogovor->insur_from = $this->request->getPost("start_insur");
            $dogovor->insur_to = $this->request->getPost("end_insur");
            $dogovor->premiya = $this->request->getPost("premiya");
            $dogovor->premiya_pro = $this->request->getPost("premiya_pro");
            $dogovor->time = date('d/m/Y', time());
			$dogovor->cooperative  = $this->request->getPost('cooperative');
			$dogovor->performer    = $this->request->getPost('performer');
			$dogovor->deposit_type = $this->request->getPost('deposit_type');
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

	public function printAction($id=false)
	{
		$type = isset($_GET['type']) ? $_GET['type'] : 'polis';
		if (!$id || !preg_match('/^\d{1,}$/',$id))
		{
            $this->response->redirect('finriski/');
        }
		$user = new Users();
		$user->getUserById($this->session->get('userid'));

		$agentBasis  = 'договора №';
		$checkLength = strlen($agentBasis);
		$agentBasis .= $user->dogovor;
		if (!isset($user->dogovor) || empty($user->dogovor))
		{
			$ordinatedUser = new Users();
			foreach($user->subordinatedTo as $user_id)
			{
				$ordinatedUser->getUserById($user_id);
				if (isset($user->dogovor) && (!empty($user->dogovor)))
				{
					$agentBasis = 'договора №' . $ordinatedUser->dogovor;
					break;
				}
			}
		}

		if (strlen($agentBasis) <= $checkLength)
		{
			$this->response->redirect('finriski/');
		}


        $dog = new Finrisk();
        $dog->id = $id;
        $dog->getDogById();
                $period_start = array_combine(array('d', 'm', 'Y'), explode('/',$dog->insur_from));
                //$period_end  = array_combine(array('d', 'm', 'Y'), explode('/',$dog->insur_to));
				$period_end   = array_combine(array('d', 'm', 'Y'), explode('.', date('d.m.Y', 
					strtotime('+1 YEAR -1 DAY', mktime(0, 0, 0, $period_start['m'], $period_start['d'], $period_start['Y']))
				)));
                $dogtime      = array_combine(array('d', 'm', 'Y'), explode('/',$dog->time));

				$current_date   = array_combine(array('Y', 'm', 'd'), explode('.', date("Y.m.d")));
				$single_payment = array_combine(array('Y', 'm', 'd'), explode('.', date("Y.m.d", strtotime("NOW +5 DAY"))));

				$summa   = floatval($dog->summa);
				$summa   = number_format($summa, 2, ',', ' ')   . ' (' . preg_replace('/ (рубл[^ ]+)/ui', ') $1', $dog->summa_pro);
				$premiya = floatval($dog->premiya);
				$premiya = number_format($premiya, 2, ',', ' ') . ' (' . preg_replace('/ (рубл[^ ]+)/ui', ') $1', $dog->premiya_pro);
				$months  = ''; // date period as 12 (Двенадцать) месяцев . ', ';

                try{
				switch($type)
				{
					case 'polis_dogovor':
	                	$filename = '../app/lib/polisFR_and_other.docx';
						break;
					case 'polis':
					default:
	                	$filename = '../app/lib/polisFR.docx';
				}
				$document = new DocumentOpenXML($filename);
						
                $documentData = array(
                    't1'   => $dog->dogovor,
                    't2'   => $dogtime['d'].' '.LibFunc::month($dogtime['m']).' '.$dogtime['Y'].'г.',
                    't3'   => $dog->familia,
                    't4'   => $dog->imya,
                    't5'   => $dog->otchestvo,
                    't6'   => $dog->propiska,
					'cooperative' => $dog->cooperative, //'_cooperative_',
					'performer'   => $dof->performer, //'_performer_',
					//'months' => $months,
                    //'t7'   => $period_start['d'],
                    //'t8'   => LibFunc::month($period_start['m']),
                    //'t9'   => $period_start['Y'],
                    //'t10' => $period_end['d'],
                    //'t11' => LibFunc::month($period_end['m']),
                    //'t12' => $period_end['Y'],
                    'payment' => $summa, //number_format($dog->summa, ',', ' ', 2),
					'franshiza' => '0 (Ноль) рублей 00 копеек',//'_franshiza_',
                    //'t014' => $dog->summa_pro,
                    'payment_premium' => $premiya, //number_format($dog->premiya, ',', ' ', 2),
                    //'t016' => $dog->premiya_pro,
                    't017' => $dog->seria_pass,
                    't018' => $dog->nomer_pass,
                    't019' => $dog->vidan_pass,
                    't020' => $dog->dateB,
                    't021' => $dog->tel,

					't1_no' => trim(preg_replace('/^.*№/ui', '', $dog->dogovor)),

					'agentname' => $user->firstName . ' ' . $user->secondName, // . ' ' $user->{third name?},
					'agentbasis' => $agentBasis, // Договор, если нет - фин.брокерский договор, тольео его и не выше

					//'client'    => '_client_',
					'clientname' => $dog->familia . ' ' . $dog->imya . ' ' . $dog->otchestvo,
					'clientbasis' => 'Паспорта серия ' . $doc->seria_pass . ' номер ' . $doc->nomer_pass, // Паспорт Но

					'dog_date'  => $dogtime['d'] . '.' . $dogtime['m'] . '.' . substr($dogtime['Y'], -2),
					  'dog_day'   => $dogtime['d'],
					  'dog_month' => LibFunc::month($dogtime['m']),
					  'dog_year'  => $dogtime['Y'],

					'deposit_type' => $doc->deposit_type,

					'period_start_day'   => $period_start['d'],
					'period_start_month' => LibFunc::month($period_start['m']),
					'period_start_year'  => $period_start['Y'],

					'period_end_day'   => $period_end['d'],
					'period_end_month' => LibFunc::month($period_end['m']),
					'period_end_year'  => $period_end['Y'],

					// Сдвиг платежа на пять дней, 
					'sinpay_day'     => $single_payment['d'],
					'sinpay_month'   => LibFunc::month($single_payment['m']),
					'sinpay_year'    => $single_payment['Y'],
					'single_payment' => $premiya, //'_single_payment_', // dog->payment_premium

					'current_date'  => $current_date['d'] . '.' . $current_date['m'] . '.' . substr($current_date['Y'], -2),
					'profit_summ'   => $summa, //'_profit_summ_', // equal to dog->summa

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
            $validator->add("cooperative",new PresenceOf(array( "message" => "Заполните поле Кооператив!" )));
            $validator->add("performer",new PresenceOf(array( "message" => "Заполните поле Исполнитель КПК!" )));
            $validator->add("deposit_type",new PresenceOf(array( "message" => "Заполните поле Вид вклада!" )));
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
			if ($user->tariff_rate == null)
			{
	            $dogovor->tarif = $this->request->getpost("tariff");
			}
			else
			{
				$dogovor->tarif = $user->tariff_rate;
			}
            $dogovor->summa = $this->request->getPost("summa");
            $dogovor->summa_pro = $this->request->getPost("summa_pro");
            $dogovor->insur_from = $this->request->getPost("start_insur");
            $dogovor->insur_to = $this->request->getPost("end_insur");
            $dogovor->premiya = $this->request->getPost("premiya");
            $dogovor->premiya_pro = $this->request->getPost("premiya_pro");

			$dogovor->cooperative  = $this->request->getPost('cooperative');
			$dogovor->performer    = $this->request->getPost('performer');
			$dogovor->deposit_type = $this->request->getPost('deposit_type');

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
