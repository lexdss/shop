<?php

try{

	include 'app/bootstrap.php';
	$app = new FrontController($db);
	$app->route();

}catch(Exception $e){
	error_log($e->__toString());
	header('HTTP/1.1 503 Service Unavailable');
	include VIEW_DIR . '503page.tpl.php';
}