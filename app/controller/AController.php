<?php

abstract class AController{
	public $db; //Объект PDO
	public $view; //Объект выводы вида

	//Мапперы, которые используются в дочерних контроллерах
	public $category_mapper;
	public $user_mapper;
	public $product_mapper;
	public $order_mapper;
	
	abstract public function indexAction();

	public function __construct(PDO $db){

		//Принимаем объект БД
		$this->db = $db;
		
		//Объект вида
		$this->view = new View($this->db);

		//Мапперы
		$this->category_mapper = new CategoryMapper($this->db);
		$this->user_mapper = new UserMapper($this->db);
		$this->product_mapper = new ProductMapper($this->db);
		$this->order_mapper = new OrderMapper($this->db);		
	}
	
	//Перебрасываем на 404 если в контроллерах нет нужного экшена
	public function __call($name, $arg){
		FrontController::page404();
	}
}