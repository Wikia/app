<?php
namespace Wikia\Template;

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
		$path = $dir . $template;

		wfProfileIn( __METHOD__ . " - template: {$path}" );

		$contents = \HandlebarsService::getInstance()->render($path, $this->values);

		wfProfileOut( __METHOD__ . " - template: {$path}" );

		wfProfileOut( __METHOD__ );
		return $contents;
	}

};
