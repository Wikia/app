<?php
/**
 * File holding the SFTextWithAutocompleteInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFTextWithAutocompleteInput class.
 *
 * @ingroup SFFormInput
 */
class SFTextWithAutocompleteInput extends SFTextInput {
	public static function getName() {
		return 'text with autocomplete';
	}

	public static function getDefaultPropTypes() {
		return array(
			'_wpg' => array()
		);
	}

	public static function getOtherPropTypesHandled() {
		return array( '_str' );
	}

	public static function getDefaultPropTypeLists() {
		return array(
			'_wpg' => array( 'is_list' => true, 'size' => 100 )
		);
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_str' );
	}

	public static function getAutocompletionTypeAndSource( &$field_args ) {
		if ( array_key_exists( 'values from property', $field_args ) ) {
			$autocompletionSource = $field_args['values from property'];
			$propValue = SMWPropertyValue::makeUserProperty( $autocompletionSource );
			if ( $propValue->getPropertyTypeID() == '_wpg' ) {
				$autocompleteFieldType = 'relation';
			} else {
				$autocompleteFieldType = 'attribute';
			}
		} elseif ( array_key_exists( 'values from category', $field_args ) ) {
			$autocompleteFieldType = 'category';
			$autocompletionSource = $field_args['values from category'];
		} elseif ( array_key_exists( 'values from concept', $field_args ) ) {
			$autocompleteFieldType = 'concept';
			$autocompletionSource = $field_args['values from concept'];
		} elseif ( array_key_exists( 'values from namespace', $field_args ) ) {
			$autocompleteFieldType = 'namespace';
			$autocompletionSource = $field_args['values from namespace'];
		} elseif ( array_key_exists( 'values from url', $field_args ) ) {
			$autocompleteFieldType = 'external_url';
			$autocompletionSource = $field_args['values from url'];
			// Autocompletion from URL is always done remotely.
			$field_args['remote autocompletion'] = true;
		} elseif ( array_key_exists( 'values', $field_args ) ) {
			global $sfgFieldNum;
			$autocompleteFieldType = 'values';
			$autocompletionSource = "values-$sfgFieldNum";
		} elseif ( array_key_exists( 'autocomplete field type', $field_args ) ) {
			$autocompleteFieldType = $field_args['autocomplete field type'];
			$autocompletionSource = $field_args['autocompletion source'];
		} elseif ( array_key_exists( 'semantic_property', $field_args ) ) {
			$autocompletionSource = $field_args['semantic_property'];
			$propValue = SMWPropertyValue::makeUserProperty( $autocompletionSource );
			if ( $propValue->getPropertyTypeID() == '_wpg' ) {
				$autocompleteFieldType = 'relation';
			} else {
				$autocompleteFieldType = 'attribute';
			}
		} else {
			$autocompleteFieldType = null;
			$autocompletionSource = null;
		}

		if ( $autocompleteFieldType != 'external_url' ) {
			global $wgContLang;
			$autocompletionSource = $wgContLang->ucfirst( $autocompletionSource );
		}

		return array( $autocompleteFieldType, $autocompletionSource );
	}

