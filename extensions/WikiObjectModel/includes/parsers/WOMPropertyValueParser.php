<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMPropertyValueParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_PROPERTY_VALUE;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		if ( !( $parentObj instanceof WOMNestPropertyModel ) )
			return null;

		return array( 'len' => 0, 'obj' => new WOMNestPropertyValueModel() );
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !( $obj instanceof WOMNestPropertyValueModel ) )
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
