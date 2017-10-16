<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 12:40
 */

class DomHelper {
	private static $hasDescendantHeaderInternalCache = [];

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
	 * @param DOMElement|DOMNode|null $domNode
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
	 * @param $domElement
	 * @param string $variableName
	 * @throws InvalidArgumentException
	 */
	public static function verifyDomElementArgument( $domElement, $variableName = "domElement" ) {
		if ( $domElement === null ) {
			throw new InvalidArgumentException( "Argument $variableName is null." );
		}
		if ( !($domElement instanceof DOMElement) ) {
			throw new InvalidArgumentException( "Argument $variableName is not DOMElement as expected." );
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

	public static function hasDescendantHeader( DomElement $domElement ) {
		return self::hasDescendantHeaderInternalCached( $domElement );
	}

	private static function hasDescendantHeaderInternalCached( DOMElement $domElement ) {
		$cacheId = spl_object_hash( $domElement );
		if ( isset( self::$hasDescendantHeaderInternalCache[ $cacheId ] ) ) {
			return self::$hasDescendantHeaderInternalCache[ $cacheId ];
		}
		$result = self::hasDescendantHeaderInternal( $domElement );
		self::$hasDescendantHeaderInternalCache[ $cacheId ] = $result;
		return $result;
	}

	private static function hasDescendantHeaderInternal( DOMElement $domElement ) {
		foreach ( $domElement->childNodes as $node ) {
			if ( $node instanceof DOMElement ) {
				if ( $node->tagName[0] === 'h' &&
					is_numeric($node->tagName[1]) &&
					strlen( $node->tagName ) === 2 ) {
					return true;
				}
				if( self::hasDescendantHeaderInternalCached( $node ) ) {
					return true;
				}
			}
		}
		return false;
	}


	public static function getTextValue( DomNode $node, $allow = ['#text','a','b','i','u','h1','h2','h3','h4','p'], $ignoredClasses = [ ] ) {
		$text = '';
		foreach( $node->childNodes as $child ) {
			if( in_array( $child->nodeName,$allow ) ) {
				if( $child->nodeName==='#text' ) {
					$text .= $child->nodeValue;
				}
				else {

					if( !empty( $child->attributes ) ) {
						$class = trim( $child->getAttribute( 'class' ) );
						if( $class && in_array( $class, $ignoredClasses ) ) {
							continue;
						}
					}

					$text .= self::getTextValue( $child,$allow );
				}
			}
		}

		return trim( $text );
	}

	public static function cleanDescendantHeaderInternalCache() {
		self::$hasDescendantHeaderInternalCache = [];
	}

}
