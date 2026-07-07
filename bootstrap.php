<?php
	declare(strict_types=1);

	require __DIR__ . '/vendor/autoload.php';
	require __DIR__ . '/constants.php';

	use Alphp\CryptoKeyTools\Request;
	use Alphp\CryptoKeyTools\Router;
	use Alphp\CryptoKeyTools\View\Error404View;
	use Alphp\CryptoKeyTools\View\KeyFactoryConvertView;
	use Alphp\CryptoKeyTools\View\KeyFactoryGenerateView;
	use Alphp\CryptoKeyTools\View\HomeView;
	use Alphp\CryptoKeyTools\View\InfoView;

	$request = Request::init();

	$request->runPHP();

	$router = Router::init($request, Error404View::class);

	$router->addRoute(HomeView::class);
	$router->addRoute(InfoView::class);
	$router->addRoute(KeyFactoryGenerateView::class);
	$router->addRoute(KeyFactoryConvertView::class);

	$router->response();
