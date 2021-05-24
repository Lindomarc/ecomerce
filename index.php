<?php
//ini_set('display_errors',2);
	
	use Slim\Slim;
	
	require_once("vendor/autoload.php");
	
	$app = new Slim;
	
	$app->config('debug', true);
	
	$app->get('/', function () {
		
		echo "OK";
		
	});
	
	$app->run();