<?php
	
	use Lin\PhpClass\Controller\AdminController;
	use Slim\Slim;
	
	$options = [
		'mode' => 'development',
		'debug' => true
	];
	
	$app = new Slim($options);
	
	$app->config('debug', true);
	
	$app->get('/', function () {
		
		$page = new Lin\PhpClass\Controller\Controller();
		$page->setTpl('index');
		
	});
	
	$app->get('/admin', function () {
		
		$page = new AdminController();
		$page->setTpl('index');
		
	})->name('admin');
	
	
	$app->get('/admin/login', function () {
		(new Lin\PhpClass\Controller\AuthController)->login();
	});
	
	$app->post('/admin/pass', function (){
		
		try {
			(new Lin\PhpClass\Controller\AuthController)->pass();
		} catch (Exception $exception) {
			var_dump($exception);
		}
		
	});
	
	
	$app->get('/admin/logout', function () {
		(new Lin\PhpClass\Controller\AuthController)->logout();
	});
	
	/** USERS */
	$app->get('/admin/users', function () {
		(new Lin\PhpClass\Controller\UserController)->index();
	});
	
	$app->get('/admin/users/create', function () {
		(new Lin\PhpClass\Controller\UserController)->create();
	});
	
	$app->post("/admin/users/create", function () {
		(new Lin\PhpClass\Controller\UserController)->store();
	});
	
	$app->get('/admin/users/:id', function ($id) {
		$page = new Lin\PhpClass\Controller\AdminController();
		$page->setTpl('users/update');
	});
	
	$app->post('/admin/users/:id', function ($id) {
	});
	
	$app->delete('/admin/users/:id', function ($id) {
	});
	
	
	$app->run();