<?php
/**
 * File holding the SFDropdownInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFDropdownInput class.
 *
 * @ingroup SFFormInput
 */
class SFDropdownInput extends SFEnumInput {
	public static function getName() {
		return 'dropdown';
	}

	public static function getDefaultPropTypes() {
		return array(
			'enumeration' => array()
		);
	}

	public static function getOtherPropTypesHandled() {
		return array( '_boo' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$className = ( $is_mandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		$input_id = "input_$sfgFieldNum";
		if ( array_key_exists( 'show on select', $other_args ) ) {
			$className .= ' sfShowIfSelected';
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $input_id, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$input_id][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$input_id] = array( array( $options, $div_id ) );
				}
			}
		}
		$innerDropdown = '';
		// Add a blank value at the beginning, unless this is a
		// mandatory field and there's a current value in place
		// (either through a default value or because we're editing
		// an existing page).
		if ( !$is_mandatory || $cur_value == '' ) {
			$innerDropdown .= "	<option value=\"\"></option>\n";
		}
		if ( ( $possible_values = $other_args['possible_values'] ) == null ) {
			// If it's a Boolean property, display 'Yes' and 'No'
			// as the values.
			if ( array_key_exists( 'property_type', $other_args ) && $other_args['property_type'] == '_boo' ) {
				$possible_values = array(
					SFUtils::getWordForYesOrNo( true ),
					SFUtils::getWordForYesOrNo( false ),
				);
			} else {
				$possible_values = array();
			}
		}
		foreach ( $possible_values as $possible_value ) {
			$optionAttrs = array( 'value' => $possible_value );
			if ( $possible_value == $cur_value ) {
				$optionAttrs['selected'] = "selected";
			}
			if (
				array_key_exists( 'value_labels', $other_args ) &&
				is_array( $other_args['value_labels'] ) &&
				array_key_exists( $possible_value, $other_args['value_labels'] )
			)
			{
				$label = $other_args['value_labels'][$possible_value];
			} else {
				$label = $possible_value;
			}
			$innerDropdown .= Xml::element( 'option', $optionAttrs, $label );
		}
		$selectAttrs = array(
			'id' => $input_id,
			'tabindex' => $sfgTabIndex,
			'name' => $input_name,
			'class' => $className
		);
		if ( $is_disabled ) {
			$selectAttrs['disabled'] = 'disabled';
		}
		$text = Xml::tags( 'select', $selectAttrs, $innerDropdown );
		$spanClass = 'inputSpan';
		if ( $is_mandatory ) {
			$spanClass .= ' mandatoryFieldSpan';
		}
		$text = Xml::tags( 'span', array( 'class' => $spanClass ), $text );
		return $text;
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
