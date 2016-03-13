<?php

abstract class Controller{
	public $db; //Объект PDO
	public $view; //Объект выводы вида

	//Сервисы
	public $service;
	
	abstract public function indexAction();

	public function __construct(Service $service){

		$this->service = $service;
	}
}