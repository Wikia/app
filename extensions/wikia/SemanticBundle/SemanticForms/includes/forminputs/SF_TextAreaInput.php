<?php
/**
 * File holding the SFTextAreaInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFTextAreaInput class.
 *
 * @ingroup SFFormInput
 */
class SFTextAreaInput extends SFFormInput {
	public static function getName() {
		return 'textarea';
	}

	public static function getDefaultPropTypes() {
		return array( '_txt' => array(), '_cod' => array() );
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_wpg', '_str' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum;

		$className = ( $is_mandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= " " . $other_args['class'];
		}
		// Use a special ID for the free text field, for FCK's needs.
		$input_id = $input_name == 'free_text' ? 'free_text' : "input_$sfgFieldNum";

		if ( array_key_exists( 'rows', $other_args ) ) {
			$rows = $other_args['rows'];
		} else {
			$rows = 5;
		}

		if ( array_key_exists( 'autogrow', $other_args ) ) {
			$className .= ' autoGrow';
		}

		$textarea_attrs = array(
			'tabindex' => $sfgTabIndex,
			'id' => $input_id,
			'name' => $input_name,
			'rows' => $rows,
			'class' => $className,
		);

		if ( array_key_exists( 'cols', $other_args ) ) {
			$textarea_attrs['cols'] = $other_args['cols'];
		} else {
			$textarea_attrs['style'] = 'width: 100%';
		}

		if ( $is_disabled ) {
			$textarea_attrs['disabled'] = 'disabled';
		}
		if ( array_key_exists( 'maxlength', $other_args ) ) {
			$maxlength = $other_args['maxlength'];
			// For every actual character pressed (i.e., excluding
			// things like the Shift key), reduce the string to its
			// allowed length if it's exceeded that.
			// This JS code is complicated so that it'll work
			// correctly in IE - IE moves the cursor to the end
			// whenever this.value is reset, so we'll make sure to
			// do that only when we need to.
			$maxLengthJSCheck = "if (window.event && window.event.keyCode < 48 && window.event.keyCode != 13) return; if (this.value.length > $maxlength) { this.value = this.value.substring(0, $maxlength); }";
			$textarea_attrs['onKeyDown'] = $maxLengthJSCheck;
			$textarea_attrs['onKeyUp'] = $maxLengthJSCheck;
		}
		// Bug in Xml::element()? It doesn't close the textarea tag
		// properly if the text inside is null - set it to '' instead.
		if ( is_null( $cur_value ) ) {
			$cur_value = '';
		}
		$text = Xml::element( 'textarea', $textarea_attrs, $cur_value, false );
		$spanClass = 'inputSpan';
		if ( $is_mandatory ) {
			$spanClass .= ' mandatoryFieldSpan';
		}
		$text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );
		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'preload',
			'type' => 'string',
			'description' => wfMsg( 'sf_forminputs_preload' )
		);
		$params[] = array(
			'name' => 'rows',
			'type' => 'int',
			'description' => wfMsg( 'sf_forminputs_rows' )
		);
		$params[] = array(
			'name' => 'cols',
			'type' => 'int',
			'description' => wfMsg( 'sf_forminputs_cols' )
		);
		$params[] = array(
			'name' => 'maxlength',
			'type' => 'int',
			'description' => wfMsg( 'sf_forminputs_maxlength' )
		);
		$params[] = array(
			'name' => 'autogrow',
			'type' => 'boolean',
			'description' => wfMsg( 'sf_forminputs_autogrow' )
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
