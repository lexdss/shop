<?php
class View{

	private $db;
	public $category; //Массив с объектами категорий
	private $basket_info; //Общая инфа из корзины (общая сумма и общее кол-во товаров)

	public function __construct(Service $service){
		$this->db = $db;
		
		//Выборка всех категорий для меню т.к. используются на всех страницах публичной части
		$this->category = $service->get('category_mapper')->getAll();
		$this->basket_info = Basket::getBasketInfo();
	}

	public function render($content_template, $data = null, $page_template = 'page.tpl.php'){
		if(!empty($data)){
			extract($data);
		}
		require_once VIEW_DIR . $page_template; //Подключение общего шаблона страницы
		require_once VIEW_DIR . $content_template; //Подключение шаблона контента
		unset($_SESSION['message']); //Удаление различных сообщений выводимых на страницах
	}
}