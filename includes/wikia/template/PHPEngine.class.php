<?php
namespace Wikia\Template;

/**
 * PHP FileSystem-based engine for Wikia Templating System.
 *
 * Replaces the EasyTemplate implementation now deprecated.
 *
 * @package Wikia\Template
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * @see Engine for documentation and usage
 */

class PHPEngine extends Engine {
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

		extract( $this->values );
		ob_start();

		wfProfileIn( __METHOD__ . " - template: {$path}" );
		( include $path ) or call_user_func( function () use( $template ) {
			//avoid failing miserably, match Mustache PHP exception message
			//doing this avoids having to do an FS lookup every time to check
			//if the template is missing before invoking include
			throw new \Exception( "Template \"{$template}\" was not found" );
		} );
		wfProfileOut( __METHOD__ . " - template: {$path}" );

		$contents = ob_get_clean();

		wfProfileOut( __METHOD__ );
		return $contents;
	}

	/**
	 * Simple wrapper for wfMsg
	 *
	 * @param String $message The message key
	 * @deprecated
	 */
	public function msg( $message ) {
		wfDeprecated( __METHOD__ );
		echo wfMessage( $message )->text();
	}
};
