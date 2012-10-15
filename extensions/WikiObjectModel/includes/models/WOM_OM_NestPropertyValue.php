<?php
/**
 * This model implements Parameter / Template_field value models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMNestPropertyValueModel extends WikiObjectModelCollection {

	public function __construct() {
		parent::__construct( WOM_TYPE_NESTPROPERTYVAL );
	}

	public function setXMLAttribute( $key, $value ) {
		throw new MWException( __METHOD__ . ": no key/value pair required" );
	}
}
