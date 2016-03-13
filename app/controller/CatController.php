<?php
class CatController extends Controller{

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
			
			$view_data['item'] = $this->service->get('product_mapper')->getProductFromCategory($this->category_name);
			$view_data['title'] = $category->title;
			$this->service->get('view')->render('cat.tpl.php', $view_data);
		}
	}

	private function detailProduct(){
		//Объект выбранного товара для детальной страницы
		if($item = $this->service->get('product_mapper')->getFromID($_GET['item_id'])){
			$view_data['item'] = $item;
			$view_data['title'] = $item->title;
			$this->service->get('view')->render('product_page.tpl.php', $view_data);
		}else{
			FrontController::get404();
		}
	}

	private function addToBasket($id){
		$this->service->get('basket')->add($id);

		//Редиректим, чтобы при обновлении страницы товар не попадал в корзину заново
		if(isset($_SERVER['HTTP_REFERER'])){
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}else{
			header('Location: /cat/' . $this->category_name);
			exit;
		}
	}
}