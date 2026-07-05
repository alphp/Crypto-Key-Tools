<?php
	declare(strict_types=1);

	require dirname(__DIR__) . '/vendor/autoload.php';

	use phpseclib3\Crypt\Common\PrivateKey;
	use phpseclib3\Crypt\EC;
	use phpseclib3\Crypt\EC\Curves\Ed25519;
	use phpseclib3\Crypt\PublicKeyLoader;
	use phpseclib3\Crypt\RSA;

	class KeyFactory {
		protected string $algo;
		protected PrivateKey $private;

		protected function __construct (protected int $bits, protected string $comment, protected string|false $password) {
			$this->algo = ($bits > 1024) ? 'RSA' : 'Ed25519';
			$this->private = $this->generate();
		}
		public static function init () : KeyFactory {
			/** @var array{'bits': int, 'comment': string, 'password': string|false} */
			$input = filter_input_array(INPUT_POST, [
				'bits' => [
					'filter' => FILTER_VALIDATE_INT,
					'options' => [
						'default' => 2,
						'min_range' => 1,
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

			$input['comment'] = ($input['comment'] === 'id_rsa' and $input['bits'] === 1) ? 'id_ed225519' : $input['comment'];
			$input['bits'] *= 1024;

			return new static($input['bits'], $input['comment'], $input['password']);
		}

		protected function generate () : PrivateKey {
			return match ($this->algo) {
				'Ed25519' => EC::createKey('Ed25519')->withPassword($this->password),
				default => RSA::createKey($this->bits)->withPassword($this->password),
			};
		}

		public function __toString() : string {
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
