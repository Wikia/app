<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMTableCellParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_TABLECELL;
	}

	private function getFirstLineChar( $text, $offset ) {
		for ( $i = $offset; $i >= 0; --$i ) {
			if ( $text { $i } == "\n" ) {
				$s = substr( $text, $i );
				if ( preg_match( '/^\s*([!|])/', $s, $m ) ) {
					return $m[1];
				}
				break;
			}
		}

		return '';
	}
	// FIXME: what if table cell style uses parser function which contains 'return' or '|'
	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		if ( !( $parentObj instanceof WOMTableModel ) ) return null;

		$lastLF = ( $text { $offset } == "\n" || ( $offset == 0 || $text { $offset - 1 } == "\n" ) );
		// get the first char of current line
		$fch = $this->getFirstLineChar( $text, $offset );
		if ( $fch == '' ) return null;

		$text = substr( $text, $offset );

		$r = preg_match( '/^(' . ( ( $fch == '!' ) ? '!!|' : '' ) . '\|\||(\s*(\|\+|\|-|[!|])))/', $text, $m );
		if ( !$r ) return null;

		if ( isset( $m[2] ) && !$lastLF ) return null;

		$len = strlen( $m[0] );
		$text = substr( $text, $len );
		$r = preg_match( '/^([^\n|]*\|)[^|]/', $text, $m1 );
		if ( !$r || preg_match( '/\{\{/', $m1[1] ) ) {
			// FIXME: what if matched style contains '{{', just think it is table body
			return array( 'len' => $len, 'obj' => new WOMTableCellModel( $m[0] ) );
		}

		if ( $fch == '!' ) {
			$pos = strpos( $text, '!!', $len );
			if ( $pos !== false && $pos < strlen( $m1[1] ) ) {
				return array( 'len' => $len, 'obj' => new WOMTableCellModel( $m[0] ) );
			}
		}

		return array( 'len' => $len + strlen( $m1[1] ), 'obj' => new WOMTableCellModel( $m[0] . $m1[1] ) );
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !( $obj instanceof WOMTableCellModel ) ) return false;

		$fch = $this->getFirstLineChar( $text, $offset );

		$lastLF = ( $text { $offset } == "\n" || ( $offset == 0 || $text { $offset - 1 } == "\n" ) );

		$text = substr( $text, $offset );
		if ( strlen( $text ) == 0 ) return 0;
		if ( $lastLF && preg_match( '/^(\s*[!|])/', $text ) ) return 0;
		if ( $fch == '' ) return false;
		if ( preg_match( '/^(' . ( ( $fch == '!' ) ? '!!|':'' ) . '\|\|)/', $text ) ) return 0;

		return false;
	}
}
