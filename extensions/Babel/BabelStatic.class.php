<?php

/**
 * Static functions for Babel extension.
 *
 * @addtogroup Extensions
 */

class BabelStatic {

	/**
	 * Registers the parser function hook.
	 * @return Boolean: True.
	 */
	public static function Setup() {
		global $wgParser;
		$wgParser->setFunctionHook( 'babel', array( 'BabelStatic', 'Render' ) );
		return true;
	}

	/**
	 * Registers the parser function magic word.
	 * @param $magicWords Array: Magic words on the wiki.
	 * @param $langCode String: Content language code of the wiki.
	 * @return Boolean: True.
	 */
	public static function Magic( array $magicWords, $langCode ) {
		$magicWords[ 'babel' ] = array( 0, 'babel' );
		return true;
	}

	/**
	 * Return Babel tower, initializing the Babel object if necessery,
	 * @param $parser Object: Parser.
	 * @return String: Babel tower.
	 */
	public static function Render( $parser ) {
		global $wgLanguageCodesFiles, $wgBabel;
		if( !is_object( $wgBabel ) ) $wgBabel = new Babel( $wgLanguageCodesFiles );
		$arguments = func_get_args();
		return call_user_func_array( array( $wgBabel, 'render' ), $arguments );
	}

}
