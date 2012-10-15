<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMParserFunctionParser extends WOMTemplateParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_PARSERFUNCTION;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );
		$r = preg_match( '/^\{\{\s*#([^\{\|\}:]+):/', $text, $m );

		if ( $r ) {
			$len = strlen( $m[0] );
			$func_key = trim( $m[1] );

			return array( 'len' => $len, 'obj' => new WOMParserFunctionModel( $func_key ) );
		}
		return null;
	}

	public function getSubParserID( $obj ) {
//		if ( ( $obj instanceof WOMParserFunctionModel )
//			&& ( strtolower( $obj->getFunctionKey() ) == 'ask' )
//			&& ( count ( $obj->getObjects() ) == 0 ) ) {
//
//			return WOM_PARSER_ID_QUERYSTRING;
//		}
		return WOM_PARSER_ID_PARAMETER;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !$obj instanceof WOMParserFunctionModel ) return false;

		if ( ( strlen( $text ) >= $offset + 2 )
			&& $text { $offset } == '}'
			&& $text { $offset + 1 } == '}' ) {
				return 2;
		}

		return false;
	}
}
