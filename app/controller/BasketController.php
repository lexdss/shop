<?php
class BasketController extends Controller{

	public function indexAction(){

		$basket = Basket::getBasket();
		
		//При удалении товара
		if($_GET['del_item']){
			Basket::deleteProductFromBasket($_GET['del_item']);
		}

		//Подтверждеение заказа
		if($_POST['confirm_order']){

			//Для получеения общей суммы заказа
			$basket_info = Basket::getBasketInfo();

			//Создаем и заполняем доменный объект заказа
			$order = new Order;
			$order->id = uniqid(); //ID (Primary Key) для заказов генерируем сами
			$order->user_id = intval($_SESSION['user_id']);
			$order->delivery = $_POST['delivery'];
			$order->pay = $_POST['pay'];
			$order->total_sum = $basket_info['total_sum'];
			$order->status = 'processing'; //Статус по-умолчанию, "В обработке"
			$order->date = date('Y-m-d H:i:s', time());
			$order->products = $basket;

			//Сохраняем заказ
			$this->service->get('order_mapper')->save($order);

			//Очищаем корзину и редиректим
			Basket::cleanBasket();
			$_SESSION['message'] = 'Спасибо за покупку. Ваш заказ принят в обработку. Данные отправлены на почту';
			header('Location: /basket');
			exit;
		}

		$view_data['basket'] = $basket;
		$view_data['title'] = 'Корзина покупателя';
		$this->service->get('view')->render('basket.tpl.php', $view_data);
	}
}