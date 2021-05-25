<?php
	
	use Lin\PhpClass\Model\User;
	use Slim\Slim;
	
	$app = new Slim;
	
	$app->config('debug', true);
	
	$app->get('/', function () {
		
		$page = new Lin\PhpClass\Page();
		$page->setTpl('index');
		
	});
	
	$app->get('/admin', function () {
		
		User::verifyLogin();
		
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
	
	/** USERS */
	$app->get('/admin/users', function () {
		User::verifyLogin();		
		$page = new Lin\PhpClass\Admin();
		$page->setTpl('users/index');
		
	});
	$app->get('/admin/users/create', function () {
		User::verifyLogin();
		$page = new Lin\PhpClass\Admin();
		$page->setTpl('users/create');
	});
	$app->post('/admin/users/create', function () {
		User::verifyLogin();
		$page = new Lin\PhpClass\Admin();
		$page->setTpl('users/create');
	});
	
	$app->get('/admin/users/:iduser', function ($iduser) {
		User::verifyLogin();
		$page = new Lin\PhpClass\Admin();
		$page->setTpl('users/update');
	});
	
	$app->post('/admin/users/:iduser', function ($iduser) {
		User::verifyLogin();
	});
	
	$app->delete('/admin/users/:iduser', function ($iduser) {
		User::verifyLogin();
	});

	
	$app->run();