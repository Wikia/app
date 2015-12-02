<?php
/**
 * File holding the SFCheckboxInput class
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFCheckboxInput class.
 *
 * @ingroup SFFormInput
 */
class SFCheckboxInput extends SFFormInput {
	public static function getName() {
		return 'checkbox';
	}

	public static function getDefaultPropTypes() {
		return array( '_boo' => array() );
	}

	public static function getDefaultCargoTypes() {
		return array( 'Boolean' => array() );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$className = ( $is_mandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		$input_id = "input_$sfgFieldNum";
		$disabled_text = ( $is_disabled ) ? 'disabled' : '';
		if ( array_key_exists( 'show on select', $other_args ) ) {
			$className .= ' sfShowIfCheckedCheckbox';
			$div_id = key( $other_args['show on select'] );
			$sfgShowOnSelect[$input_id] = $div_id;
		}

		// Can show up here either as an array or a string, depending on
		// whether it came from user input or a wiki page
		if ( is_array( $cur_value ) ) {
			$checked_str = ( array_key_exists( 'value', $cur_value ) && $cur_value['value'] == 'on' ) ? ' checked="checked"' : '';
		} else {
			// Default to false - no need to check if it matches
			// a 'false' word.
			$vlc = strtolower( trim( $cur_value ) );

			if ( in_array( $vlc, explode( ',', wfMessage( 'smw_true_words' )->inContentLanguage()->text() ), true ) ) {
				$checked_str = ' checked="checked"';
			} else {
				$checked_str = '';
			}
		}
		$text = <<<END
	<input name="{$input_name}[is_checkbox]" type="hidden" value="true" />
	<input id="$input_id" name="{$input_name}[value]" type="checkbox" class="$className" tabindex="$sfgTabIndex" $checked_str $disabled_text/>

END;
		return $text;
	}

	public static function getParameters() {
		// Remove the 'mandatory' option - it doesn't make sense for
		// checkboxes.
		$params = array();
		foreach ( parent::getParameters() as $param ) {
			if ( $param['name'] != 'mandatory' ) {
				$params[] = $param;
			}
		}
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
