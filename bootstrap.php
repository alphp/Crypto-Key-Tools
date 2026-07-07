<?php
	declare(strict_types=1);

	require __DIR__ . '/vendor/autoload.php';

	use Alphp\CryptoKeyTools\Request;
	use Alphp\CryptoKeyTools\Router;
	use Alphp\CryptoKeyTools\View\Error404View;
	use Alphp\CryptoKeyTools\View\KeyFactoryConvertView;
	use Alphp\CryptoKeyTools\View\KeyFactoryGenerateView;
	use Alphp\CryptoKeyTools\View\HomeView;
	use Alphp\CryptoKeyTools\View\InfoView;

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', __DIR__);
	define('WWWROOT', __DIR__ . DS . 'wwwroot' . DS);
	define('REQUEST_BASE', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/');
	define('TEMPLATES', __DIR__ . DS . 'templates' . DS);

	$request = Request::init();

	$request->runPHP();

	$router = Router::init($request, Error404View::class);

	$router->addRoute(HomeView::class);
	$router->addRoute(InfoView::class);
	$router->addRoute(KeyFactoryGenerateView::class);
	$router->addRoute(KeyFactoryConvertView::class);

	$router->response();
