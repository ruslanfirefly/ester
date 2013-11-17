<?php

class AccountsController extends Phalcon\Mvc\Controller{

    public function initialize(){
        if(!$this->session->has("login")){
           $this->response->redirect('login/');
        }
		if(!in_array((int)$this->session->get("role"), array(Roles::ROLE_SUPERADMIN, Roles::ROLE_ADMIN, Roles::ROLE_MANAGER)))
		{
            $this->response->redirect('');
        }
        //дефолтные значения
        $this->view->setVar("mainTitle", 'Пользователи');
        $this->view->setVar("topLogin", $this->session->get("login"));
        $this->view->setVar("sesRole", $this->session->get("role"));
        $this->view->setVar("menuforactionmiddle", '<li><a href="/accounts/add/">Добавить пользователя.</a> </li>');
        $this->view->setVar("menuforactionright", '<li><a href="/accounts/">Пользователи</a> </li>');
    }

    public function indexAction(){
        $users = new Users();
        $this->view->setVar("users", $users->getAllUsers());
    }

    public function deleteAction($userid){
        $user = new Users();
        $user->getUserById($userid);
        if($this->session->get('role') > $user->role ){
            $this->response->redirect('');
        }
        $user->delUser($userid);
        $this->response->redirect('accounts/');
    }

    public function addAction(){
        //$this->view->setVar("topLogin", $this->session->get("login"));
        $cites = new City();
        $roles = new Roles();
        $this->view->setVar("cites", $cites->getAllCitys());
        $this->view->setVar("roles", $roles->getAllRoles());
        $user = new Users();
        $token2 ='';
        $messages = array();
        if($this->request->getMethod() === "POST"){
            $user->login = trim($this->request->getPost('login'));
            $user->firstName =  htmlspecialchars(strip_tags(mysql_real_escape_string(trim($this->request->getPost('firstname')))));
            $user->secondName = htmlspecialchars(strip_tags(mysql_real_escape_string(trim($this->request->getPost('secondname')))));
            $user->role = trim($this->request->getPost('role'));
            $user->city = trim($this->request->getPost('city'));;
            $user->dogovor = htmlspecialchars(strip_tags(trim($this->request->getPost('dogovor'))));
            $user->email = trim($this->request->getPost('email'));
            $user->active = trim($this->request->getPost('active'));
            $user->pass = trim($this->request->getPost('token'));
            $token2 = trim($this->request->getPost('token2'));

            if($user->login===''){
               $messages[] = 'Заполните поле Логин';
            }
            if(!preg_match('/^(\d|[a-z]|[A-Z]){8,}$/',$user->login)){
                $messages[] = 'Логин должен состоять из латинских символов, чисел и не менее 8 знаков';
            }
            if(!preg_match('/^(([a-zA-Z0-9_\-.]+)@([a-zA-Z0-9\-]+)\.[a-zA-Z0-9\-.]+$)/',$user->email)){
                $messages[] = 'Введите корректный Email';
            }
            if($user->pass == ''){
                $messages[] = 'Введите пароль';
            }
            if($token2 == ''){
                $messages[] = 'Введите повтор пароля';
            }
            if($user->pass !== $token2){
                $messages[] = 'Пароли не совпадают';
            }
            if(!count($messages)){
                if($user->saveNewUser()){
                    $this->response->redirect('accounts/');
                }else{
                    $messages[] = 'Такой логин уже есть';
                }
            }

        }
        $this->view->setVar("messages",$messages);
        $this->view->setVar("login",$user->login);
        $this->view->setVar("token",$user->pass);
        $this->view->setVar("token2",$token2);
        $this->view->setVar("firstname",$user->firstName);
        $this->view->setVar("curCity",$user->city);
        $this->view->setVar("dogovor",$user->dogovor);
        $this->view->setVar("secondname",$user->secondName);
        $this->view->setVar("curRole",$user->role);
        $this->view->setVar("email",$user->email);
		$this->view->setVar("active",$user->active);

		$this->view->setVar("users", $user->getAllUsers());
		//$this->view->setVar("subordinateUsers", $user->getSubordinateUsers());
    }

