<?php
/**
 * File holding the SFCheckboxesInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFCheckboxesInput class.
 *
 * @ingroup SFFormInput
 */
class SFCheckboxesInput extends SFMultiEnumInput {

	public static function getName() {
		return 'checkboxes';
	}

	public static function getDefaultPropTypeLists() {
		return array(
			'enumeration' => array()
		);
	}

	public static function getOtherPropTypeListsHandled() {
		return array();
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$checkbox_class = ( $is_mandatory ) ? 'mandatoryField' : 'createboxInput';
		$span_class = 'checkboxSpan';
		if ( array_key_exists( 'class', $other_args ) ) {
			$span_class .= ' ' . $other_args['class'];
		}
		$input_id = "input_$sfgFieldNum";
		// get list delimiter - default is comma
		if ( array_key_exists( 'delimiter', $other_args ) ) {
			$delimiter = $other_args['delimiter'];
		} else {
			$delimiter = ',';
		}
		$cur_values = SFUtils::getValuesArray( $cur_value, $delimiter );

		if ( ( $possible_values = $other_args['possible_values'] ) == null ) {
			$possible_values = array();
		}
		$text = '';
		foreach ( $possible_values as $key => $possible_value ) {
			$cur_input_name = $input_name . '[' . $key . ']';

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

			$checkbox_attrs = array(
				'type' => 'checkbox',
				'id' => $input_id,
				'tabindex' => $sfgTabIndex,
				'name' => $cur_input_name,
				'value' => $possible_value,
				'class' => $checkbox_class,
			);
			if ( in_array( $possible_value, $cur_values ) ) {
				$checkbox_attrs['checked'] = 'checked';
			}
			if ( $is_disabled ) {
				$checkbox_attrs['disabled'] = 'disabled';
			}
			$checkbox_input = Xml::element( 'input', $checkbox_attrs );

			// Make a span around each checkbox, for CSS purposes.
			$text .= '	' . Xml::tags( 'span',
				array( 'class' => $span_class ),
				$checkbox_input . ' ' . $label
			) . "\n";
			$sfgTabIndex++;
			$sfgFieldNum++;
		}

		$outerSpanID = "span_$sfgFieldNum";
		$outerSpanClass = 'checkboxesSpan';
		if ( $is_mandatory ) {
			$outerSpanClass .= ' mandatoryFieldSpan';
		}

		if ( array_key_exists( 'show on select', $other_args ) ) {
			$outerSpanClass .= ' sfShowIfChecked';
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $outerSpanID, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$outerSpanID][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$outerSpanID] = array( array( $options, $div_id ) );
				}
			}
		}

		$text .= SFFormUtils::hiddenFieldHTML( $input_name . '[is_list]', 1 );
		$outerSpanAttrs = array( 'id' => $outerSpanID, 'class' => $outerSpanClass );
		$text = "\t" . Xml::tags( 'span', $outerSpanAttrs, $text ) . "\n";

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
