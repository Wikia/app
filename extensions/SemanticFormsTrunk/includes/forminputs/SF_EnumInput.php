<?php
/**
 * File holding the SFEnumInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFEnumInput class.
 * The base class for every form input that holds a pre-set enumeration
 * of values.
 *
 * @ingroup SFFormInput
 */
abstract class SFEnumInput extends SFFormInput {

	public static function getOtherPropTypesHandled() {
		return array( 'enumeration', '_boo' );
	}

	public static function getValuesParameters() {
		$params = array();
		$params[] = array(
			'name' => 'values',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_values' )
		);
		$params[] = array(
			'name' => 'values from property',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_valuesfromproperty' )
		);
		$params[] = array(
			'name' => 'values from category',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_valuesfromcategory' )
		);
		$params[] = array(
			'name' => 'values from namespace',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_valuesfromnamespace' )
		);
		$params[] = array(
			'name' => 'values from concept',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_valuesfromconcept' )
		);
		return $params;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params = array_merge( $params, self::getValuesParameters() );
		$params[] = array(
			'name' => 'show on select',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_showonselect' )
		);
		return $params;
	}
}
