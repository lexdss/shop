<?php
session_start();

//Define dirs
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
define('APP_DIR', ROOT_DIR . '/app/');
define('VIEW_DIR', APP_DIR . '/view/');

//Autoload
include 'autoloader.php';
spl_autoload_register('loadClass');

include 'config.php';

$service = new Service();
$service['db'] = function(){return new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;", DB_USER, DB_PASS);};
$service['product_mapper'] = function() use($service){return new ProductMapper($service->get('db'));};
$service['category_mapper'] = function() use($service){return new CategoryMapper($service->get('db'));};
$service['user_mapper'] = function() use($service){return new UserMapper($service->get('db'));};
$service['order_mapper'] = function() use($service){return new OrderMapper($service->get('db'));};
$service['auth'] = function() use($service){return new Auth($service->get('user_mapper'));};
$service['view'] = function() use($service){return new View($service);};
$service['category_validate'] = function() use($service){return new CategoryValidate($service->get('category_mapper'));};
$service['product_validate'] = function() use($service){return new ProductValidate();};
$service['user_validate'] = function() use($service){return new UserValidate($service->get('db'));};
$service['basket'] = function() use($service){return new Basket($service->get('db'));};


//$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;", DB_USER, DB_PASS);
//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);