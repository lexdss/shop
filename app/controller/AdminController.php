<?php
class AdminController extends AController{
	private $product;
	private $category;
	private $order;

	public function __construct(PDO $db){
			parent::__construct($db);

			//Меняем общий шаблон страниц на шаблон для админки
			$this->view->page_template = 'admin_page.tpl.php';

			//Вход в этот раздел только админам
			if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
				echo "Вы не имеете доступа в этот раздел";
				exit;
			}
		}
	
	public function indexAction(){
		//При входе в админку рдеректим на страницу добавления товара
		header('Location: /admin/additem');
		exit;
	}
	
	public function additemAction(){

		if(isset($_POST['add_product'])){

			//Отправляем полученные данные на валидацию
			$product_validate = new ProductValidate;
			$result = $product_validate->valid($_POST);

			if(is_array($result)){
				$this->view->error = $result; //массив ошибок для отображения юзеру
				$this->view->value = $_POST; //Для заполнения формы
			}elseif(is_object($result)){
				$this->product_mapper->save($result); //Сохраняем товар в БД
				$_SESSION['message'] = 'Товар успешно добавлен';
				header('Location: /admin/additem');
				exit;
			}
		}

		$this->view->title = 'Добавить товар';
		$this->view->render('admin_add_product.tpl.php');
	}

	public function categoryAction(){

		//Добавление категории
		if(isset($_POST['add_category'])){
			$category_valid = new CategoryValidate($this->category_mapper);
			$result = $category_valid->valid($_POST);

			if(is_array($result)){
				$this->view->error = $result;
				$this->view->value = $_POST;
			}elseif(is_object($result)){
				$this->category_mapper->save($result);
				$_SESSION['message'] = 'Категория успешно добавлена';
				header('Location: /admin/category');
				exit;
			}
		}

		//Удаление категории
		if(isset($_POST['delete_category'])){

			//Удаляем из массива POST элемент с кнопкой, чтобы остались только категории, которые нужно удалить
			unset($_POST['delete_category']);

			//Удаляем выбранныее категории
			foreach($_POST as $id){
				$this->category_mapper->delete($id);
			}
			$_SESSION['message'] = 'Удалено';
			header('Location: /admin/category');
			exit;
		}

		$this->view->title = 'Управление категориями';
		$this->view->render('admin_category.tpl.php');
	}

	public function catalogAction(){

		//Выбираем все товары или из нужной категории
		if(!empty($_GET['cat'])){
			$this->view->items = $this->product_mapper->getProductFromCategory($_GET['cat']);
		}else{
			$this->view->items = $this->product_mapper->getAll();
		}

		//Удаление товара
		if(isset($_POST['delete_product'])){

			unset($_POST['delete_product']);
			foreach($_POST as $id){
				$this->product_mapper->delete($id);
			}
			$_SESSION['message'] = 'Удалено';
			header('Location: /admin/catalog');
			exit;
		}
		
		$this->view->title = 'Каталог товаров';
		$this->view->render('admin_catalog.tpl.php');
	}

	public function ordersAction(){
		//Загрузка детальной страницы заказа
		if(!empty($_GET['order'])){
			$this->orderDetail($_GET['order']);
			exit;
		}
		$this->view->orders = $this->order_mapper->getAll();
		$this->view->title = 'Заказы';
		$this->view->render('admin_orders.tpl.php');
	}

	//Детальная страница заказа
	private function orderDetail($order_id){

		if($order = $this->order_mapper->getFromID($order_id)){
			//Получаем товары, которые есть в заказе
			$order_product = $this->order_mapper->getOrderProduct($order->id);
			//Создаем массив объектов товаров
			foreach($order_product as $item){

				//Объект товара
				$prod = $this->product_mapper->getFromID($item['product_id']);
				//Добавляем к нему свойство с количеством данного товара в корзине
				$prod->count = $item['count'];
				$product[] = $prod;
			}

			//POST запрос на изменение статуса заказа
			if(isset($_POST['change_order_status'])){
				$order->status = $_POST['status'];
				$this->order_mapper->changeStatus($order);
				$_SESSION['message'] = 'Статус заказа изменен';
				header('Location: '.$_SERVER['HTTP_REFERER']);
				exit;
			}
		
			//Товары
			$this->view->product = $product;
			//Данные заказа
			$this->view->order = $order;
			//Данные покупателя
			$this->view->user = $this->user_mapper->getFromID($order->user_id);
		}else{
			$_SESSION['message'] = 'Такого заказа нет';
		}
		$this->view->title = 'Заказ '.$order->id;
		$this->view->render('admin_detail_order.tpl.php');
	}
}