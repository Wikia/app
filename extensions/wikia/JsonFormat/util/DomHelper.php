<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 12:40
 */

class DomHelper {

	/**
	 * @param DOMNode $node
	 * @return bool
	 */
	public static function isTextNode( DOMNode $node ) {
		return $node instanceof DOMText;
	}

	/**
	 * @param DOMElement|null $domNode
	 * @param string|null $tagName
	 * @return bool
	 */
	public static function isElement( $domNode, $tagName = null ) {
		if( $domNode instanceof DOMElement ) {
			if ( $tagName != null ) {
				return $domNode->tagName == $tagName;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

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
