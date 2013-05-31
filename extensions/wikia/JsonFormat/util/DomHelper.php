<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 12:40
 */

class DomHelper {
	/**
	 * @param DomElement $domElement
	 */
	public static function hasClass( DomElement $domElement, $className ) {
		$classString = $domElement->getAttribute( 'class' );
		if ( empty( $classString ) ) {
			return NULL;
		}
		return in_array( $className, explode( '/\s/', $classString) );
	}
}
