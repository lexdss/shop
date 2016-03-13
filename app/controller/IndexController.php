<?php
class IndexController extends Controller{

	public function indexAction(){
		$view_data['item'] = $this->service->get('product_mapper')->getAll(); //Выборка всех товаров
		$view_data['title'] = 'Главная страница';
		$this->service->get('view')->render('index.tpl.php', $view_data);
	}
}