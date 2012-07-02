<?php

/**
 * Static functions for Babel extension.
 *
 * @ingroup Extensions
 */
class BabelStatic {
	/**
	 * Registers the parser function hook.
	 *
	 * @param $parser Parser
	 *
	 * @return Boolean: True.
	 */
	public static function Setup( $parser ) {
		$parser->setFunctionHook( 'babel', array( 'Babel', 'Render' ) );
		return true;
	}
}
