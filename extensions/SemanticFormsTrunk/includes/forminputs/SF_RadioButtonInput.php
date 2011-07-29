<?php
/**
 * File holding the SFRadioButtonInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFRadioButtonInput class.
 *
 * @ingroup SFFormInput
 */
class SFRadioButtonInput extends SFEnumInput {
	public static function getName() {
		return 'radiobutton';
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		if ( ( $possible_values = $other_args['possible_values'] ) == null ) {
			// If it's a Boolean property, display 'Yes' and 'No'
			// as the values.
			if ( $other_args['property_type'] == '_boo' ) {
				$possible_values = array(
					SFUtils::getWordForYesOrNo( true ),
					SFUtils::getWordForYesOrNo( false ),
				);
			} else {
				$possible_values = array();
			}
		}

		// Add a "None" value at the beginning, unless this is a
		// mandatory field and there's a current value in place (either
		// through a default value or because we're editing an existing
		// page).
		if ( !$is_mandatory || $cur_value == '' ) {
			array_unshift( $possible_values, '' );
		}

		// Set $cur_value to be one of the allowed options, if it isn't
		// already - that makes it easier to automatically have one of
		// the radiobuttons be checked at the beginning.
		if ( !in_array( $cur_value, $possible_values ) ) {
			if ( in_array( '', $possible_values ) ) {
				$cur_value = '';
			} else {
				$cur_value = $possible_values[0];
			}
		}

		$text = '';
		$itemClass = 'radioButtonItem';
		if ( array_key_exists( 'class', $other_args ) ) {
			$itemClass .= ' ' . $other_args['class'];
		}
		$itemAttrs = array( 'class' => $itemClass );

		foreach ( $possible_values as $i => $possible_value ) {
			$sfgTabIndex++;
			$sfgFieldNum++;
			$input_id = "input_$sfgFieldNum";

			$radiobutton_attrs = array(
				'type' => 'radio',
				'id' => $input_id,
				'tabindex' => $sfgTabIndex,
				'name' => $input_name,
				'value' => $possible_value,
			);
			if ( $cur_value == $possible_value ) {
				$radiobutton_attrs['checked'] = 'checked';
			}
			if ( $is_disabled ) {
				$radiobutton_attrs['disabled'] = 'disabled';
			}
			if ( $possible_value == '' ) { // blank/"None" value
				$label = wfMsg( 'sf_formedit_none' );
			} elseif (
				array_key_exists( 'value_labels', $other_args ) &&
				is_array( $other_args['value_labels'] ) &&
				array_key_exists( $possible_value, $other_args['value_labels'] )
			)
			{
				$label = htmlspecialchars( $other_args['value_labels'][$possible_value] );
			} else {
				$label = $possible_value;
			}

			$text .= "\t" . Xml::openElement( 'span', $itemAttrs ) .
				Xml::element( 'input', $radiobutton_attrs ) . " $label\n" .
				Xml::closeElement( 'span' );
		}

		$spanClass = 'radioButtonSpan';
		if ( array_key_exists( 'class', $other_args ) ) {
			$spanClass .= ' ' . $other_args['class'];
		}
		if ( $is_mandatory ) {
			$spanClass .= ' mandatoryFieldSpan';
		}

		$spanID = "span_$sfgFieldNum";

		// Do the 'show on select' handling.
		if ( array_key_exists( 'show on select', $other_args ) ) {
			$spanClass .= ' sfShowIfChecked';
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $spanID, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$spanID][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$spanID] = array( array( $options, $div_id ) );
				}
			}
		}
		$spanAttrs = array(
			'id' => $spanID,
			'class' => $spanClass
		);
		$text = Xml::tags( 'span', $spanAttrs, $text );

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
