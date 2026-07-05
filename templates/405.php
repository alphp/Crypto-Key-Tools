<?php
	declare(strict_types=1);

	http_response_code(405);
	header('Allow: POST');
	header('Content-Type: application/json; charset=utf-8');

	echo json_encode([
		'status'  => 405,
		'error'   => 'Method Not Allowed',
		'message' => 'El método ' . $_SERVER['REQUEST_METHOD'] . ' no está permitido para esta ruta.'
	], JSON_UNESCAPED_UNICODE);
