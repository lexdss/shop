<?php
include 'app/bootstrap.php';

$app = new FrontController($db);
try{
	$app->route();
}catch(PDOException $e){
	error_log($e->getMessage());
	header('HTTP/1.1 503 Service Unavailable');
	include VIEW_DIR.'503page.tpl.php';
}