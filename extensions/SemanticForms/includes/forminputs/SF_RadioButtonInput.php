<?php
/**
 * File holding the SFRadioButtonInput class
 *
 * @file
 * @ingroup SF
 */

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

		// Standardize $cur_value
		if ( is_null( $cur_value ) ) { $cur_value = ''; }

		if ( ( $possible_values = $other_args['possible_values'] ) == null ) {
			// If it's a Boolean property, display 'Yes' and 'No'
			// as the values.
			if ( array_key_exists( 'property_type', $other_args ) &&
				$other_args['property_type'] == '_boo' ) {
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
		if ( !$is_mandatory || $cur_value === '' ) {
			array_unshift( $possible_values, '' );
		}

		// Set $cur_value to be one of the allowed options, if it isn't
		// already - that makes it easier to automatically have one of
		// the radiobuttons be checked at the beginning.
		if ( !in_array( $cur_value, $possible_values ) ) {
			if ( in_array( '', $possible_values ) ) {
				$cur_value = '';
			} elseif ( count( $possible_values ) == 0 ) {
				$cur_value = '';
			} else {
				$cur_value = reset($possible_values);
			}
		}

		$text = "\n";
		$itemClass = 'radioButtonItem';
		if ( array_key_exists( 'class', $other_args ) ) {
			$itemClass .= ' ' . $other_args['class'];
		}
		$itemAttrs = array( 'class' => $itemClass );

		foreach ( $possible_values as $possible_value ) {
			$sfgTabIndex++;
			$sfgFieldNum++;
			$input_id = "input_$sfgFieldNum";

			$radiobutton_attrs = array(
				'id' => $input_id,
				'tabindex' => $sfgTabIndex,
			);
			if ( array_key_exists( 'origName', $other_args ) ) {
				$radiobutton_attrs['origname'] = $other_args['origName'];
			}
			$isChecked = false;
			if ( $cur_value == $possible_value ) {
				$isChecked = true;
				//$radiobutton_attrs['checked'] = true;
			}
			if ( $is_disabled ) {
				$radiobutton_attrs['disabled'] = true;
			}
			if ( $possible_value === '' ) { // blank/"None" value
				$label = wfMessage( 'sf_formedit_none' )->text();
			} elseif (
				array_key_exists( 'value_labels', $other_args ) &&
				is_array( $other_args['value_labels'] ) &&
				array_key_exists( $possible_value, $other_args['value_labels'] )
			) {
				$label = htmlspecialchars( $other_args['value_labels'][$possible_value] );
			} else {
				$label = $possible_value;
			}

			$text .= "\t" . Html::rawElement( 'label', $itemAttrs,
				// Using Xml::radio() here because Html::input()
				// unfortunately doesn't include the "value="
				// attribute if the value is blank - which
				// somehow leads to the string "on" being passed
				// to the page.
				//Html::input( $input_name, $possible_value, 'radio', $radiobutton_attrs ) . " $label" ) . "\n";
				Xml::radio( $input_name, $possible_value, $isChecked, $radiobutton_attrs ) . " $label" ) . "\n";
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
		$text = Html::rawElement( 'span', $spanAttrs, $text );

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
			$this->mOtherArgs
		);
	}
}
