<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools\View;

	class Error405View extends View {
		public function response () : void {
			include TEMPLATES . '405.php';
		}
	}
