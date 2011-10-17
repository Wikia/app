<?php
/**
 * File holding the SFComboBoxInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFComboBoxInput class.
 *
 * @ingroup SFFormInput
 */
class SFComboBoxInput extends SFFormInput {
	public static function getName() {
		return 'combobox';
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// For backward compatibility with pre-SF-2.1 forms
		if ( array_key_exists( 'no autocomplete', $other_args ) &&
				$other_args['no autocomplete'] == true ) {
			unset( $other_args['autocompletion source'] );
			return SFTextInput::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
		}

		global $sfgTabIndex, $sfgFieldNum;

		$className = 'sfComboBox';
		if ( $is_mandatory ) {
			$className .= ' mandatoryField';
		}
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		$disabled_text = ( $is_disabled ) ? 'disabled' : '';

		if ( array_key_exists( 'size', $other_args ) ) {
			$size = $other_args['size'];
		} else {
			$size = '35';
		}
		// There's no direct correspondence between the 'size='
		// attribute for text inputs and the number of pixels, but
		// multiplying by 6 seems to be about right for the major
		// browsers.
		$pixel_width = $size * 6 . 'px';

		list( $autocompleteFieldType, $autocompletionSource ) =
			SFTextWithAutocompleteInput::getAutocompletionTypeAndSource( $other_args );

		// @TODO - that count() check shouldn't be necessary
		if ( array_key_exists( 'possible_values', $other_args ) &&
		count( $other_args['possible_values'] ) > 0 ) {
			$values = $other_args['possible_values'];
		} elseif ( $autocompleteFieldType == 'values' ) {
			$autocompleteValues = explode( ',', $other_args['values'] );
		} else {
			$values = SFUtils::getAutocompleteValues( $autocompletionSource, $autocompleteFieldType );
			$autocompleteValues = SFUtils::getAutocompleteValues( $autocompletionSource, $autocompleteFieldType );
		}
		$autocompletionSource = str_replace( "'", "\'", $autocompletionSource );

		$optionsText = Xml::element( 'option', array( 'value' => $cur_value ), null, false ) . "\n";
		foreach ( $values as $value ) {
			$optionsText .= Xml::element( 'option', array( 'value' => $value ), $value ) . "\n";
		}

		$selectAttrs = array(
			'id' => "input_$sfgFieldNum",
			'name' => $input_name,
			'class' => $className,
			'tabindex' => $sfgTabIndex,
			'autocompletesettings' => $autocompletionSource,
			'comboboxwidth' => $pixel_width,
		);
		if ( array_key_exists( 'existing values only', $other_args ) ) {
			$selectAttrs['existingvaluesonly'] = 'true';
		}
		$selectText = Xml::tags( 'select', $selectAttrs, $optionsText );

		$divClass = 'ui-widget';
		if ( $is_mandatory ) {
			$divClass .= ' mandatory';
		}
		$text = Xml::tags( 'div', array( 'class' => $divClass ), $selectText );
		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'size',
			'type' => 'int',
			'description' => wfMsg( 'sf_forminputs_size' )
		);
		$params = array_merge( $params, SFEnumInput::getValuesParameters() );
		$params[] = array(
			'name' => 'existing values only',
			'type' => 'boolean',
			'description' => wfMsg( 'sf_forminputs_existingvaluesonly' )
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
