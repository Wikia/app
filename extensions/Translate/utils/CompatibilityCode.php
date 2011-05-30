<?php
/**
 * Code for facilitiating backwards compatibility for older %MediaWikis.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * General BC code.
 */
class TranslateBC {

	/**
	 * Create a call to a JavaScript function. The supplied arguments will be
	 * encoded using Xml::encodeJsVar().
	 *
	 * @param $name The name of the function to call, or a JavaScript expression
	 *    which evaluates to a function object which is called.
	 * @param $args Array of arguments to pass to the function.
	 * @since 1.17
	 */
	public static function encodeJsCall( $name, $args ) {
		$realFunction = array( 'Xml', 'encodeJsCall' );
		if ( is_callable( $realFunction ) ) {
			return Xml::encodeJsCall( $name, $args );
		}

		$s = "$name(";
		$first = true;
		foreach ( $args as $arg ) {
			if ( $first ) {
				$first = false;
			} else {
				$s .= ', ';
			}
			$s .= Xml::encodeJsVar( $arg );
		}
		$s .= ");\n";
		return $s;
	}

}
