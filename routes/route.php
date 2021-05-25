<?php
	 
	use Slim\Slim; 	
	use Lin\PhpClass\Model\User;
	
	$app = new Slim;
	
	$app->config('debug', true);
	
	$app->get('/', function () {
		
		$page = new Lin\PhpClass\Page();
		$page->setTpl('index');
		
	});
	
	$app->get('/admin', function () {
		
		//User::verifyLogin(true);
		
		$page = new Lin\PhpClass\Admin();
		$page->setTpl('index');
		
	});
	
	$app->get('/admin/login', function () {
		$options = [
			"header"=>false,
			"footer"=>false,
		];
		$page = new Lin\PhpClass\Login($options);
		$page->setTpl('login');
		
	});
	
	$app->post('/admin/login', function () {
 		var_dump(User::login($_POST['deslogin'],$_POST['despassword']));
		header("Location: /admin");
		exit;
	});
	$app->get('/admin/logout', function () {
		User::logout();
		header("Location: /admin/login");
		exit;
	});
	
	$app->run();