<?php
session_start();

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