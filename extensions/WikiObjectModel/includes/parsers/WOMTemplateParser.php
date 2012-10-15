<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMTemplateParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_TEMPLATE;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );
		$r = preg_match( '/^(\{\{([^{|}]+))([|}])/', $text, $m );

		if ( $r ) {
			if ( !preg_match( '/[^' . Title::legalChars() . ']/', trim( $m[2] ) ) )
//			if(!preg_match(Title::getTitleInvalidRegex(), trim($m[2])))
				return array( 'len' => ( $m[3] == '|' ) ? strlen( $m[0] ) : strlen( $m[1] ), 'obj' => new WOMTemplateModel( trim( $m[2] ) ) );
		}
		return null;
	}

	public function getSubParserID( $obj ) {
		return WOM_PARSER_ID_PARAMETER;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !$obj instanceof WOMTemplateModel ) return false;

		if ( ( strlen( $text ) >= $offset + 2 )
			&& $text { $offset } == '}'
			&& $text { $offset + 1 } == '}' ) {
				return 2;
		}

		return false;
	}
}
