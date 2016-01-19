<?php
class View{

	private $db;
	public $page_template = 'page.tpl.php'; //Общий шаблон страницы (неизменяющаяся часть)
	public $category; //Массив с объектами категорий
	private $basket_info; //Общая инфа из корзины (общая сумма и общее кол-во товаров)

	public function __construct(PDO $db){
		$this->db = $db;
		
		//Выборка всех категорий для меню т.к. используются на всех страницах публичной части
		$category_mapper = new CategoryMapper($this->db);
		$this->category = $category_mapper->getAll();

		$this->basket_info = Basket::getBasketInfo();
	}

	public function render($content_template){
		require_once VIEW_DIR.$this->page_template; //Подключение общего шаблона страницы
		require_once VIEW_DIR.$content_template; //Подключение шаблона контента
		unset($_SESSION['message']); //Удаление различных сообщений выводимых на страницах
	}
}