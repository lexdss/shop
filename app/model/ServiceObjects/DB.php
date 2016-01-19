<?php

//Создание PDO объекта
class DB{

	public static $instance;

	protected function __construct(){}
	protected function __clone(){}

	public static function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;", DB_USER, DB_PASS);
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return self::$instance;
	}
}