<?php
	if (!isset($_SESSION)) {
		session_start();
	}
	
	ini_set('display_errors', 2);
	
	define('ROOT',__DIR__.DIRECTORY_SEPARATOR);
 	define('VIEWS',ROOT.'views'.DIRECTORY_SEPARATOR);
 	define('DEBUG', true);
	define('VIEWSCACHE',ROOT.'tmp'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
	
	require_once("vendor/autoload.php");
	
	require_once("routes/route.php");
	

	
