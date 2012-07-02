<?php
/**
 * Input definitions for the Semantic Forms Inputs extension.
 *
 * @author Stephan Gambke
 * @author Sanyam Goyal
 * @author Yaron Koren
 *
 */

if ( !defined( 'SFI_VERSION' ) ) {
	die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
}

class SFIUtils {

	/**
	 * Creates the html text for an input.
	 *
	 * Common attributes for input types are set according to the parameters.
	 * The parameters are the standard parameters set by Semantic Forms'
	 * InputTypeHook plus some optional.
	 *
	 * @param string $currentValue
	 * @param string $inputName
	 * @param boolean $isDisabled
	 * @param array $otherArgs
	 * @param string $inputId (optional)
	 * @param int $tabIndex (optional)
	 * @param string $class
	 * @return string the html text of an input element
	 */
	static function textHTML ( $currentValue, $inputName, $isDisabled, $otherArgs, $inputId = null, $tabIndex = null, $class = '' ) {

		global $sfgTabIndex;

		// array of attributes to pass to the input field
		$attribs = array(
				'name'  => $inputName,
				'class' => $class,
				'value' => $currentValue,
				'type'  => 'text'
		);

		// set size attrib
		if ( array_key_exists( 'size', $otherArgs ) ) {
			$attribs['size'] = $otherArgs['size'];
		}

		// set maxlength attrib
		if ( array_key_exists( 'maxlength', $otherArgs ) ) {
			$attribs['maxlength'] = $otherArgs['maxlength'];
		}

		// modify class attribute for mandatory form fields
		if ( array_key_exists( 'mandatory', $otherArgs ) ) {
			$attribs['class'] .= ' mandatoryField';
		}

		// add user class(es) to class attribute of input field
		if ( array_key_exists( 'class', $otherArgs ) ) {
			$attribs['class'] .= ' ' . $otherArgs['class'];
		}

		// set readonly attrib
		if ( $isDisabled ) {
			$attribs['readonly'] = '1';
		}

		// if no special input id is specified set the Semantic Forms standard
		if ( $inputId !== null ) {
			$attribs[ 'id' ] = $inputId;
		}


		if ( $tabIndex == null ) $attribs[ 'tabindex' ] = $sfgTabIndex;
		else $attribs[ 'tabindex' ] = $tabIndex;

		$html = Xml::element( 'input', $attribs );

		return $html;

	}
}
