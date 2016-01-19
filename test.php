<form action="" method="POST">
	1: <input type="checkbox" name="name1" value="value1">
	2: <input type="checkbox" name="name2" value="value2">
	<input type="submit" name="subm" value="subm_value">
</form>
<?php

//Исправить имя таблицы категорий в маппере и домене
//Сдеелать дефолтной роль пользователя
//В таблице товаров брать не ид категории, а символьный код - исправить все урлы в связи с этим, удалить создание категории в виеве

error_reporting(-1);
include 'app/bootstrap.php';
//$db = DB::getInstance();
$db = new pdo("mysql:host=localhost;dbname=shop;charset=utf8", "root", "root");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*$sql = "CREATE TABLE `user`(
		`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`name` VARCHAR(100) NOT NULL,
		`surname` VARCHAR(100) NOT NULL,
		`email` VARCHAR(100) NOT NULL UNIQUE,
		`phone` VARCHAR(25) NOT NULL UNIQUE,
		`city` VARCHAR(100) NOT NULL,
		`adress` VARCHAR(100) NOT NULL,
		`password` VARCHAR(100) NOT NULL,
		`date` DATETIME NOT NULL,
		`role` ENUM('user', 'admin')
	)";*/

/*$sql = "CREATE TABLE `category`(
		`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`name` VARCHAR(20) NOT NULL UNIQUE,
		`code` VARCHAR(20) NOT NULL UNIQUE,
		`title` VARCHAR(150) NOT NULL
	)";*/

/*$sql = "CREATE TABLE `product`(
		`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`category` VARCHAR(20) NOT NULL,
		`name` VARCHAR(50) NOT NULL,
		`description` TEXT(4000) NOT NULL,
		`title` VARCHAR(150) NOT NULL,
		`price` DECIMAL(8,2) NOT NULL,
		`image` VARCHAR(100) NOT NULL,
		FOREIGN KEY (`category`) REFERENCES `category`(`code`) ON DELETE CASCADE
	)";*/

/*$sql = "CREATE TABLE `order`(
		`id` VARCHAR(50) NOT NULL PRIMARY KEY,
		`user_id` INT(11) NOT NULL,
		`delivery` ENUM('post', 'courier', 'delivery') NOT NULL,
		`pay` ENUM('cash', 'e-money', 'cod') NOT NULL,
		`total_sum` DECIMAL(8,2) NOT NULL,
		`status` ENUM('processing', 'sent', 'received') NOT NULL,
		`date` DATETIME NOT NULL,
		FOREIGN KEY(`user_id`) REFERENCES `user`(`id`)
	)";*/

/*$sql = "CREATE TABLE `order_product`(
		`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`order_id` VARCHAR(50) NOT NULL,
		`product_id` INT(11) NULL,
		`price` DECIMAL(8,2) NOT NULL,
		`count` INT(11) NOT NULL,
		FOREIGN KEY(`order_id`) REFERENCES `order`(`id`),
		FOREIGN KEY(`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
	)";*/
//$db->exec($sql);
//$res = $db->query($sql);

/*$product = new Product(1, 'Item3', 'Descreeee', 'Title3', 34.78, 'img/sdsdsd.jpg');
$product->id = 5;*/

/*$mapper = new OrderMapper(DB::getInstance());
$order = new Order;

$order->user_id = 1;
$order->delivery = '';
$order->pay = 'cash';
$order->total_sum = 99.99;
$order->status = 'processing'; //Статус по-умолчанию, "В обработке"
$order->date = date('Y-m-d H:i:s', time());

$res = $mapper->save($order);*/

echo '<pre>';
var_dump($res);
echo '</pre>';

$date = date("Y-m-d H:i:s", time());
var_dump($date);
echo md5('12345');
echo '<br>';
if($_POST['subm']){
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}

var_dump($_SERVER['HTTP_REFERER']);
/*$prod = new ProductMapper(DB::getInstance());
$prod->getProducts();*/
$res = file_exists('View.php');
var_dump($res);

//var_dump($obj);
//$sth = $db->query("INSERT INTO `category`(``)");
//$res = $sth->fetchAll(PDO::FETCH_ASSOC);
//print_r($res);