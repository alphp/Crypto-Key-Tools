<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools\View;

	class Error404View extends View {
		public function response () : void {
			include TEMPLATES . '404.php';
		}
	}
