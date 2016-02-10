<?php
class CatController extends AController{

	private $category_code;
	
	public function indexAction(){
		FrontController::get404();
	}

	//Загрузка страницы категории
	public function categoryAction($name){
		$this->category_name = $name;

		//При добавлении товара в корзину
		if($_GET['add']){
			$this->addToBasket($_GET['add']);
		}

		//Если пришел параметр, загружаем детальную страницу товара, если нет - страницу категории
		if(!empty($_GET['item_id'])){
			$this->detailProduct();
		}else{
			
			$this->view->item = $this->product_mapper->getProductFromCategory($this->category_name);
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
			FrontController::get404();
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
			header('Location: /cat/'.$this->category_name);
			exit;
		}
	}
}