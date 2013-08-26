<?php
use Application\Router;

require_once(__DIR__.'/../Application/bootstrap.php');

// routage des url
try{
	$router = new Router();
	$router->route();
}catch (Exception $e){
	header('HTTP/1.1 404');
	echo $e->getMessage();
}