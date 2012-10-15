<?php
/**
 * This model implements key value models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMQuerystringModel extends WikiObjectModelCollection {

	public function __construct() {
		parent::__construct( WOM_TYPE_QUERYSTRING );
	}

	public function setXMLAttribute( $key, $value ) {
		throw new MWException( __METHOD__ . ": no key/value pair required" );
	}

	public function getWikiText() {
		return $this->getValueText() .
			'|';
	}

	public function getValueText() {
		return parent::getWikiText();
	}
}
