<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools\View;

	class HomeView extends View {
		public function response () : void {
			$generate = REQUEST_BASE . 'generate';
			$convert = REQUEST_BASE . 'convert';

			include TEMPLATES . 'home.php';
		}
	}
