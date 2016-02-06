<?php
$class_dirs = [
	APP_DIR . '/controller/',
	APP_DIR . '/model/DataMapper/',
	APP_DIR . '/model/DomainObjects/',
	APP_DIR . '/model/ServiceObjects/',
	APP_DIR . '/model/Validate/'
];

function loadClass($class){
	global $class_dirs;
	foreach($class_dirs as $dir){
		$file_path = $dir . $class . '.php';
		if(file_exists($file_path)){
			require_once $file_path;
		}
	}
}