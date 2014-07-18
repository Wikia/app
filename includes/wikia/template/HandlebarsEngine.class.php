<?php
namespace Wikia\Template;
use Handlebars\Handlebars;

require("lib/vendor/Handlebars/Autoloader.php");

/**
 * Handlebars FileSystem-based engine for Wikia Templating System.
 *
 * @package Wikia\Template
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 *
 * @see Engine for documentation and usage
 */

class HandlebarsEngine extends Engine {

	protected $partialDir;
	protected $partialPrefix = '';

	public function __construct() {
		\Handlebars\Autoloader::register();
	}
	/**
	 * @see Engine::exists() for documentation and usage
	 */
	public function exists( $template ) {
		wfProfileIn( __METHOD__ );

		$found = file_exists( $this->prefix == '' ? $template : $this->prefix . DIRECTORY_SEPARATOR . $template );

		wfProfileOut( __METHOD__ );
		return $found;
	}

	/**
	 * @see Engine::render() for documentation and usage
	 */
	public function render( $template ) {
		wfProfileIn( __METHOD__ );

		$dir = $this->prefix == '' ? '' : $this->prefix . DIRECTORY_SEPARATOR;
		$partialDir = $this->partialDir ? $this->partialDir : $dir;
		$partialPrefix = $this->partialPrefix;

		$path = $dir . $template;

		wfProfileIn( __METHOD__ . " - template: {$path}" );
		$handlebarsEngine = new Handlebars([
			'loader' => new \Handlebars\Loader\FilesystemLoader($dir),
			'partials_loader' => new \Handlebars\Loader\FilesystemLoader(
					$partialDir,
					[
						'prefix' => $partialPrefix
					]
				)
		]);

		$contents = $handlebarsEngine->render( $template, $this->values );
		wfProfileOut( __METHOD__ . " - template: {$path}" );

		wfProfileOut( __METHOD__ );
		return $contents;
	}

	/**
	 * Sets the base path for Handlebars partials.
	 *
	 * @param string $partialDir base path to Handlebars partials
	 *
	 * @return Engine The current instance
	 */
	public function setPartialDir ( $dir ) {
		$this->partialDir = (string) $dir;
		return $this;
	}

	/**
	 * Returns the base path set for Handlebars partials.
	 *
	 * @return string|null
	 */
	public function getPartialDir() {
		return $this->partialDir;
	}

	/**
	 * Sets the prefix for Handlebars partials files.
	 *
	 * @param string $partialPrefix Handlebars partials file prefix
	 *
	 * @return Engine The current instance
	 */
	public function setPartialPrefix ( $prefix ) {
		$this->partialPrefix = (string) $prefix;
		return $this;
	}

	/**
	 * Returns the prefix for Handlebars partials files.
	 *
	 * @return string|null
	 */
	public function getPartialPrefix() {
		return $this->partialPrefix;
	}
};
