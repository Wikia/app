<?php
/**
 * File holding the SFYearInput class
 *
 * @file
 * @ingroup SF
 */

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

	public static function getDefaultCargoTypes() {
		return array();
	}

	public static function getOtherCargoTypesHandled() {
		return array( 'Date' );
	}

	public static function getDefaultCargoTypeLists() {
		return array();
	}

	public static function getOtherCargoTypeListsHandled() {
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
			'description' => wfMessage( 'sf_forminputs_mandatory' )->text()
		);
		$params[] = array(
			'name' => 'restricted',
			'type' => 'boolean',
			'description' => wfMessage( 'sf_forminputs_restricted' )->text()
		);
		$params[] = array(
			'name' => 'class',
			'type' => 'string',
			'description' => wfMessage( 'sf_forminputs_class' )->text()
		);
		$params[] = array(
			'name' => 'default',
			'type' => 'string',
			'description' => wfMessage( 'sf_forminputs_default' )->text()
		);
		$params[] = array(
			'name' => 'size',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_size' )->text()
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
			$this->mOtherArgs
		);
	}
}
