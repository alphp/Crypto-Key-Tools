<?php
	declare(strict_types=1);

	require dirname(__DIR__) . '/vendor/autoload.php';

	use phpseclib3\Crypt\Common\PrivateKey;
	use phpseclib3\Crypt\EC\PrivateKey as ECPrivateKey;
	use phpseclib3\Crypt\PublicKeyLoader;
	use phpseclib3\Crypt\RSA\PrivateKey as RSAPrivateKey;

	class KeyFactory {
		protected string $comment;
		protected PrivateKey|false $private;

		protected function __construct (protected ?string $key, protected string|false $password, ?string $comment) {
			$this->private = $this->generate();
			$this->comment = $comment ?? match ($this->private::class) {
				RSAPrivateKey::class => 'id_rsa',
				ECPrivateKey::class => 'id_ec',
				default => 'id_' . basename(dirname($this->private::class)),
			};
		}
		public static function init () : KeyFactory {
			/** @var array{'comment': string, 'password': string|false, 'key': string|false} */
			$input = filter_input_array(INPUT_POST, [
				'comment' => [
					'filter' => FILTER_VALIDATE_REGEXP,
					'options' => [
						'default' => null,
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
				'key' => [
					'filter' => FILTER_VALIDATE_REGEXP,
					'options' => [
						'default' => null,
						'regexp' => '~^-----BEGIN ([\S ]*)PRIVATE KEY-----.*-----END ([\S ]*)PRIVATE KEY-----\s*$~ms',
					],
				],
			]);

			if ($_FILES['keyfile']['tmp_name'] ?? false) {
				if (is_file($_FILES['keyfile']['tmp_name'])) {
					$input['key'] = file_get_contents($_FILES['keyfile']['tmp_name']);
				}
			}

			if (empty($input['key'])) {
				$json = json_encode(['error' => 'Error: key missing']);
				http_response_code(400);
				header('Content-Type: application/json');
				header('Cache-Control: no-store');
				echo $json;
				die();
			}

			return new static($input['key'], $input['password'], $input['comment']);
		}

		protected function generate () : PrivateKey|false {
			try {
				$private = PublicKeyLoader::load($this->key, $this->password);

				if ($private instanceof PrivateKey) {
					return $private;
				}
			} catch (Throwable|Exception $error) {
			}

			return false;
		}

		public function __toString() : string {
			if (false === $this->private) {
				http_response_code(500);
				$json = json_encode(['error' => 'Loading failed']);
			}

			$public = $this->private->getPublicKey();

			$rsa = [
				'comment' => $this->comment,
				'key' => $this->private->toString('PKCS8', ['comment' => $this->comment]),
				'key_ssh' => $this->private->toString('OpenSSH', ['comment' => $this->comment]),
				'pub' => $public->toString('PKCS8', ['comment' => $this->comment]),
				'ssh' => $public->toString('OpenSSH', ['comment' => $this->comment]),
				'ppk' => $this->private->toString('PuTTY', ['comment' => $this->comment]),
			];

			if (false === $json = json_encode($rsa)) {
				http_response_code(500);
				$json = json_encode(['error' => 'Serialization failed']);
			}

			return $json;
		}
	}

	$key = KeyFactory::init();

	$json = $key->__toString();

	header('Content-Type: application/json');
	header('Cache-Control: no-store');
	echo $json;
