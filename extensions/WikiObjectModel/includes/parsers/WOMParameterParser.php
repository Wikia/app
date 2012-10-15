<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMParameterParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_PARAMETER;
	}

	private function parseAsk ( $text, WikiObjectModelCollection $parentObj ) {
		if ( !defined( 'SMW_VERSION' ) ) return null;

		if ( trim( strtolower( $parentObj->getFunctionKey() ) ) != 'ask' ) return null;

		if ( count ( $parentObj->getObjects() ) == 0 ) {
			return array( 'len' => 0, 'obj' => new WOMQuerystringModel() );
		}

		if ( defined( 'SMW_AGGREGATION_VERSION' ) ) {
			$r = preg_match( '/^(\s*\?([^>=|}]+)(?:\>([^=|}]*))?(?:=([^|}]*))?)(\||\}|$)/', $text, $m );
			if ( !$r ) return null;
			return array(
				'len' => strlen( $m[5] == '|' ? $m[0] : $m[1] ),
				'obj' => new WOMQueryPrintoutModel( trim( $m[2] ), trim( $m[4] ), trim( $m[3] ) ) );
		} else {
			$r = preg_match( '/^(\s*\?([^=|}]+)(?:=([^|}]*))?)(\||\}|$)/', $text, $m );
			if ( !$r ) return null;
			return array(
				'len' => strlen( $m[4] == '|' ? $m[0] : $m[1] ),
				'obj' => new WOMQueryPrintoutModel( trim( $m[2] ), trim( $m[3] ) ) );
		}
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		if ( !( ( $parentObj instanceof WOMTemplateModel )
			|| ( $parentObj instanceof WOMParserFunctionModel ) ) )
				return null;

		$text = substr( $text, $offset );

		$ret = $this->parseAsk ( $text, $parentObj );
		if ( $ret != null ) return $ret;

		$r = preg_match( '/^([^=|}]*)(\||=|\}|$)/', $text, $m );
		if ( !$r ) return null;

		if ( $m[2] == '=' ) {
			$len = strlen( $m[0] );
			$key = trim( $m[1] );
		} else {
			$len = 0;
			$key = '';
		}
		if ( $parentObj instanceof WOMTemplateModel ) {
			// templates
			return array( 'len' => $len, 'obj' => new WOMTemplateFieldModel( $key ) );
		} else {
			// parser function, unknown parameter containers, etc
			return array( 'len' => $len, 'obj' => new WOMParameterModel( $key ) );
		}
	}

	public function getSubParserID( $obj ) {
		if ( ( $obj instanceof WOMQuerystringModel )
			|| ( $obj instanceof WOMQueryPrintoutModel ) )
				return '';

		return WOM_PARSER_ID_PARAM_VALUE;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !( ( $obj instanceof WOMTemplateFieldModel )
			|| ( $obj instanceof WOMParameterModel )
			|| ( $obj instanceof WOMQuerystringModel )
			|| ( $obj instanceof WOMQueryPrintoutModel ) ) )
				return false;

		if ( ( strlen( $text ) >= $offset + 1 ) && $text { $offset } == '|' ) {
			return 1;
		}
		$parentClose = WOMProcessor::getObjectParser( $obj->getParent() )
			->isObjectClosed( $obj->getParent(), $text, $offset );
		if ( $parentClose !== false ) return 0;

		return false;
	}
}
