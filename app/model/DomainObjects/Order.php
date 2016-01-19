<?php

//Сущность заказа представлена двумя таблицами в БД - order, order_product
class Order{

	public $id;
	public $user_id;
	public $delivery;
	public $pay;
	public $total_sum;
	public $status;
	public $date;
	public $products;
}