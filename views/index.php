<?php 
	
	ini_set('display_errors', 2);

	require_once("/vendor/autoload.php");

	$app = new \Slim\Slim();
	
	$app->config('debug', true);
	
	$app->get('/', function() {
	    
		$page = new Hcode\Page();
	
		$page->setTpl("index");
	
	});
	
	$app->run();
 