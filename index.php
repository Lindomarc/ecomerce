<?php
	
	//ini_set('display_errors', 2);
	
	define('ROOT',__DIR__.DIRECTORY_SEPARATOR);
 	define('VIEWS',ROOT.'views'.DIRECTORY_SEPARATOR);
	define('VIEWSCACHE',ROOT.'views-cache'.DIRECTORY_SEPARATOR);
	
	require_once("vendor/autoload.php");
	
	use Slim\Slim;
	use Lin\PhpClass\Page;
	
 	$app = new Slim;
	
	$app->config('debug', true);
	
	$app->get('/', function () {
		
		$page = new Page();
		$page->setTpl('index');
 	    
		
	});
	
	$app->run();