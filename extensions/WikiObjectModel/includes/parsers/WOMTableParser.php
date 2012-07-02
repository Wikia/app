<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMTableParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_TABLE;
	}

	// FIXME: what if table style uses parser function which contains 'return'
	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );

//		$r = preg_match('/^([ \t]*\{\|)/', $text, $m);
//		if(!$r) return null;
//		return array( 'len' => strlen($m[1]), 'obj' => new WOMTableModel('') );

		$r = preg_match( '/^([ \t]*\{\|([^\n]*))\n/', $text, $m );
		if ( !$r ) return null;
		return array( 'len' => strlen( $m[1] ), 'obj' => new WOMTableModel( trim( $m[2] ) ) );
	}

	public function getSubParserID( $obj ) {
		return WOM_PARSER_ID_TABLECELL;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !$obj instanceof WOMTableModel ) return false;

		$text = substr( $text, $offset );
		if ( strlen( $text ) == 0 ) return 0;

		if ( preg_match( '/^\n\s*\|\}/', $text, $m ) ) {
				return strlen( $m[0] );
		}

		return false;
	}
}
