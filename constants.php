<?php
	declare(strict_types=1);

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', __DIR__);
	define('WWWROOT', __DIR__ . DS . 'wwwroot' . DS);
	define('REQUEST_BASE', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/');
	define('TEMPLATES', __DIR__ . DS . 'templates' . DS);
