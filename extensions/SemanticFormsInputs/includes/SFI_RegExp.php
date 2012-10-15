<?php

/**
 * File holding the SFIRegExp class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticFormsInputs
 */
if ( !defined( 'SFI_VERSION' ) ) {
	die( 'This file is part of the SemanticFormsInputs extension, it is not a valid entry point.' );
}

/**
 * This class represents the RegExp input.
 *
 * @ingroup SFI
 */
class SFIRegExp extends SFFormInput {

	/** @var SFFormInput */
	protected $mBaseInput;

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

		global $sfgFormPrinter;

		parent::__construct( $input_number, $cur_value, $input_name, $disabled, $other_args );

		// call static setup
		self::setup();

		// set OR character
		if ( array_key_exists( 'or char', $this->mOtherArgs ) ) {
			$orChar = trim( $this->mOtherArgs['or char'] );
			unset( $this->mOtherArgs['or char'] );
		} else {
			$orChar = '!';
		}


		// set regexp string
		if ( array_key_exists( 'regexp', $this->mOtherArgs ) ) {

			$this->mRegExp = str_replace( $orChar, '|', trim( $this->mOtherArgs['regexp'] ) );
			unset( $this->mOtherArgs['regexp'] );

			// check for leading/trailing delimiter and remove it (else reset regexp)
			if ( preg_match( "/^\/.*\/\$/", $this->mRegExp ) ) {

				$this->mRegExp = substr( $this->mRegExp, 1, strlen( $this->mRegExp ) - 2 );
			} else {
				$this->mRegExp = '.*';
			}
		} else {
			$this->mRegExp = '.*';
		}

		// set inverse string
		if ( array_key_exists( 'inverse', $this->mOtherArgs ) ) {
			$invertRegexp = 'true';
			unset( $this->mOtherArgs['inverse'] );
		} else {
			$invertRegexp = 'false';
		}

		// set failure message string
		if ( array_key_exists( 'message', $this->mOtherArgs ) ) {
			$this->mErrorMessage = trim( $this->mOtherArgs['message'] );
			unset( $this->mOtherArgs['message'] );
		} else {
			$this->mErrorMessage = wfMsg( 'semanticformsinputs-wrongformat' );
		}

		// sanitize error message and regexp for JS
		$message = Xml::encodeJsVar( $this->mErrorMessage );
		$regexp = Xml::encodeJsVar( $this->mRegExp );

		// Finally set name and parameters for the validation function
		$this->addJsValidationFunctionData( 'SFI_RE_validate', "{retext: {$regexp}, inverse: {$invertRegexp}, message: {$message} }" );

		
		// set base input type name
		if ( array_key_exists( 'base type', $this->mOtherArgs ) ) {

			$baseType = trim( $this->mOtherArgs['base type'] );
			unset( $this->mOtherArgs['base type'] );

			// if unknown set default base input type
			if ( !array_key_exists( $baseType, $sfgFormPrinter->mInputTypeClasses ) ) {
				$baseType = 'text';
			}
		} else {
			$baseType = 'text';
		}

		// create other_args array for base input type if base prefix was set
		if ( array_key_exists( 'base prefix', $this->mOtherArgs ) ) {

			// set base prefix
			$basePrefix = trim( $this->mOtherArgs['base prefix'] ) . ".";
			unset( $this->mOtherArgs['base prefix'] );

			// create new other_args param
			$newOtherArgs = array();
			
			foreach ( $this->mOtherArgs as $key => $value ) {
				if ( strpos( $key, $basePrefix ) === 0 ) {
					$newOtherArgs[substr( $key, strlen( $basePrefix ) )] = $value;
				} else {
					$newOtherArgs[$key] = $value;
				}
			}
			
		} else {
			$newOtherArgs = $this->mOtherArgs;
		}

		// create base input
		$this->mBaseInput = new $sfgFormPrinter->mInputTypeClasses[ $baseType ] (
				$this->mInputNumber, $this->mCurrentValue, $this->mInputName, $this->mIsDisabled, $newOtherArgs
		);

	}

	/**
	 * Returns the name of the input type this class handles.
	 *
	 * This is the name to be used in the field definition for the "input type"
	 * parameter.
	 *
	 * @return String The name of the input type this class handles.
	 */
	public static function getName() {
		return 'regexp';
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
			$wgOut->addScript( '<script type="text/javascript" src="' . $sfigSettings->scriptPath . '/libs/regexp.js"></script> ' );
		}
	}

	/**
	 * Returns the set of parameters for this form input.
	 */
	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'regexp',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-regexp-regexp' )
		);
		$params[] = array(
			'name' => 'base type',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-regexp-basetype' )
		);
		$params[] = array(
			'name' => 'base prefix',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-regexp-baseprefix' )
		);
		$params[] = array(
			'name' => 'or char',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-regexp-orchar' )
		);
		$params[] = array(
			'name' => 'inverse',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-regexp-inverse' )
		);
		$params[] = array(
			'name' => 'message',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-regexp-message' )
		);


		return $params;
	}

	/**
	 * Returns the HTML code to be included in the output page for this input.
	 *
	 * Ideally this HTML code should provide a basic functionality even if the
	 * browser is not JavaScript capable. I.e. even without JavaScript the user
	 * should be able to input values.
	 *
	 */
	public function getHtmlText() {

		return $this->mBaseInput->getHtmlText();
	}

	/**
	 * Returns the set of SMW property types which this input can
	 * handle, but for which it isn't the default input.
	 *
	 * @deprecated
	 * @return Array of strings
	 */
	public static function getOtherPropTypesHandled() {
		return array('_str', '_num', '_dat', '_geo', '_ema', '_tel', '_wpg', '_tem', '_qty');
	}

	/**
	 * Returns the name and parameters for the initialization JavaScript
	 * function for this input type, if any.
	 */
	public function getJsInitFunctionData() {
		return array_merge( $this->mJsInitFunctionData, $this->mBaseInput->getJsInitFunctionData() );
	}

	/**
	 * Returns the name and parameters for the validation JavaScript
	 * functions for this input type, if any.
	 */
	public function getJsValidationFunctionData() {
		return array_merge( $this->mJsValidationFunctionData, $this->mBaseInput->getJsValidationFunctionData() );
	}
}
