<?php
class AdminController extends Controller{

	public function __construct(Service $service){
			parent::__construct($service);

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
			$result = $this->service->get('product_validate')->valid($_POST);

			if(is_array($result)){
				$view_data['error'] = $result; //массив ошибок для отображения юзеру
				$view_data['value'] = $_POST; //Для заполнения формы
			}elseif(is_object($result)){
				$this->service->get('product_mapper')->save($result); //Сохраняем товар в БД
				$_SESSION['message'] = 'Товар успешно добавлен';
				header('Location: /admin/additem');
				exit;
			}
		}

		$view_data['title'] = 'Добавить товар';
		$this->service->get('view')->render('admin_add_product.tpl.php', $view_data, 'admin_page.tpl.php');
	}

	public function categoryAction(){

		//Добавление категории
		if(isset($_POST['add_category'])){
			$result = $this->service->get('category_validate')->valid($_POST);

			if(is_array($result)){
				$view_data['error'] = $result;
				$view_data['value'] = $_POST;
			}elseif(is_object($result)){
				$this->service->get('category_mapper')->save($result);
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
				$this->service->get('category_mapper')->delete($id);
			}
			$_SESSION['message'] = 'Удалено';
			header('Location: /admin/category');
			exit;
		}

		$view_data['title'] = 'Управление категориями';
		$this->service->get('view')->render('admin_category.tpl.php', $view_data, 'admin_page.tpl.php');
	}

	public function catalogAction(){

		//Выбираем все товары или из нужной категории
		if(!empty($_GET['cat'])){
			$view_data['items'] = $this->service->get('product_mapper')->getProductFromCategory($_GET['cat']);
		}else{
			$view_data['items'] = $this->service->get('product_mapper')->getAll();
		}

		//Удаление товара
		if(isset($_POST['delete_product'])){

			unset($_POST['delete_product']);
			foreach($_POST as $id){
				$this->service->get('product_mapper')->delete($id);
			}
			$_SESSION['message'] = 'Удалено';
			header('Location: /admin/catalog');
			exit;
		}
		
		$view_data['title'] = 'Каталог товаров';
		$this->service->get('view')->render('admin_catalog.tpl.php', $view_data, 'admin_page.tpl.php');
	}

	public function ordersAction(){
		//Загрузка детальной страницы заказа
		if(!empty($_GET['order'])){
			$this->orderDetail($_GET['order']);
			exit;
		}
		$view_data['orders'] = $this->service->get('order_mapper')->getAll();
		$view_data['title'] = 'Заказы';
		$this->service->get('view')->render('admin_orders.tpl.php', $view_data, 'admin_page.tpl.php');
	}

	//Детальная страница заказа
	private function orderDetail($order_id){

		if($order = $this->service->get('order_mapper')->getFromID($order_id)){
			//Получаем товары, которые есть в заказе
			$order_product = $this->service->get('order_mapper')->getOrderProduct($order->id);
			//Создаем массив объектов товаров
			foreach($order_product as $item){

				//Объект товара
				$prod = $this->service->get('product_mapper')->getFromID($item['product_id']);
				//Добавляем к нему свойство с количеством данного товара в корзине
				$prod->count = $item['count'];
				$product[] = $prod;
			}

			//POST запрос на изменение статуса заказа
			if(isset($_POST['change_order_status'])){
				$order->status = $_POST['status'];
				$this->service->get('order_mapper')->changeStatus($order);
				$_SESSION['message'] = 'Статус заказа изменен';
				header('Location: '.$_SERVER['HTTP_REFERER']);
				exit;
			}
		
			$view_data['product'] = $product;
			$view_data['order'] = $order;
			$view_data['user'] = $this->service->get('user_mapper')->getFromID($order->user_id);
		}else{
			$_SESSION['message'] = 'Такого заказа нет';
		}
		$view_data['title'] = 'Заказ '.$order->id;
		$this->service->get('view')->render('admin_detail_order.tpl.php', $view_data, 'admin_page.tpl.php');
	}
}