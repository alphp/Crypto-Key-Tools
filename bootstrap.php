<?php
	declare(strict_types=1);

	require __DIR__ . '/vendor/autoload.php';

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', __DIR__);
	define('WWWROOT', __DIR__ . DS . 'wwwroot' . DS);
	define('REQUEST_BASE', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/');
	define('TEMPLATES', __DIR__ . DS . 'templates' . DS);

	$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';
	$request_file = str_starts_with($request_path, REQUEST_BASE) ? substr($request_path, strlen(REQUEST_BASE)) : $request_path;

	$request_file = ($request_file === 'index') ? '' : $request_file;
	$dotfile = ((pathinfo($request_file, PATHINFO_FILENAME) === '') and (pathinfo($request_file, PATHINFO_EXTENSION) !== ''));

	if ($request_file and !$dotfile and basename($request_file . '.php') !== '.php' and is_file(WWWROOT . $request_file . '.php')) {
		include WWWROOT . $request_file . '.php';
		exit;
	}

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

	($router[$request_path] ?? Error404View::class)::init()->response();

