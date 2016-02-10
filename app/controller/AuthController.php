<?php

class AuthController extends AController{

	public function indexAction(){
		if(isset($_POST['login'])){
			$auth = new Auth($this->user_mapper);
			$auth->login($_POST);
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