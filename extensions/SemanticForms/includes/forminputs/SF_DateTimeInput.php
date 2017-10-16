<?php
/**
 * File holding the SFDateTimeInput class
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFDateTimeInput class.
 *
 * @ingroup SFFormInput
 */
class SFDateTimeInput extends SFDateInput {
	public static function getName() {
		return 'datetime';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getOtherPropTypesHandled() {
		return array( '_dat' );
	}

	public static function getDefaultCargoTypes() {
		return array( 'Datetime' => array() );
	}

	public static function getHTML( $datetime, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfg24HourTime;

		$include_timezone = array_key_exists( 'include timezone', $other_args );

		if ( $datetime ) {
			// Can show up here either as an array or a string,
			// depending on whether it came from user input or a
			// wiki page.
			if ( is_array( $datetime ) ) {
				if ( isset( $datetime['hour'] ) ) {
					$hour = $datetime['hour'];
				}
				if ( isset( $datetime['minute'] ) ) {
					$minute = $datetime['minute'];
				}
				if ( isset( $datetime['second'] ) ) {
					$second = $datetime['second'];
				}
				if ( !$sfg24HourTime ) {
					if ( isset( $datetime['ampm24h'] ) ) {
						$ampm24h = $datetime['ampm24h'];
					}
				}
				if ( isset( $datetime['timezone'] ) ) {
					$timezone = $datetime['timezone'];
				}
			} else {
				// Parse the date.
				// We get only the time data here - the main
				// date data is handled by the call to
				// parent::getMainHTML().

				// Handle 'default=now'.
				if ( $datetime == 'now' ) {
					global $wgLocaltimezone;
					if ( isset( $wgLocaltimezone ) ) {
						$serverTimezone = date_default_timezone_get();
						date_default_timezone_set( $wgLocaltimezone );
					}
					$actual_date = time();
				} else {
					$actual_date = strtotime( $datetime );
				}
				if ( $sfg24HourTime ) {
					$hour = date( 'G', $actual_date );
				} else {
					$hour = date( 'g', $actual_date );
				}
				$minute = date( 'i', $actual_date );
				$second = date( 's', $actual_date );
				if ( !$sfg24HourTime ) {
					$ampm24h = date( 'A', $actual_date );
				}
				$timezone = date( 'T', $actual_date );
				// Restore back to the server's timezone.
				if ( $datetime == 'now' ) {
					if ( isset( $wgLocaltimezone ) ) {
						date_default_timezone_set( $serverTimezone );
					}
				}
			}
		} else {
			$hour = null;
			$minute = null;
			$second = '00'; // default at least this value
			$ampm24h = '';
			$timezone = '';
		}

		$text = parent::getMainHTML( $datetime, $input_name, $is_mandatory, $is_disabled, $other_args );
		$disabled_text = ( $is_disabled ) ? 'disabled' : '';
		$text .= '	&#160;<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[hour]" type="text" class="hoursInput" value="' . $hour . '" size="2"/ ' . $disabled_text . '>';
		$sfgTabIndex++;
		$text .= '	:<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[minute]" type="text" class="minutesInput" value="' . $minute . '" size="2"/ ' . $disabled_text . '>';
		$sfgTabIndex++;
		$text .= ':<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[second]" type="text" class="secondsInput" value="' . $second . '" size="2"/ ' . $disabled_text . '>' . "\n";

		if ( !$sfg24HourTime ) {
			$sfgTabIndex++;
			$text .= '	 <select tabindex="' . $sfgTabIndex . '" name="' . $input_name . "[ampm24h]\" class=\"ampmInput\" $disabled_text>\n";
			$ampm24h_options = array( '', 'AM', 'PM' );
			foreach ( $ampm24h_options as $value ) {
				$text .= "				<option value=\"$value\"";
				if ( $value == $ampm24h ) { $text .= " selected=\"selected\""; }
				$text .= ">$value</option>\n";
			}
			$text .= "	</select>\n";
		}

		if ( $include_timezone ) {
			$sfgTabIndex++;
			$text .= '	<input tabindex="' . $sfgTabIndex . '" name="' . $input_name . '[timezone]" type="text" value="' . $timezone . '" size="3"/ ' . $disabled_text . '>' . "\n";
		}

		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'include timezone',
			'type' => 'boolean',
			'description' => wfMessage( 'sf_forminputs_includetimezone' )->text()
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
			$this->mOtherArgs
		);
	}
}
