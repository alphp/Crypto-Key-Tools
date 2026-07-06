<?php
	declare(strict_types=1);

	require __DIR__ . '/vendor/autoload.php';

	/**
	 * Emulate $_SERVER['REQUEST_BASE'] for IIS
	 */
	$request_base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
	$_SERVER['REQUEST_BASE'] ??= $request_base;

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', __DIR__);
	define('REQUEST_BASE', $_SERVER['REQUEST_BASE'] ?? '/');
	define('TEMPLATES', __DIR__ . DS . 'templates' . DS);

	use Alphp\CryptoKeyTools\KeyFactoryConvert;
	use Alphp\CryptoKeyTools\KeyFactoryGenerate;
	use Alphp\CryptoKeyTools\View\Error404View;
	use Alphp\CryptoKeyTools\View\Error405View;
	use Alphp\CryptoKeyTools\View\HomeView;

	$disallow = [
		REQUEST_BASE . 'generate',
		REQUEST_BASE . 'convert',
	];

	if ('GET' === $_SERVER['REQUEST_METHOD'] and in_array($_SERVER['REQUEST_URI'], $disallow)) {
		(new Error405View())->response();
		exit;
	}

	$controller = match($_SERVER['REQUEST_URI']) {
		REQUEST_BASE              => new HomeView(),
		REQUEST_BASE . 'generate' => KeyFactoryGenerate::init(),
		REQUEST_BASE . 'convert'  => KeyFactoryConvert::init(),
		default           => new Error404View(),
	};

	$controller->response();
