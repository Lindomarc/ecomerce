<?php
	
	use Lin\AdminPage;
	use Lin\Model\User;
	use Lin\Page;
	use Lin\UsersPage;
	use Slim\Slim;
	
	ini_set('display_errors', 2);
	
	define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
	
	const VENDOR = ROOT . 'vendor' . DIRECTORY_SEPARATOR;
	const VIEW = ROOT . 'views' . DIRECTORY_SEPARATOR;
	const TMP = ROOT . 'tmp' . DIRECTORY_SEPARATOR;
	const CACHE = TMP . 'cache' . DIRECTORY_SEPARATOR;
	const VIEW_CACHE = CACHE . 'views' . DIRECTORY_SEPARATOR;
	
	require_once VENDOR . 'autoload.php';
	
	$app = new Slim();
	$app->log->setEnabled(true);
	$app->log->setLevel(\Slim\Log::DEBUG);
	
	$app->get('/', function () {
		$page = new Page();
		$page->setTpl('index');
	});
	
	$user = new User();
	
	$app->group('/admin', function () use ($app) {

		if (User::verifyLogin()) {
			header('Location: /admin/login');
			exit;
		}
		/* DASHBOARD */
		$app->get('/', function () {			
			$page = new AdminPage();
			$page->setTpl('index');
		});
		
		
		/* USERS */
		$app->group('/users', function () use ($app) {
			
			
			$app->get('/', function () {
				(new UsersPage)->index();
			});
			
			$app->get('/create', function () {
				(new UsersPage)->create();
			});		
			
			$app->post('/create', function () {
				(new UsersPage)->create();
			});
			
			$app->get('/:iduser/delete', function ($iduser) {
				(new UsersPage)->delete($iduser);
			});
			
			$app->get('/:iduser', function ($iduser) {
				(new UsersPage)->edit($iduser);
			});	
			
			$app->post('/:iduser', function ($iduser) {
				(new UsersPage)->edit($iduser);
			});
			
		});
		
		
	});
	
	
	$app->get('/admin/login', function () {
		$page = new AdminPage([
			"header" => false,
			"footer" => false
		]);
		$page->setTpl("login");
	});
	
	$app->post('/admin/login', function () {
		User::login($_POST['deslogin'], $_POST['despassword']);
		header('Location: /admin');
		exit;
	});
	
	$app->get('/admin/logout', function () {
		User::logout();
		header('Location: /admin/login');
		exit;
	});
	
	$app->run();