<?php
	declare(strict_types=1);

	require __DIR__ . '/vendor/autoload.php';

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', __DIR__);
	define('REQUEST_BASE', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/');
	define('TEMPLATES', __DIR__ . DS . 'templates' . DS);

	use Alphp\CryptoKeyTools\View\KeyFactoryConvertView;
	use Alphp\CryptoKeyTools\View\KeyFactoryGenerateView;
	use Alphp\CryptoKeyTools\View\Error404View;
	use Alphp\CryptoKeyTools\View\HomeView;
	use Alphp\CryptoKeyTools\View\InfoView;

	$router = [
		HomeView::REQUEST_URI               => HomeView::class,
		//InfoView::REQUEST_URI               => InfoView::class,
		KeyFactoryGenerateView::REQUEST_URI => KeyFactoryGenerateView::class,
		KeyFactoryConvertView::REQUEST_URI  => KeyFactoryConvertView::class,
	];

	$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';
	($router[$request_path] ?? Error404View::class)::init()->response();

