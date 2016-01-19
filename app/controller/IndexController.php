<?php
class IndexController extends AController{

	public function indexAction(){
		$this->view->item = $this->product_mapper->getAll(); //Выборка всех товаров
		$this->view->title = 'Главная страница'; //Title страницы
		$this->view->render('index.tpl.php');
	}
}