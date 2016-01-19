<?php
class CatController extends AController{

	private $category_code;
	
	public function indexAction(){
		FrontController::page404();
	}


	//Для каждой категории выполняются одинаковые действия, чтобы не создавать одинаковые методы для каждой категории можно использовать магический метод
	public function __call($name, $args){

		//Вместо categoryAction делаем category
		$this->category_code = str_replace('Action', '', $name);

		//Получаем объект запрошенной категории или редиректим на 404 если категории нет
		if(!$category = $this->category_mapper->getCategoryFromCode($this->category_code)){
			FrontController::page404();
		}

		//При добавлении товара в корзину
		if($_GET['add']){
			$this->addToBasket($_GET['add']);
		}

		//Если пришел параметр, загружаем детальную страницу товара, если нет - страницу категории
		if(!empty($_GET['item_id'])){
			$this->detailProduct();
		}else{
			//Массив объектов товаров выбранной категории
			$this->view->item = $this->product_mapper->getProductFromCategory($category->code);
			$this->view->title = $category->title;
			$this->view->render('cat.tpl.php');
		}
	}

	private function detailProduct(){
		//Объект выбранного товара для детальной страницы
		if($item = $this->product_mapper->getFromID($_GET['item_id'])){
			$this->view->item = $item;
			$this->view->title = $item->title;
			$this->view->render('product_page.tpl.php');
		}else{
			FrontController::page404();
		}
	}

	private function addToBasket($id){
		$basket = new Basket($this->db);
		$basket->add($id);

		//Редиректим, чтобы при обновлении страницы товар не попадал в корзину заново
		if(isset($_SERVER['HTTP_REFERER'])){
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}else{
			header('Location: /cat/'.$this->category_code);
			exit;
		}
	}
}