<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools;

	class Router {
		protected array $routes = [];
		protected function __construct (protected Request $request, protected string $fallback404) {
		}

		public function addRoute (string $route) : bool {
			if (!($route::REQUEST_URI ?? false)) {
				return false;
			}

			$this->routes[$route::REQUEST_URI] = $route;

			return true;
		}

		public function response () : void {
			($this->routes[$this->request->getPath()] ?? $this->fallback404)::init()->response();
		}

		public static function init (?Request $request, string $fallback404) : Router {
			return new Router($request ?? Request::init(), $fallback404);
		}
	}
