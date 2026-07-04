<?php
	declare(strict_types=1);

	require __DIR__ . '/vendor/autoload.php';

	use phpseclib3\Crypt\RSA;

	$input = filter_input_array(INPUT_POST, [
		'bits' => [
			'filter' => FILTER_VALIDATE_INT,
			'options' => [
				'default' => 2,
				'min_range' => 2,
				'max_range' => 4,
			],
		],
		'comment' => [
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => [
				'default' => 'id_rsa',
				'regexp' => '~^[a-z@\-\.]+$~i',
			],
		],
		'password' => [
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => [
				'default' => false,
				'regexp' => '~^[^\r\n]{1,80}$~',
			],
		],
	]);

	$input['bits'] *= 1024;
	$private = RSA::createKey($input['bits'])->withPassword($input['password']);
	$public = $private->getPublicKey();

	$rsa = [
		'comment' => $input['comment'],
		'key' => $private->toString('PKCS8', ['comment' => $input['comment']]),
		'pub' => $public->toString('PKCS8', ['comment' => $input['comment']]),
		'ssh' => $public->toString('OpenSSH', ['comment' => $input['comment']]),
		'ppk' => $private->toString('PuTTY', ['comment' => $input['comment']]),
	];

	if (false === $json = json_encode($rsa)) {
    http_response_code(500);
    $json = json_encode(['error' => 'Serialization failed']);
	}

	header('Content-Type: application/json');
	header('Cache-Control: no-store');
	echo $json;
