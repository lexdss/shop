<?php

class FrontController{

	private $service;

	//Определение контроллера и экшена
	function __construct(Service $service){

		$this->service = $service;

	}
	
	//Исполнение экшена в контроллере
	public function route(){
		$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
		$request_arr = explode('/', $request);
		
		if($request == ''){
			$controller = new IndexController($this->service);
			$controller->indexAction();
		}elseif($request == 'basket'){
			$controller = new BasketController($this->service);
			$controller->indexAction();
		}elseif($request == 'auth'){
			$controller = new AuthController($this->service);
			$controller->indexAction();
		}elseif($request == 'reg'){
			$controller = new RegController($this->service);
			$controller->indexAction();
		}elseif($request == 'admin'){
			$controller = new AdminController($this->service);
			$controller->indexAction();
		}elseif($request == 'admin/additem'){
			$controller = new AdminController($this->service);
			$controller->additemAction();
		}elseif($request == 'admin/category'){
			$controller = new AdminController($this->service);
			$controller->categoryAction();
		}elseif($request == 'admin/catalog'){
			$controller = new AdminController($this->service);
			$controller->catalogAction();
		}elseif($request == 'admin/orders'){
			$controller = new AdminController($this->service);
			$controller->ordersAction();
		}elseif($request = 'cat/' . $request_arr[1]){
			$category_mapper = new CategoryMapper($this->service->get('db'));
			if(!$category_mapper->getCategoryFromCode($request_arr[1])){
				$this->get404();
			}else{
				$controller = new CatController($this->service);
				$controller->categoryAction($request_arr[1]);
			}
		}else{
			$this->get404();
		}
	}
	
	public static function get404(){
		header('HTTP/1.1 404 Page Not Found');
		include VIEW_DIR . '404page.tpl.php';
		exit;
	}
}