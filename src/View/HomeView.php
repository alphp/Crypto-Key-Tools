<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools\View;

	class HomeView extends View {
		public const REQUEST_URI = REQUEST_BASE;

		public function response () : void {
			header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; font-src 'self' https://cdnjs.cloudflare.com; img-src 'self' data:; connect-src 'self' https://cdnjs.cloudflare.com;");

			$generate = KeyFactoryGenerateView::REQUEST_URI;
			$convert = KeyFactoryConvertView::REQUEST_URI;

			include TEMPLATES . 'home.php';
		}
	}
