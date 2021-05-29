<?php
	
	if (!isset($_SESSION)) {
		session_start();
	}
	
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Psr\Log\LoggerInterface;
	use Slim\Factory\AppFactory;
	
	define('ROOT',dirname(__DIR__).DIRECTORY_SEPARATOR);

    define('VIEWS',ROOT.'views'.DIRECTORY_SEPARATOR);
    define('DEBUG', true);
	define('VIEWS_CACHE',ROOT.'tmp'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
	
	ini_set('display_errors', 2);
	
	require_once(ROOT .'vendor'.DIRECTORY_SEPARATOR.'autoload.php');
	
	
	/**
	 * Instantiate App
	 *
	 * In order for the factory to work you need to ensure you have installed
	 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
	 * ServerRequest creator (included with Slim PSR-7)
	 */
	$app = AppFactory::create();
	
	/**
	 * The routing middleware should be added earlier than the ErrorMiddleware
	 * Otherwise exceptions thrown from it will not be handled by the middleware
	 */
	$app->addRoutingMiddleware();
	
	/**
	 * Add Error Middleware
	 *
	 * @param bool $displayErrorDetails -> Should be set to false in production
	 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
	 * @param bool $logErrorDetails -> Display error details in error log
	 * @param LoggerInterface|null $logger -> Optional PSR-3 Logger
	 *
	 * Note: This middleware should be added last. It will not handle any exceptions/errors
	 * for middleware added after it.
	 */
	$errorMiddleware = $app->addErrorMiddleware(true, true, true);
	
	require_once(ROOT .'/routes/route.php');
	
	// Define app routes
//	$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
//		$name = $args['name'];
//		$response->getBody()->write("Hello, $name");
//		return $response;
//	});
	
	// Run app
	$app->run();
	
	//	if (!isset($_SESSION)) {
	//		session_start();
	//	}
	//	
	//	ini_set('display_errors', 2);
	//	
	//	define('ROOT',__DIR__.DIRECTORY_SEPARATOR);
	// 	define('VIEWS',ROOT.'views'.DIRECTORY_SEPARATOR);
	// 	define('DEBUG', true);
	//	define('VIEWS_CACHE',ROOT.'tmp'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
	//	
	//	require_once("vendor/autoload.php");
	//	
	//	require_once("routes/route.php");
	//	
	//
	//	
