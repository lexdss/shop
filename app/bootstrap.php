<?php
session_start();
//Папки из которых будут подключаться файлы
/*set_include_path(
				 PATH_SEPARATOR.'app/model'
				.PATH_SEPARATOR.'app/view'
				.PATH_SEPARATOR.'app/controller'
				.PATH_SEPARATOR.'app/model/DataMapper'
				.PATH_SEPARATOR.'app/model/DomainObjects'
				.PATH_SEPARATOR.'app/model/ServiceObjects'
				.PATH_SEPARATOR.'app/model/Validate'
				);*/
//Подключение конфига
include 'config.php';

$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;", DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Автозагрузка классов
include 'autoloader.php';
spl_autoload_register('loadController');
spl_autoload_register('loadMapper');
spl_autoload_register('loadDomainObjects');
spl_autoload_register('loadServiceObjects');
spl_autoload_register('loadValidate');