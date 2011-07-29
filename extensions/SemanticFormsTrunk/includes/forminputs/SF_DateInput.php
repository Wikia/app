<?php
/**
 * File holding the SFDateInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFDateInput class.
 *
 * @ingroup SFFormInput
 */
class SFDateInput extends SFFormInput {
	public static function getName() {
		return 'date';
	}

	public static function getDefaultPropTypes() {
		return array( '_dat' => array() );
	}

	public static function monthDropdownHTML( $cur_month, $input_name, $is_disabled ) {
		global $sfgTabIndex, $wgAmericanDates;

		$optionsText = '';
		$month_names = SFFormUtils::getMonthNames();
		foreach ( $month_names as $i => $name ) {
			// pad out month to always be two digits
			$month_value = ( $wgAmericanDates == true ) ? $name : str_pad( $i + 1, 2, '0', STR_PAD_LEFT );
			$optionAttrs = array ( 'value' => $month_value );
			if ( $name == $cur_month || ( $i + 1 ) == $cur_month ) {
				$optionAttrs['selected'] = 'selected';
			}
			$optionsText .= Xml::element( 'option', $optionAttrs, $name );
		}
		$selectAttrs = array(
			'class' => 'monthInput',
			'name' => $input_name . '[month]',
			'tabindex' => $sfgTabIndex
		);
		if ( $is_disabled ) {
			$selectAttrs['disabled'] = 'disabled';
		}
		$text = Xml::tags( 'select', $selectAttrs, $optionsText );
		return $text;
	}

	public static function getMainHTML( $date, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $wgAmericanDates;

		$input_id = "input_$sfgFieldNum";

		if ( $date ) {
			// Can show up here either as an array or a string,
			// depending on whether it came from user input or a
			// wiki page.
			if ( is_array( $date ) ) {
				$year = $date['year'];
				$month = $date['month'];
				$day = $date['day'];
			} else {
				// handle 'default=now'
				if ( $date == 'now' ) {
					global $wgLocaltimezone;
					if ( isset( $wgLocaltimezone ) ) {
						$serverTimezone = date_default_timezone_get();
						date_default_timezone_set( $wgLocaltimezone );
					}
					$date = date( 'Y/m/d' );
					if ( isset( $wgLocaltimezone ) ) {
						date_default_timezone_set( $serverTimezone );
					}
				}
				$actual_date = new SMWTimeValue( '_dat' );
				$actual_date->setUserValue( $date );
				$year = $actual_date->getYear();
				// TODO - the code to convert from negative to
				// BC notation should be in SMW itself.
				if ( $year < 0 ) {
					$year = ( $year * - 1 + 1 ) . ' BC';
				}
				$month = $actual_date->getMonth();
				$day = $actual_date->getDay();
			}
		} else {
			$cur_date = getdate();
			$year = $cur_date['year'];
			$month = $cur_date['month'];
			$day = null; // no need for day
		}
		$text = "";
		$disabled_text = ( $is_disabled ) ? 'disabled' : '';
		$monthInput = self::monthDropdownHTML( $month, $input_name, $is_disabled );
		$dayInput = '	<input tabindex="' . $sfgTabIndex . '" class="dayInput" name="' . $input_name . '[day]" type="text" value="' . $day . '" size="2" ' . $disabled_text . '/>';
		if ( $wgAmericanDates ) {
			$text .= "$monthInput\n$dayInput\n";
		} else {
			$text .= "$dayInput\n$monthInput\n";
		}
		$text .= '	<input tabindex="' . $sfgTabIndex . '" class="yearInput" name="' . $input_name . '[year]" type="text" value="' . $year . '" size="4" ' . $disabled_text . '/>' . "\n";
		return $text;
	}

	public static function getHTML( $date, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		$text = self::getMainHTML( $date, $input_name, $is_mandatory, $is_disabled, $other_args );
		$spanClass = 'dateInput';
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
