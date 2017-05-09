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
		$inputID = "input_$sfgFieldNum";
		if ( array_key_exists( 'show on select', $other_args ) ) {
			$className .= ' sfShowIfCheckedCheckbox';
			foreach ( $other_args['show on select'] as $div_id => $options ) {
				// We don't actually use "$options" for
				// anything, because it's just a checkbox.
				if ( array_key_exists( $inputID, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$inputID][] = $div_id;
				} else {
					$sfgShowOnSelect[$inputID] = array( $div_id );
				}
			}
		}

		// Can show up here either as an array or a string, depending on
		// whether it came from user input or a wiki page
		if ( is_array( $cur_value ) ) {
			$isChecked = array_key_exists( 'value', $cur_value ) && $cur_value['value'] == 'on';
		} else {
			// Default to false - no need to check if it matches
			// a 'false' word.
			$lowercaseCurValue = strtolower( trim( $cur_value ) );

			$possibleYesMessages = array(
				strtolower( wfMessage( 'htmlform-yes' )->inContentLanguage()->text() ),
				// Add in '1', and some hardcoded English.
				'1', 'yes', 'true'
			);

			// Add values from Semantic MediaWiki, if it's installed.
			if ( wfMessage( 'smw_true_words' )->exists() ) {
				$smwTrueWords = explode( ',', wfMessage( 'smw_true_words' )->inContentLanguage()->text() );
				foreach ( $smwTrueWords as $smwTrueWord ) {
					$possibleYesMessages[] = strtolower( trim( $smwTrueWord ) );
				}
			}
			$isChecked = in_array( $lowercaseCurValue, $possibleYesMessages );
		}
		$text = "\t" . Html::hidden( $input_name . '[is_checkbox]', 'true' ) . "\n";
		$checkboxAttrs = array(
			'id' => $inputID,
			'class' => $className,
			'tabindex' => $sfgTabIndex
		);
		if ( $is_disabled ) {
			$checkboxAttrs['disabled'] = true;
		}
		if ( method_exists( 'Html', 'check' ) ) {
			// MW 1.24+
			$text .= "\t" . Html::check( "{$input_name}[value]",
				$isChecked, $checkboxAttrs );
		} else {
			$text .= "\t" . Xml::check( "{$input_name}[value]",
				$isChecked, $checkboxAttrs );
		}
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
