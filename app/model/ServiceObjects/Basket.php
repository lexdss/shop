<?php
class Basket{

	public $basket;
	private $product_mapper;

	public function __construct(PDO $db){
		$this->db = $db;
		$this->product_mapper = new ProductMapper($this->db);
	}

	//Добавление товара в корзину
	public function add($id){

		$this->basket = $this->getBasket();

		//Если такой товар есть в БД
		if($product = $this->product_mapper->getFromID($id)){
			$this->basket[$product->id]['name'] = $product->name;
			$this->basket[$product->id]['count'] ++; //Увеличиваем количество добавленного товара на 1
			$this->basket[$product->id]['price'] = $product->price;
			$this->saveBasket($this->basket);
		}
	}

	//Сохранение сериализованного массива корзины в cookie
	public static function saveBasket($basket){
		setcookie('basket', serialize($basket), time() + 3600, '/');
	}

	//Очистка корзины
	public static function cleanBasket(){
		setcookie('basket', null, time() - 1, '/');
	}

	//Возвращаем массив с корзиной
	public static function getBasket(){
		if(isset($_COOKIE['basket'])){
			$basket = unserialize($_COOKIE['basket']);
		}
		return $basket;
	}

	public static function deleteProductFromBasket($id){
		$basket = self::getBasket();

		//Если товар с запрашивам ID в корзине есть
		if(isset($basket[$id])){

			//Если его количество 1шт, то удаляем все данныее о товаре
			if($basket[$id]['count'] == 1){
				unset($basket[$id]);
			}else{
				//Если больше 1 шт, то изменям его количество, общую сумму и общее количество
				$basket[$id]['count'] --;
			}

			//Сохраням корзину
			self::saveBasket($basket);
			//Редиректим, чтобы при обновлении товар снова не удалялся
			header('Location: /basket');
			exit;
		}
	}

	//Возвращает общую сумму и количество товаров в корзине
	public static function getBasketInfo(){
		$basket = self::getBasket();
		if(empty($basket)){
			$basket_info['total_sum'] = 0;
			$basket_info['total_count'] = 0;
		}else{
			foreach($basket as $item){
				$basket_info['total_sum'] += $item['count'] * $item['price'];
				$basket_info['total_count'] += $item['count'];
			}
		}
		return $basket_info;
	}
}