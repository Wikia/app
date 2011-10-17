<?php
/**
 * File holding the SFListBoxInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFListBoxInput class.
 *
 * @ingroup SFFormInput
 */
class SFListBoxInput extends SFMultiEnumInput {

	public static function getName() {
		return 'listbox';
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$className = ( $is_mandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		$input_id = "input_$sfgFieldNum";
		// get list delimiter - default is comma
		if ( array_key_exists( 'delimiter', $other_args ) ) {
			$delimiter = $other_args['delimiter'];
		} else {
			$delimiter = ',';
		}
		$cur_values = SFUtils::getValuesArray( $cur_value, $delimiter );
		$className .= ' sfShowIfSelected';

		if ( ( $possible_values = $other_args['possible_values'] ) == null ) {
			$possible_values = array();
		}
		$optionsText = '';
		foreach ( $possible_values as $possible_value ) {
			if (
				array_key_exists( 'value_labels', $other_args ) &&
				is_array( $other_args['value_labels'] ) &&
				array_key_exists( $possible_value, $other_args['value_labels'] )
			)
			{
				$optionLabel = $other_args['value_labels'][$possible_value];
			} else {
				$optionLabel = $possible_value;
			}
			$optionAttrs = array( 'value' => $possible_value );
			if ( in_array( $possible_value, $cur_values ) ) {
				$optionAttrs['selected'] = 'selected';
			}
			$optionsText .= Xml::element( 'option', $optionAttrs, $optionLabel );
		}
		$selectAttrs = array(
			'id' => $input_id,
			'tabindex' => $sfgTabIndex,
			'name' => $input_name . '[]',
			'class' => $className,
			'multiple' => 'multiple'
		);
		if ( array_key_exists( 'size', $other_args ) ) {
			$selectAttrs['size'] = $other_args['size'];
		}
		if ( $is_disabled ) {
			$selectAttrs['disabled'] = 'disabled';
		}
		$text = Xml::tags( 'select', $selectAttrs, $optionsText );
		$text .= SFFormUtils::hiddenFieldHTML( $input_name . '[is_list]', 1 );
		if ( $is_mandatory ) {
			$text = Xml::tags( 'span', array( 'class' => 'inputSpan mandatoryFieldSpan' ), $text );
		}

		if ( array_key_exists( 'show on select', $other_args ) ) {
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $input_id, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$input_id][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$input_id] = array( array( $options, $div_id ) );
				}
			}
		}

		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'size',
			'type' => 'int',
			'description' => wfMsg( 'sf_forminputs_listboxsize' )
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
