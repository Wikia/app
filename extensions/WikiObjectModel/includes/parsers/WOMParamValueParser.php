<?php
/**
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WOMParamValueParser extends WikiObjectModelParser {

	public function __construct() {
		parent::__construct();
		$this->m_parserId = WOM_PARSER_ID_PARAM_VALUE;
	}

	public function parseNext( $text, WikiObjectModelCollection $parentObj, $offset = 0 ) {
		if ( !( ( $parentObj instanceof WOMParameterModel )
			|| ( $parentObj instanceof WOMTemplateFieldHolderModel ) ) )
			return null;

		return array( 'len' => 0, 'obj' => new WOMParamValueModel() );
	}

	public function isObjectClosed( $obj, $text, $offset ) {
		if ( !( $obj instanceof WOMParamValueModel ) )
			return false;

		$parentClose = WOMProcessor::getObjectParser( $obj->getParent() )
			->isObjectClosed( $obj->getParent(), $text, $offset );
		if ( $parentClose !== false ) return 0;

		return false;
	}
}
