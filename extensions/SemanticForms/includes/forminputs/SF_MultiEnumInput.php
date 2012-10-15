<?php
/**
 * File holding the SFMultiEnumInput class
 *
 * @file
 * @ingroup SF
 */

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

