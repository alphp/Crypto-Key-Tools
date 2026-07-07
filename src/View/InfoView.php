<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools\View;

	class InfoView extends View {
		public const REQUEST_URI = REQUEST_BASE . 'info';

		public function response () : void {
			phpinfo(INFO_VARIABLES);
		}
	}