    public function editAction($iduser){
        $cites = new City();
        $roles = new Roles();
        $user = new Users();
		$user->getUserById($iduser);
		$role = new Roles(); 
		$role = $role->getRoleById($this->session->get('role'));

        $this->view->setVar("cites", $cites->getAllCitys());
		$this->view->setVar("roles", $role->getAllRoles()); // role with policies, roles - without

        if($role->id > $user->role){
            $this->response->redirect('');
        }
        $messages = array();
        if($this->request->getMethod() === "POST"){
            $user->firstName =  htmlspecialchars(strip_tags(mysql_real_escape_string(trim($this->request->getPost('firstname')))));
            $user->secondName = htmlspecialchars(strip_tags(mysql_real_escape_string(trim($this->request->getPost('secondname')))));
            $user->role = trim($this->request->getPost('role'));
            $user->city = trim($this->request->getPost('city'));;
            $user->dogovor = htmlspecialchars(strip_tags(trim($this->request->getPost('dogovor'))));
            $user->email = trim($this->request->getPost('email'));
            $user->active = trim($this->request->getPost('active'));
			$subordinateUsers = $this->request->getPost('subusers');
			$subordinateUsers = array_keys($subordinateUsers);

			if (!preg_match('/^[0-9]*$/', implode('', $subordinateUsers)))
			{
				$messages[] = 'Неверно указаны пользователи';
			}
            if(!preg_match('/^(([a-zA-Z0-9_\-.]+)@([a-zA-Z0-9\-]+)\.[a-zA-Z0-9\-.]+$)/',$user->email)){
                $messages[] = 'Введите корректный Email';
            }
            if(!count($messages)){
                if($user->updateUser($iduser)){
					if ($user->updateSubordinateUsers($iduser, $subordinateUsers))
					{
	                    $this->response->redirect('accounts/');
					}
					else
					{
						$messages[] = 'Ошибка при изменении списка подчиненных пользователей';
					}
                }else{
                    $messages[] = 'Ошибка при обновлении';
                }
            }
        }
        $this->view->setVar("messages",$messages);
        $this->view->setVar("login",$user->login);
        $this->view->setVar("firstname",$user->firstName);
        $this->view->setVar("curCity",$user->city);
        $this->view->setVar("dogovor",$user->dogovor);
        $this->view->setVar("secondname",$user->secondName);
        $this->view->setVar("curRole",$user->role);
        $this->view->setVar("email",$user->email);
        $this->view->setVar("active",$user->active);
        $this->view->setVar("id",$iduser);

		$subordinateRoles = array(
			Roles::ROLE_MANAGER => $roles->getSubordinateRoleUsers(Roles::ROLE_MANAGER),
			Roles::ROLE_FINBROKER => $roles->getSubordinateRoleUsers(Roles::ROLE_FINBROKER),
			Roles::ROLE_BROKER => $roles->getSubordinateRoleUsers(Roles::ROLE_BROKER),
		);
		$this->view->setVar("users", $roles->getSubordinateRoleUsers(array_keys($subordinateRoles)));
		$this->view->setVar("subordinateRoles", $subordinateRoles);
		$this->view->setVar("subordinateUsers", $user->getSubordinateUsers());
    }

    public function passeditAction($iduser){
        $user = new Users();
        $user->getUserById($iduser);
        if($this->session->get('role') > $user->role ){
            $this->response->redirect('');
        }
        $messages = array();
        if($this->request->getMethod() === "POST"){
            $user->pass = trim($this->request->getPost('token'));
            $token2 = trim($this->request->getPost('token2'));
            if($user->pass == ''){
                $messages[] = 'Введите пароль';
            }
            if($token2 == ''){
                $messages[] = 'Введите повтор пароля';
            }
            if($user->pass !== $token2){
                $messages[] = 'Пароли не совпадают';
            }
            if(!count($messages)){
                if($user->updatePassUser($iduser)){
                    $this->response->redirect('accounts/');
                }else{
                    $messages[] = 'Ошибка при обновлении';
                }
            }
        }
        $this->view->setVar("messages",$messages);
        $this->view->setVar("login",$user->login);
        $this->view->setVar("id",$iduser);

    }

}
