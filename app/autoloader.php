<?php

function loadController($class){
	$file = __DIR__.'/controller/'.$class.'.php';
	if(file_exists($file)){
		require_once $file;
	}
}

function loadMapper($class){
	$file = __DIR__.'/model/DataMapper/'.$class.'.php';
	if(file_exists($file)){
		require_once $file;
	}
}

function loadDomainObjects($class){
	$file = __DIR__.'/model/DomainObjects/'.$class.'.php';
	if(file_exists($file)){
		require_once $file;
	}
}

function loadServiceObjects($class){
	$file = __DIR__.'/model/ServiceObjects/'.$class.'.php';
	if(file_exists($file)){
		require_once $file;
	}
}

function loadValidate($class){
	$file = __DIR__.'/model/Validate/'.$class.'.php';
	if(file_exists($file)){
		require_once $file;
	}
}