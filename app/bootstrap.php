<?php
session_start();

//Define dirs
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
define('APP_DIR', ROOT_DIR . '/app/');
define('VIEW_DIR', APP_DIR . '/view/');

include 'config.php';

$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;", DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Autoload
include 'autoloader.php';
spl_autoload_register('loadClass');