	public static function setAutocompleteValues( $field_args ) {
		global $sfgAutocompleteValues;

		// Get all autocomplete-related values, plus delimiter value
		// (it's needed also for the 'uploadable' link, if there is one).
		list( $autocompleteFieldType, $autocompletionSource ) =
			self::getAutocompletionTypeAndSource( $field_args );
		$autocompleteSettings = $autocompletionSource;
		$is_list = ( array_key_exists( 'is_list', $field_args ) && $field_args['is_list'] == true );
		if ( $is_list ) {
			$autocompleteSettings .= ',list';
			if ( array_key_exists( 'delimiter', $field_args ) ) {
				$delimiter = $field_args['delimiter'];
				$autocompleteSettings .= ',' . $delimiter;
			} else {
				$delimiter = ',';
			}
		} else {
			$delimiter = null;
		}

		$remoteDataType = null;
		if ( array_key_exists( 'remote autocompletion', $field_args ) &&
				$field_args['remote autocompletion'] == true ) {
			$remoteDataType = $autocompleteFieldType;
		} elseif ( $autocompletionSource != '' ) {
			// @TODO - that count() check shouldn't be necessary
			if ( array_key_exists( 'possible_values', $field_args ) &&
			count( $field_args['possible_values'] ) > 0 ) {
				$autocompleteValues = $field_args['possible_values'];
			} elseif ( $autocompleteFieldType == 'values' ) {
				$autocompleteValues = explode( ',', $field_args['values'] );
			} else {
				$autocompleteValues = SFUtils::getAutocompleteValues( $autocompletionSource, $autocompleteFieldType );
			}
			$sfgAutocompleteValues[$autocompleteSettings] = $autocompleteValues;
		}
		return array( $autocompleteSettings, $remoteDataType, $delimiter );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// Backwards compatibility, for pre-SF-2.1 forms:
		// if 'no autocomplete' was specified, switch to SFTextInput.
		if ( array_key_exists( 'no autocomplete', $other_args ) &&
				$other_args['no autocomplete'] == true ) {
			unset( $other_args['autocompletion source'] );
			return SFTextInput::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
		}

		global $sfgTabIndex, $sfgFieldNum;

		list( $autocompleteSettings, $remoteDataType, $delimiter ) = self::setAutocompleteValues( $other_args );

		$className = ( $is_mandatory ) ? 'autocompleteInput mandatoryField' : 'autocompleteInput createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		$input_id = 'input_' . $sfgFieldNum;

		if ( array_key_exists( 'size', $other_args ) ) {
			$size = $other_args['size'];
		} elseif ( array_key_exists( 'is_list', $other_args ) && $other_args['is_list'] ) {
			$size = '100';
		} else {
			$size = '35';
		}

		$inputAttrs = array(
			'type' => 'text',
			'id' => $input_id,
			'name' => $input_name,
			'value' => $cur_value,
			'size' => $size,
			'class' => $className,
			'tabindex' => $sfgTabIndex,
			'autocompletesettings' => $autocompleteSettings,
		);
		if ( !is_null( $remoteDataType ) ) {
			$inputAttrs['autocompletedatatype'] = $remoteDataType;
		}
		if ( $is_disabled ) {
			$inputAttrs['disabled'] = 'disabled';
		}
		if ( array_key_exists( 'maxlength', $other_args ) ) {
			$inputAttrs['maxlength'] = $other_args['maxlength'];
		}
		$text = "\n\t" . Xml::element( 'input', $inputAttrs ) . "\n";

		if ( array_key_exists( 'is_uploadable', $other_args ) && $other_args['is_uploadable'] == true ) {
			if ( array_key_exists( 'default filename', $other_args ) ) {
				$default_filename = $other_args['default filename'];
			} else {
				$default_filename = '';
			}
			$text .= self::uploadLinkHTML( $input_id, $delimiter, $default_filename );
		}

		$spanClass = 'inputSpan';
		if ( $is_mandatory ) {
			$spanClass .= ' mandatoryFieldSpan';
		}
		$text = "\n" . Xml::tags( 'span', array( 'class' => $spanClass ), $text );

		return $text;
	}

	public static function getAutocompletionParameters() {
		$params = SFEnumInput::getValuesParameters();
		$params[] = array(
			'name' => 'values from url',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_valuesfromurl' )
		);
		$params[] = array(
			'name' => 'remote autocompletion',
			'type' => 'boolean',
			'description' => wfMsg( 'sf_forminputs_remoteautocompletion' )
		);
		$params[] = array(
			'name' => 'list',
			'type' => 'boolean',
			'description' => wfMsg( 'sf_forminputs_list' )
		);
		$params[] = array(
			'name' => 'delimiter',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_delimiter' )
		);
		return $params;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params = array_merge( $params, self::getAutocompletionParameters() );
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
