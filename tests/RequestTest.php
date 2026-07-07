<?php
	declare(strict_types=1);

	namespace Alphp\CryptoKeyTools\Tests;

	use Alphp\CryptoKeyTools\Request;

	class RequestTest extends TestCase {
		protected function setUp() : void {
			// Definimos las constantes necesarias si no están definidas
			if (!defined('DS')) {
				define('DS', DIRECTORY_SEPARATOR);
			}

			if (!defined('WWWROOT')) {
				define('WWWROOT', __DIR__ . DS . 'mock_wwwroot' . DS);
			}

			if (!defined('REQUEST_BASE')) {
				define('REQUEST_BASE', '/subdir/');
			}
		}

		/**
		 * Prueba la normalización básica de una ruta eliminando la base
		 */
		public function testPathNormalization () : void {
			$request = Request::init('/subdir/generate');

			$this->assertEquals('/subdir/generate', $request->getPath());
			// Internamente request_file debería ser 'generate'
		}

		/**
		 * Prueba que el recurso 'index' se convierta en una cadena vacía
		 * para coincidir con la HomeView::REQUEST_URI
		 */
		public function testIndexNormalization () : void {
			$request = Request::init('/subdir/index');

			// El path sigue siendo el original, pero la lógica de resolución
			// de archivos lo tratará como raíz para evitar recursividad.
			$this->assertEquals('/subdir/index', $request->getPath());
		}

		/**
		 * Prueba la detección de archivos de sistema (dotfiles) por seguridad
		 */
		public function testDotfileSecurityDetection () : void {
			// Caso: .env
			$request = Request::init('/subdir/.env');

			// Accedemos mediante reflexión o verificamos el comportamiento indirecto
			// isPHP() debería ser falso incluso si el archivo existiera
			$this->assertFalse($request->isPHP());
		}

		/**
		 * Prueba la discriminación de carpetas (trailing slashes)
		 */
		public function testFolderDetection () : void {
			$request = Request::init('/subdir/path/');

			// No debe tratarse como un archivo .php ejecutable
			$this->assertFalse($request->isPHP());
		}

		/**
		 * Prueba la resolución de archivos PHP físicos en WWWROOT
		 */
		public function testIsPHPResolution () : void {
			// Simulamos un archivo existente (esto requiere que WWWROOT/test.php exista)

			$request = Request::init('/subdir/test');
			$this->assertIsBool($request->isPHP());
			$this->assertTrue($request->isPHP());
		}

		/**
		 * Prueba la resolución de archivos PHP físicos en WWWROOT
		 */
		public function testIsPHPResolutionNoExists () : void {
			// Simulamos un archivo existente (esto requiere que WWWROOT/noexists.php NO exista)

			$request = Request::init('/subdir/noexists');
			$this->assertIsBool($request->isPHP());
			$this->assertFalse($request->isPHP());
		}
	}
