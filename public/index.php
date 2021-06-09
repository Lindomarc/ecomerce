<?php
	session_start();
	
	use Lin\AdminPage;
	use Lin\Model\User;
	use Lin\Page;
	use Lin\UsersPage;
	use Lin\AuthPage;
	use Slim\Slim;
	
	ini_set('display_errors', 2);
	
	define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
	
	const VENDOR = ROOT . 'vendor' . DIRECTORY_SEPARATOR;
	const VIEW = ROOT . 'views' . DIRECTORY_SEPARATOR;
	const TMP = ROOT . 'tmp' . DIRECTORY_SEPARATOR;
	const CACHE = TMP . 'cache' . DIRECTORY_SEPARATOR;
	const VIEW_CACHE = CACHE . 'views' . DIRECTORY_SEPARATOR;
	
	const REPLAY_EMAIL = 'no-replay@exemple.com';
	const REPLAY_NAME = 'no-replay';
	const FROM_EMAIL = 'exemple2@exemple.com';
	const FROM_NAME = 'exemple2';
	
	define('HTTP_HOST', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
	
	require_once VENDOR . 'autoload.php';
	
	$app = new Slim();
	$app->config(array(
		'log.enable' => true,
		'debug' => true
	));
	
	$app->get('/', function () {
		$page = new Page();
		$page->setTpl('index');
	});
	
	
	/* DASHBOARD */
	$app->get('/admin', function () {
		$page = new AdminPage();
		$page->setTpl('index');
	});
	
	/* USERS */
	$app->get('/admin/users', function () {
		(new UsersPage)->index();
	});
	
	$app->get('/admin/users/create', function () {
		(new UsersPage)->create();
	});
	
	$app->post('/admin/users/create', function () {
		(new UsersPage)->create();
	});
	
	$app->get('/admin/users/:iduser/delete', function ($iduser) {
		(new UsersPage)->delete($iduser);
	});
	
	$app->get('/admin/users/:iduser', function ($iduser) {
		(new UsersPage)->edit($iduser);
	});
	
	$app->post('/admin/users/:iduser', function ($iduser) {
		(new UsersPage)->edit($iduser);
	});
	
	
	$app->get('/auth/login', function () {
		
		$page = new AuthPage([
			"header" => false,
			"footer" => false
		]);
		$page->setTpl("login");
	});
	
	$app->post('/auth/login', function () {
		User::login($_POST['deslogin'], $_POST['despassword']);
		header('Location: /admin');
		exit;
	});
	
	
	$app->get('/auth/logout', function () {
		User::logout();
		header('Location: /auth/login');
		exit;
	});
	
	$app->get('/auth/forgot', function () {
		$page = new AuthPage([
			"header" => false,
			"footer" => false
		]);
		$page->setTpl("forgot");
	});
	
	$app->post('/auth/forgot', function () use ($app) {
		if (User::getForgot()) {
			header("Location: /auth/forgot/send");
		} else {
			$app->flash('error', 'Unable to retrieve password.');
			header("Location: /auth/forgot");
		}
		exit();		
	});
	
	$app->get('/auth/forgot/send', function () {		
		$page = new AuthPage([
			"header" => false,
			"footer" => false
		]);
		$page->setTpl("forgot-send");
		exit();
	});
	
	$app->get('/forgot/reset', function () use ($app) {
		$user = User::validForgotDecrypt($_GET['code']);
		if (!$user) {
			$app->flash('error', 'Not Unable to retrieve password');
		}
		
		$page = new AuthPage([
			"header" => false,
			"footer" => false
		]);
		
		$page->setTpl("forgot-reset", [
			'name' => $user['desperson'],
			'code' => $_GET['code']
		]);
	});
	
	$app->post('/auth/forgot/reset', function () use ($app) {
		$forgot = User::validForgotDecrypt($_POST['code']);
		if (!$forgot) {
			$app->flash('error', 'Not Unable to retrieve password');
		}
		
		User::setForgotUsed($forgot['idrecovery']);
		
		$user = new User();
		
		$user->get((int)($forgot['iduser']));
		
		$user->setPassword($_POST['password']);
		
		$page = new AuthPage([
			"header" => false,
			"footer" => false
		]);
		
		$page->setTpl("forgot-reset-success");
		
	});
	
	$app->get('/admin/categories',function () {
		(new \Lin\CategoryPage())->index();	
	});
	
	$app->get('/admin/categories/create',function () {
		(new \Lin\CategoryPage())->create();	
	});
	$app->post('/admin/categories/create',function () {
		(new \Lin\CategoryPage())->create();	
	});
	
	$app->get('/admin/categories/:id/delete',function ($id) {
		(new \Lin\CategoryPage())->delete($id);	
	});
	
	$app->get('/admin/categories/:id',function ($id) {
		(new \Lin\CategoryPage())->edit($id);	
	});
	$app->post('/admin/categories/:id',function ($id) {
		(new \Lin\CategoryPage())->edit($id);	
	});
	
	$app->get('/category/:id',function ($id) {
		
		(new Page())->category($id);
		
	});
	
	$app->get('/admin/products',function () {
		(new \Lin\ProductsPage())->index();
	});
	$app->get('/admin/products/create',function () {
		(new \Lin\ProductsPage())->create();
	});
	$app->post('/admin/products/create',function () {
		(new \Lin\ProductsPage())->create();
	});
	
	$app->get('/admin/products/:id',function ($id) {
		(new \Lin\ProductsPage())->edit($id);
	});	
	$app->post('/admin/products/:id',function ($id) {
		(new \Lin\ProductsPage())->edit($id);
	});
	
	$app->get('/admin/products/:id/delete',function ($id) {
		(new \Lin\ProductsPage())->delete($id);
	});
	
	$app->run();