<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMHTMLTagParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_HTMLTAG;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );
		// this is not a proper html tag regex, for strings include char '>'
		// anyway, MW sanitizer just parse like this
		$r = preg_match( '/^<([\w]+)((\s+[^>]*)*|\/)>/', $text, $m );
		if ( $r ) {
			$name = $m[1];
			$attrs = array();
			$closed = false;
			if ( isset( $m[2] ) ) {
				$attr = $m[2];
				$closed = ( $attr != '' && $attr { strlen( $attr ) - 1 } == '/' );
				if ( $closed ) $attr = substr( $attr, 0, strlen( $attr ) - 1 );
				while ( preg_match( '/^\s*([\w]+)\s*=\s*/', $attr, $m1 ) ) {
					$attr = substr( $attr, strlen( $m1[0] ) );
					if ( $attr { 0 } == '\'' || $attr { 0 } == '"' ) {
						$idx = 1;
						while ( ( $idx = strpos( $attr, $attr { 0 } , $idx ) ) !== false ) {
							if ( $attr { $idx -1 } != '\\' ) break;
							++ $idx;
						}
						$attrs[$m1[1]] = ( substr( $attr, 0, $idx + 1 ) );
						$attr = substr( $attr, $idx + 1 );
					} else {
						if ( preg_match( '/\s|$/', $attr, $m2, PREG_OFFSET_CAPTURE ) ) {
							$attrs[$m1[1]] = ( substr( $attr, 0, $m2[0][1] ) );
							$attr = substr( $attr, $m2[0][1] );
						}
					}
				}
			}
			return array( 'len' => strlen( $m[0] ), 'obj' => new WOMHTMLTagModel( $name, $attrs ), 'closed' => $closed );
		}
		return null;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !$obj instanceof WOMHTMLTagModel ) return false;

		if ( preg_match( '/^<\/' . $obj->getName() . '\s*>/i', substr( $text, $offset ), $m ) ) {
			return strlen( $m[0] );
		}

		return false;
	}
}
