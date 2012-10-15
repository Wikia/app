<?php

/**
 * File holding the SFI_DateTimePicker class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticFormsInputs
 */
if ( !defined( 'SFI_VERSION' ) ) {
	die( 'This file is part of the SemanticFormsInputs extension, it is not a valid entry point.' );
}

/**
 * The SFIDateTimePicker class.
 *
 * @ingroup SemanticFormsInputs
 */
class SFIDateTimePicker extends SFFormInput {

	protected $mDatePicker;
	protected $mTimePicker;

		/**
	 * Constructor.
	 *
	 * @param String $input_number
	 *		The number of the input in the form.
	 * @param String $cur_value
	 *		The current value of the input field.
	 * @param String $input_name
	 *		The name of the input.
	 * @param String $disabled
	 *		Is this input disabled?
	 * @param Array $other_args
	 *		An associative array of other parameters that were present in the
	 *		input definition.
	 */
	public function __construct( $input_number, $cur_value, $input_name, $disabled, $other_args ) {
		
		parent::__construct( $input_number, $cur_value, $input_name, $disabled, $other_args );
		
		self::setup();

		// prepare sub-inputs
		
		$this->mOtherArgs["part of dtp"] = true;

		// find allowed values and keep only the date portion
		if ( array_key_exists( 'possible_values', $this->mOtherArgs ) &&
				count( $this->mOtherArgs[ 'possible_values' ] ) ) {

			$this->mOtherArgs[ 'possible_values' ] = preg_replace(
							'/^\s*(\d{4}\/\d{2}\/\d{2}).*/',
							'$1',
							$this->mOtherArgs[ 'possible_values' ]
			);
		}

		$dateTimeString = trim( $this->mCurrentValue );
		$dateString = '';
		$timeString = '';

		$separatorPos = strpos($dateTimeString, " ");

		// does it have a separating whitespace? assume it's a date & time
		if ( $separatorPos ) {
			$dateString = substr( $dateTimeString, 0, $separatorPos );
			$timeString = substr( $dateTimeString, $separatorPos + 1 );

		// does it start with a time of some kind?
		} elseif ( preg_match( '/^\d?\d:\d\d/', $dateTimeString ) ) {
			$timeString = $dateTimeString;

		// if all else fails assume it's a date
		} else {
			$dateString = $dateTimeString;
		}

		$this->mDatePicker = new SFIDatePicker( $this->mInputNumber . '_dp', $dateString, $this->mInputName, $this->mIsDisabled, $this->mOtherArgs );
		$this->mTimePicker = new SFITimePicker( $this->mInputNumber . '_tp', $timeString, $this->mInputName, $this->mIsDisabled, $this->mOtherArgs );
		
		// add JS data
		$this->addJsInitFunctionData( 'SFI_DTP_init', $this->setupJsInitAttribs() );
		
	}

	/**
	 * Returns the name of the input type this class handles: menuselect.
	 *
	 * This is the name to be used in the field definition for the "input type"
	 * parameter.
	 *
	 * @return String The name of the input type this class handles.
	 */
	public static function getName() {
		return 'datetimepicker';
	}

	/**
	 * Static setup method for input type "menuselect".
	 * Adds the Javascript code and css used by all menuselects.
	*/
	static private function setup() {

		global $wgOut;
		global $sfigSettings;

		static $hasRun = false;

		if ( !$hasRun ) {
			$hasRun = true;

			$wgOut->addScript( '<script type="text/javascript" src="' . $sfigSettings->scriptPath . '/libs/datetimepicker.js"></script> ' );

		}

	}
	
	protected function setupJsInitAttribs() {
		
		global $sfigSettings;

		$jsattribs = array();

		// if we have to show a reset button
		if ( array_key_exists( 'show reset button', $this->mOtherArgs ) ||
			( !array_key_exists( 'hide reset button', $this->mOtherArgs ) && $sfigSettings->datetimePickerShowResetButton ) ) {

			// is the button disabled?
			$jsattribs['disabled'] = $this->mIsDisabled;

			// set the button image
			if ( $this->mIsDisabled ) {
				$jsattribs['resetButtonImage'] = $sfigSettings->scriptPath . '/images/DateTimePickerResetButtonDisabled.gif';
			} else {
				$jsattribs['resetButtonImage'] = $sfigSettings->scriptPath . '/images/DateTimePickerResetButton.gif';
			}

			// set user classes
			if ( array_key_exists( 'class', $this->mOtherArgs ) ) {
				$jsattribs['userClasses'] = $this->mOtherArgs['class'];
			} else {
				$jsattribs['userClasses'] = '';
			}
		}
		
		$jsattribs['subinputs'] = 
				$this->mDatePicker->getHtmlText() . " " .
				$this->mTimePicker->getHtmlText();
		
		$jsattribs['subinputsInitData'] = array(
			'input_' . $this->mInputNumber . '_dp' => $this->mDatePicker->getJsInitFunctionData(),
			'input_' . $this->mInputNumber . '_tp' => $this->mTimePicker->getJsInitFunctionData()
		);

		// build JS code from attributes array
		return Xml::encodeJsVar( $jsattribs );
	}
	
	/**
	 * Returns the HTML code to be included in the output page for this input.
	 *
	 * Ideally this HTML code should provide a basic functionality even if the
	 * browser is not Javascript capable. I.e. even without Javascript the user
	 * should be able to input values.
	 *
	 */
	public function getHtmlText(){

		global $sfigSettings;

		// should the input field be disabled?
		$inputFieldDisabled =
			array_key_exists( 'disable input field', $this->mOtherArgs )
			|| ( !array_key_exists( 'enable input field', $this->mOtherArgs ) && $sfigSettings->datePickerDisableInputField )
			|| $this->mIsDisabled	;

		$html = '<span class="inputSpan' . ( array_key_exists( 'mandatory', $this->mOtherArgs) ? ' mandatoryFieldSpan' : '') . '">' .
				SFIUtils::textHTML( $this->mCurrentValue, $this->mInputName, $inputFieldDisabled, $this->mOtherArgs, 'input_' . $this->mInputNumber ) .
				'</span>';

		return $html;

	}

	/**
	 * Returns the set of SMW property types which this input can
	 * handle, but for which it isn't the default input.
	 */
	public static function getOtherPropTypesHandled() {
		return array( '_str', '_dat' );
	}

	/**
	 * Returns the set of parameters for this form input.
	 * 
	 * TODO: Specify parameters specific for menuselect.
	 */
	public static function getParameters() {
		$params = parent::getParameters();
		
		$params[] = array(
			'name' => 'structure',
			'type' => 'text',
			'description' => wfMsg( 'semanticformsinputs-menuselect-structure' ),
			'default' => "* item 1\n** item 11\n** item 12\n* item 2\n** item 21\n** item 22"
		);
		$params[] = array(
			'name' => $sfigSettings->menuSelectDisableInputField?'enable input field':'disable input field',
			'type' => 'boolean',
			'description' => wfMsg( 'semanticformsinputs-menuselect-enableinputfield' ),
		);
		return $params;
	}

	/**
	 * Returns the name and parameters for the validation JavaScript
	 * functions for this input type, if any.
	 */
	public function getJsValidationFunctionData() {
		return array_merge(
			$this->mJsValidationFunctionData,
			$this->mDatePicker->getJsValidationFunctionData(),
			$this->mTimePicker->getJsValidationFunctionData()
			);

	}

}
