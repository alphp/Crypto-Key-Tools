<?php
	declare(strict_types=1);

	require __DIR__ . '/vendor/autoload.php';

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', __DIR__);
	define('BASE', $_SERVER['BASE'] ?? '/');
	define('TEMPLATES', __DIR__ . DS . 'templates' . DS);

	use Alphp\CryptoKeyTools\KeyFactoryConvert;
	use Alphp\CryptoKeyTools\KeyFactoryGenerate;
	use Alphp\CryptoKeyTools\View\Error404View;
	use Alphp\CryptoKeyTools\View\Error405View;
	use Alphp\CryptoKeyTools\View\HomeView;

	$disallow = [
		BASE . 'generate',
		BASE . 'convert',
	];

	if ('GET' === $_SERVER['REQUEST_METHOD'] and in_array($_SERVER['REQUEST_URI'], $disallow)) {
		(new Error405View())->response();
		exit;
	}

	$controller = match($_SERVER['REQUEST_URI']) {
		BASE              => new HomeView(),
		BASE . 'generate' => KeyFactoryGenerate::init(),
		BASE . 'convert'  => KeyFactoryConvert::init(),
		default           => new Error404View(),
	};

	$controller->response();
