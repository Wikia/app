<?php
/**
 * File holding the SFYearInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFYearInput class.
 *
 * @ingroup SFFormInput
 */
class SFYearInput extends SFTextInput {
	public static function getName() {
		return 'year';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getOtherPropTypesHandled() {
		return array( '_dat' );
	}

	public static function getDefaultPropTypeLists() {
		return array();
	}

	public static function getOtherPropTypeListsHandled() {
		return array();
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		$other_args['size'] = 4;
		return parent::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
	}

	public static function getParameters() {
		$params = array();
		$params[] = array(
			'name' => 'mandatory',
			'type' => 'boolean',
			'description' => wfMsg( 'sf_forminputs_mandatory' )
		);
		$params[] = array(
			'name' => 'restricted',
			'type' => 'boolean',
			'description' => wfMsg( 'sf_forminputs_restricted' )
		);
		$params[] = array(
			'name' => 'class',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_class' )
		);
		$params[] = array(
			'name' => 'default',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_default' )
		);
		$params[] = array(
			'name' => 'size',
			'type' => 'int',
			'description' => wfMsg( 'sf_forminputs_size' )
		);
		return $params;
	}

	/**
	 * Returns the HTML code to be included in the output page for this input.
	 */
	public function getHtmlText() {
		return self::getHTML(
			$this->mCurrentValue,
			$this->mInputName,
			$this->mIsMandatory,
			$this->mIsDisabled,
			$mOtherArgs
		);
	}
}
