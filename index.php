<?php
	
//	ini_set('display_errors', 2);
	
	require_once("vendor/autoload.php");
	use Slim\Slim;
	use PdoConnect\DB\Sql;
	
	$app = new Slim;
	
	$app->config('debug', true);
	
	$app->get('/', function () {
		
 		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_users");
		header('Content-Type: application/json');		
		echo json_encode($results,true);
		
	});
	
	$app->run();