<?php

	use Lin\PhpClass\Controller\AdminController;
	use Lin\PhpClass\Controller\UserController;
	use Lin\PhpClass\Controller\Page;
 
	
	$options = [
		'mode' => 'development',
		'debug' => true
	];
	
//	$app = new Slim($options);
	
//	$app->config('debug', true);
	
	$app->get('/', function () {		
		(new Page([]))->index();		
	});
	
	$app->get('/admin', function () {
		
		$page = new AdminController();
		$page->setTpl('index');
		
	});
	
	
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
		(new UserController)->index();
	});
	
	$app->get('/admin/users/create', function () {
		(new UserController)->create();
	});
	
	$app->post("/admin/users/create", function () {
		(new UserController)->store();
	});
	
	$app->get("/admin/users/:id", function ($id){
 		(new UserController)->edit($id);
	});
	
	
	$app->post("/admin/users/:id", function ($id) {		
		(new UserController)->update($id);
	});
	
	$app->delete('/admin/users/:id', function ($id) {
		(new UserController)->delete($id);
	});
	$app->run();
	