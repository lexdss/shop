<?php

//Сущность заказа представлену двумя таблицами в БД - order, order_product
class OrderMapper extends Mapper{

	public $table = 'order';
	public $fields = array('id', 'user_id', 'delivery', 'pay', 'total_sum', 'status', 'date');
	public $db;
	public $obj_name = 'Order';


	//Сохранение заказа
	public function save($order){

		//Массив с товарами заказа сохраняем в другой переменной и удаляем из объекта заказа т.к. они добавляются в другую таблицу
		$products = $order->products;
		unset($order->products);

		//Создание массива с плейсхолдерами
		foreach($this->fields as $field){
			$placeholders[] = ':'.$field;
		}

		$sth = $this->db->prepare("INSERT INTO `".$this->table."`(".implode($this->fields, ', ').") VALUES(".implode($placeholders, ', ').")");
		$sth->execute((array)$order);

		//Сохраняем массив с товарами заказа в другую таблицу
		foreach($products as $id => $product){
			$this->saveOrderProduct($order->id, $id, $product['price'], $product['count']);
		}
	}

	//Изменение статуса заказа
	public function changeStatus($order){
		$sth = $this->db->prepare("UPDATE `".$this->table."` SET `status` = :status WHERE `id` = :id");
		$sth->execute(array('status' => $order->status, 'id' => $order->id));
	}

	//Добавление купленных товаров в таблицу order_product
	private function saveOrderProduct($order_id, $product_id, $price, $count){
		$sth = $this->db->prepare("INSERT INTO `order_product`(`order_id`, `product_id`, `price`, `count`)
											VALUES(:order_id, :product_id, :price, :count)");
		$result = $sth->execute(array('order_id' => $order_id, 'product_id' => $product_id, 'price' => $price, 'count' => $count));
	}

	//Извлечение товаров заказа по ID заказа
	public function getOrderProduct($order_id){
		$sth = $this->db->prepare("SELECT `product_id`, `price`, `count` FROM `order_product` WHERE `order_id` = :order_id");
		$sth->execute(array('order_id' => $order_id));
		if(!empty($result = $sth->fetchAll(PDO::FETCH_ASSOC))){
			return $result;
		}else{
			return false;
		}
	}
}