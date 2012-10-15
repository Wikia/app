<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMSectionParser extends WikiObjectModelParser {

	static $heading = '======';

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_SECTION;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$lastLF = ( $offset == 0 || $text { $offset - 1 } == "\n" );
		$text = substr( $text, $offset );
		if ( !$lastLF ) return null;

		$r = preg_match( '/^(={1,6})/', $text, $m );
		if ( $r ) {
			$text1 = substr( $text, strlen( $m[0] ) );
			$s = explode( "\n", $text1, 2 );
			$r = preg_match( '/(={1,})\s*$/', $s[0], $m1, PREG_OFFSET_CAPTURE );

			if ( $r ) {
				$len = strlen( $m[0] ) + strlen( $s[0] ) + 1/* \n */;
				$level = strlen( $m[1] ) < strlen( $m1[1][0] ) ? strlen( $m[1] ) : strlen( $m1[1][0] );

				$obj = new WOMSectionModel( trim(
					substr( WOMSectionParser::$heading, 0, strlen( $m[1] ) - $level ) .
						substr( $s[0], 0, $m1[1][1] + strlen( $m1[1][0] ) - $level ) ),
					$level );

				while ( $parentObj != null &&
					( $parentObj->getTypeID() == WOM_TYPE_SECTION ) &&
					( $parentObj->getLevel() >= $obj->getLevel() ) ) {
						$parentObj = $parentObj->getParent();
				}
				$obj->setParent( $parentObj );

				return array( 'len' => $len, 'obj' => $obj );
			}
		}

		return null;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( strlen( $text ) == $offset ) return 0;

		$parentClose = WOMProcessor::getObjectParser( $obj->getParent() )
			->isObjectClosed( $obj->getParent(), $text, $offset );
		if ( $parentClose !== false ) return 0;

		return false;
	}
}
