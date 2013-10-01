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
	 * returns true if DOMNode is DOMElement with $tagName
	 * if $tagName is null (default) we don't check tagName.
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
			return false;
		}
		return in_array( $className, preg_split( '/[\s]+/', $classString) );
	}

	public static function hasChildTag( DOMElement $domElement, $tagName ) {
		foreach ( $domElement->childNodes as $node ) {
			if ( $node instanceof DOMElement ) {
				if ( $node->tagName == $tagName ) {
					return true;
				}
			}
		}
		return false;
	}

	public static function hasAncestorTag( DomElement $domElement, $tagNames ) {
		$set = array_flip( $tagNames );
		return self::hasAncestorTagInternal( $domElement, $set );
	}

	private static function hasAncestorTagInternal( DOMElement $domElement, &$tagNameSet ) {
		foreach ( $domElement->childNodes as $node ) {
			if ( $node instanceof DOMElement ) {
				if ( isset($tagNameSet[ $node->tagName ]) ) {
					return true;
				}
				if( self::hasAncestorTagInternal( $domElement, $tagNameSet ) ) {
					return true;
				}
			}
		}
		return false;
	}
}
