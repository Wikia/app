<?php
/**
 * File holding the SFMultiEnumInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFMultiEnumInput class.
 * The base class for every form input that holds a list of elements, each
 * one from a pre-set enumeration of values.
 *
 * @ingroup SFFormInput
 */
abstract class SFMultiEnumInput extends SFEnumInput {

	public static function getOtherPropTypesHandled() {
		return array();
	}

	public static function getOtherPropTypeListsHandled() {
		return array( 'enumeration' );
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'delimiter',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_delimiter' )
		);
		return $params;
	}
}

