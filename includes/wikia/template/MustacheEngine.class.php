<?php
namespace Wikia\Template;

/**
 * Mustache FileSystem-based engine for Wikia Templating System.
 *
 * @package Wikia\Template
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * @see Engine for documentation and usage
 */

class MustacheEngine extends Engine {
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

		$path = $this->prefix == '' ? $template : $this->prefix . DIRECTORY_SEPARATOR . $template;

		wfProfileIn( __METHOD__ . " - template: {$path}" );
		$contents = \MustacheService::getInstance()->render( $path, $this->values );
		wfProfileOut( __METHOD__ . " - template: {$path}" );

		wfProfileOut( __METHOD__ );
		return $contents;
	}
};
