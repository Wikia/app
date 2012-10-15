<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMListItemParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_LISTITEM;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$lastLF = ( $offset == 0 || $text { $offset - 1 } == "\n" );
		$text = substr( $text, $offset );
		if ( !$lastLF ) return null;

		$r = preg_match( '/^([\*#]+)/', $text, $m );
		if ( $r ) {
			$len = strlen( $m[0] );
			$obj = new WOMListItemModel( $m[1] );

			return array( 'len' => $len, 'obj' => $obj );
		}

		return null;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !$obj instanceof WOMListItemModel )
			return false;

		$len = strlen( $text );
		if ( ( $offset >= $len ) || ( ( $len >= $offset + 1 ) && $text { $offset } == "\n" ) ) {
			return 0;
		}

		return false;
	}
}
