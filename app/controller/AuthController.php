<?php

class AuthController extends Controller{

	public function indexAction(){
		if(isset($_POST['login'])){
			if(empty($_POST['email']) || empty($_POST['password'])){
				$_SESSION['message'] = 'Введите логин и пароль';
			}else{
				$this->service->get('auth')->login($_POST);
			}
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}

		//Выход
		if(isset($_GET['act']) | $_GET['act'] == 'logout'){
			session_unset();
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}

		//Контроллер только для обработки POST запроса на авторизацию и GET на выход, при другом GET запросе - 404 страница
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			FrontController::get404();
		}
	}
}