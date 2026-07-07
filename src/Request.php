<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools;

	class Request {
		protected string $request_path;
		protected string $request_file;
		protected bool $dotfile;
		protected bool $folder;

		protected function __construct () {
			$this->request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';

			$request_file = str_starts_with($this->request_path, REQUEST_BASE)
				? substr($this->request_path, strlen(REQUEST_BASE))
				: $this->request_path;

			$this->request_file = ($request_file === 'index') ? '' : $request_file;

			$request_filename = pathinfo($this->request_file, PATHINFO_FILENAME);
			$request_ext = pathinfo($this->request_file, PATHINFO_EXTENSION);

			$this->dotfile = ((($request_filename[0] ?? '') === '.' or ($request_filename === '') and ($request_ext !== '')));
			$this->folder = (substr($this->request_path, -1) === '/');
		}

		public function isPHP () : bool {
			return ($this->request_file and !$this->dotfile and !$this->folder and is_file(WWWROOT . $this->request_file . '.php'));
		}

		public function runPHP () : void {
			if ($this->isPHP()) {
				include WWWROOT . $this->request_file . '.php';
				exit;
			}
		}

		public function getPath () : string {
			return $this->request_path;
		}

		public static function init (?string $request_uri = null) : Request {
			$_SERVER['REQUEST_URI'] = $request_uri ?? $_SERVER['REQUEST_URI'];

			return new Request();
		}
	}
