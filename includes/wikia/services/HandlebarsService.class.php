<?php

class HandlebarsService {

	protected function __construct() {
		\Handlebars\Autoloader::register();
	}

	/**
	 * Extract and return template name from provided path.
	 *
	 * @param $path string File path (absolute)
	 * @throws Exception Thrown if *.handlebars file not found in provided path
	 * @return string template name
	 */
	private function extractTemplateNameFromPath($path) {
		$matches = [];
		if (preg_match('/\\w+.handlebars/', $path, $matches) != 1) {
			throw new Exception('Handlebar template not found in following path: ' . $path);
		}
		return $matches[0];
	}

	/**
	 * Extract and return path to templates directory from provided path
	 *
	 * @param $path string File path (absolute)
	 * @throws Exception Thrown if /templates directory not found in provided path
	 * @return string Path to templates directory (absolute)
	 */
	private function extractTemplateDirFromPath($path) {
		$matches = [];
		if (preg_match('/\/(.+)templates\//', $path, $matches) != 1) {
			throw new Exception('Templates directory not found in following path: ' . $path);
		}
		return $matches[0];
	}

	/**
	 * Render given template using supplied data
	 *
	 * @param $path string Path to template file (absolute)
	 * @param $data array Data to be rendered
	 * @return string Template output
	 */
	public function render($path, $data) {
		wfProfileIn( __METHOD__ );

		$templateName = $this->extractTemplateNameFromPath($path);
		$templateDir = $this->extractTemplateDirFromPath($path);
		$partials = $templateDir . DIRECTORY_SEPARATOR . 'partials';
		$partialsPrefix = '_';

		wfProfileIn( __METHOD__ . " - template: {$path}" );

		$handlebars = new \Handlebars\Handlebars();

		$handlebars->setLoader(new \Handlebars\Loader\FilesystemLoader($templateDir));
		$handlebars->setPartialsLoader(new \Handlebars\Loader\FilesystemLoader(
			$partials,
			[
				'prefix' => $partialsPrefix
			]));

		$contents = $handlebars->render( $templateName, $data);

		wfProfileOut( __METHOD__ . " - template: {$path}" );

		wfProfileOut( __METHOD__ );
		return $contents;
	}

	/**
	 * Get a singleton instance of HandlebarsService
	 *
	 * @return HandlebarsService Singleton
	 */
	public static function getInstance() {
		static $instance;
		if ( empty( $instance ) ) {
			$instance = new self;
		}
		return $instance;
	}
}
