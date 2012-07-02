<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMTemplateFieldHolderParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_TEMPLATE_FIELD_HOLDER;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		$text = substr( $text, $offset );
		$r = preg_match( '/^(\{\{\{([^{|}]+))([|}])/', $text, $m );

		if ( $r ) {
			if ( !preg_match( '/[^' . Title::legalChars() . ']/', trim( $m[2] ) ) )
//			if(!preg_match(Title::getTitleInvalidRegex(), trim($m[2])))
				return array( 'len' => ( $m[3] == '|' ) ? strlen( $m[0] ) : strlen( $m[1] ), 'obj' => new WOMTemplateFieldHolderModel( trim( $m[2] ) ) );
		}
		return null;
	}

	public function getSubParserID( $obj ) {
		return WOM_PARSER_ID_PARAM_VALUE;
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !$obj instanceof WOMTemplateFieldHolderModel ) return false;

		if ( ( strlen( $text ) >= $offset + 3 )
			&& $text { $offset } == '}'
			&& $text { $offset + 1 } == '}'
			&& $text { $offset + 2 } == '}' ) {
				return 3;
		}

		return false;
	}
}
