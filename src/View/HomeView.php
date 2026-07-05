<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools\View;

	class HomeView extends View {
		public function response () : void {
			$generate = BASE . 'generate';
			$convert = BASE . 'convert';

			include TEMPLATES . 'home.php';
		}
	}
