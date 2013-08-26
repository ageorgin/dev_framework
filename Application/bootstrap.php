<?php 
require_once(__DIR__.'/../vendor/autoload.php');

use Composer\Autoload\ClassLoader;

// defining APPLICATION_ROOT constant
if(!defined('APPLICATION_ROOT')){
	define('APPLICATION_ROOT', __DIR__);
}

// on enregistre le répertoire des entités pour ne pas à faire de require_once
$classLoader = new ClassLoader();
$classLoader->add(null, __DIR__.'/../vendor/zendframework/zend-config');
$classLoader->add(null, __DIR__.'/..');
$classLoader->add(null, __DIR__.'/../src');
$classLoader->add(null, __DIR__.'/../vendor/twig/lib');
$classLoader->register();
$classLoader->setUseIncludePath(true);