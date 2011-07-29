<?php
/**
 * File holding the SFTextAreaWithAutocompleteInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFTextAreaWithAutocompleteInput class.
 *
 * @ingroup SFFormInput
 */
class SFTextAreaWithAutocompleteInput extends SFTextAreaInput {
	public static function getName() {
		return 'textarea with autocomplete';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// If 'no autocomplete' was specified, print a regular
		// textarea instead.
		if ( array_key_exists( 'no autocomplete', $other_args ) &&
				$other_args['no autocomplete'] == true ) {
			unset( $other_args['autocompletion source'] );
			return SFTextAreaInput::getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args );
		}

		global $sfgTabIndex, $sfgFieldNum;

		list( $autocompleteSettings, $remoteDataType, $delimiter ) = SFTextWithAutocompleteInput::setAutocompleteValues( $other_args );

		$className = ( $is_mandatory ) ? 'autocompleteInput mandatoryField' : 'autocompleteInput createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		$input_id = 'input_' . $sfgFieldNum;

		if ( array_key_exists( 'rows', $other_args ) ) {
			$rows = $other_args['rows'];
		} else {
			$rows = 5;
		}
		if ( array_key_exists( 'cols', $other_args ) ) {
			$cols = $other_args['cols'];
		} else {
			$cols = 80;
		}
		$text = '';
		if ( array_key_exists( 'autogrow', $other_args ) ) {
			$className .= ' autoGrow';
		}

		$textarea_attrs = array(
			'tabindex' => $sfgTabIndex,
			'id' => $input_id,
			'name' => $input_name,
			'rows' => $rows,
			'cols' => $cols,
			'class' => $className,
			'autocompletesettings' => $autocompleteSettings,
		);
		if ( !is_null( $remoteDataType ) ) {
			$textarea_attrs['autocompletedatatype'] = $remoteDataType;
		}
		if ( $is_disabled ) {
			$textarea_attrs['disabled'] = 'disabled';
		}
		if ( array_key_exists( 'maxlength', $other_args ) ) {
			$maxlength = $other_args['maxlength'];
			// For every actual character pressed (i.e., excluding
			// things like the Shift key), reduce the string to
			// its allowed length if it's exceeded that.
			// This JS code is complicated so that it'll work
			// correctly in IE - IE moves the cursor to the end
			// whenever this.value is reset, so we'll make sure
			// to do that only when we need to.
			$maxLengthJSCheck = "if (window.event && window.event.keyCode < 48 && window.event.keyCode != 13) return; if (this.value.length > $maxlength) { this.value = this.value.substring(0, $maxlength); }";
			$textarea_attrs['onKeyDown'] = $maxLengthJSCheck;
			$textarea_attrs['onKeyUp'] = $maxLengthJSCheck;
		}
		// Bug in Xml::element()? It doesn't close the textarea tag
		// properly if the text inside is null - set it to '' instead.
		if ( is_null( $cur_value ) ) {
			$cur_value = '';
		}
		$textarea_input = Xml::element( 'textarea', $textarea_attrs, $cur_value, false );
		$text .= $textarea_input;

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

	public static function getParameters() {
		$params = parent::getParameters();
		$params = array_merge( $params, SFTextWithAutocompleteInput::getAutocompletionParameters() );
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
