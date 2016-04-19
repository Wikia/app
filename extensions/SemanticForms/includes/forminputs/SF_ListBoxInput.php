<?php
/**
 * File holding the SFListBoxInput class
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFListBoxInput class.
 *
 * @ingroup SFFormInput
 */
class SFListBoxInput extends SFMultiEnumInput {

	public static function getName() {
		return 'listbox';
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'size',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_listboxsize' )->text()
		);
		return $params;
	}

	/**
	 * Returns the HTML code to be included in the output page for this input.
	 */
	public function getHtmlText() {
		global $sfgTabIndex, $sfgFieldNum, $sfgShowOnSelect;

		$className = ( $this->mIsMandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'class', $this->mOtherArgs ) ) {
			$className .= ' ' . $this->mOtherArgs['class'];
		}
		$input_id = "input_$sfgFieldNum";
		// get list delimiter - default is comma
		if ( array_key_exists( 'delimiter', $this->mOtherArgs ) ) {
			$delimiter = $this->mOtherArgs['delimiter'];
		} else {
			$delimiter = ',';
		}
		$cur_values = SFUtils::getValuesArray( $this->mCurrentValue, $delimiter );
		$className .= ' sfShowIfSelected';

		if ( ( $possible_values = $this->mOtherArgs['possible_values'] ) == null ) {
			$possible_values = array();
		}
		$optionsText = '';
		foreach ( $possible_values as $possible_value ) {
			if (
				array_key_exists( 'value_labels', $this->mOtherArgs ) &&
				is_array( $this->mOtherArgs['value_labels'] ) &&
				array_key_exists( $possible_value, $this->mOtherArgs['value_labels'] )
			)
			{
				$optionLabel = $this->mOtherArgs['value_labels'][$possible_value];
			} else {
				$optionLabel = $possible_value;
			}
			$optionAttrs = array( 'value' => $possible_value );
			if ( in_array( $possible_value, $cur_values ) ) {
				$optionAttrs['selected'] = 'selected';
			}
			$optionsText .= Html::element( 'option', $optionAttrs, $optionLabel );
		}
		$selectAttrs = array(
			'id' => $input_id,
			'tabindex' => $sfgTabIndex,
			'name' => $this->mInputName . '[]',
			'class' => $className,
			'multiple' => 'multiple'
		);
		if ( array_key_exists( 'size', $this->mOtherArgs ) ) {
			$selectAttrs['size'] = $this->mOtherArgs['size'];
		}
		if ( $this->mIsDisabled ) {
			$selectAttrs['disabled'] = 'disabled';
		}
		$text = Html::rawElement( 'select', $selectAttrs, $optionsText );
		$text .= Html::hidden( $this->mInputName . '[is_list]', 1 );
		if ( $this->mIsMandatory ) {
			$text = Html::rawElement( 'span', array( 'class' => 'inputSpan mandatoryFieldSpan' ), $text );
		}

		if ( array_key_exists( 'show on select', $this->mOtherArgs ) ) {
			foreach ( $this->mOtherArgs['show on select'] as $div_id => $options ) {
				if ( array_key_exists( $input_id, $sfgShowOnSelect ) ) {
					$sfgShowOnSelect[$input_id][] = array( $options, $div_id );
				} else {
					$sfgShowOnSelect[$input_id] = array( array( $options, $div_id ) );
				}
			}
		}

		return $text;
	}
}
