<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools\View;

	class HomeView extends View {
		public const REQUEST_URI = REQUEST_BASE;

		public function response () : void {
			$generate = KeyFactoryGenerateView::REQUEST_URI;
			$convert = KeyFactoryConvertView::REQUEST_URI;

			include TEMPLATES . 'home.php';
		}
	}
