<?php

class FrontController{
	private $controller;
	private $action;
	private $db;
	//Определение контроллера и экшена
	function __construct(PDO $db){

		$this->db = $db;

		//Определяем контроллер и экшен
		$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$request_arr = explode('/', trim($request, '/'));
		if(!empty($request_arr[0])){
			$this->controller = ucfirst(strtolower($request_arr[0])).'Controller';
		}else{
			$this->controller = 'IndexController';
		}

		if(!empty($request_arr[1])){
			$this->action = strtolower($request_arr[1]).'Action';
		}else{
			$this->action = 'indexAction';
		}

		if(count($request_arr) > 2){
			$this->page404();
		}
	}
	
	//Исполнение экшена в контроллере
	public function route(){
		if(class_exists($this->controller)){
			$controller = new $this->controller($this->db);
			$action = $this->action;
			$controller->$action();
		}else{
			$this->page404();
		}
	}
	
	//404 страница
	public static function page404(){
		header('HTTP/1.1 404 Page Not Found');
		include VIEW_DIR.'404page.tpl.php';
		exit;
	}
}