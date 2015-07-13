<?php
/**
 * File holding the SFTokensInput class
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFTokensInput class.
 *
 * @ingroup SFFormInput
 */
class SFTokensInput extends SFFormInput {
	public static function getName() {
		return 'tokens';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getOtherPropTypesHandled() {
		$otherPropTypesHandled = array( '_wpg' );
		if ( defined( 'SMWDataItem::TYPE_STRING' ) ) {
			// SMW < 1.9
			$otherPropTypesHandled[] = '_str';
		} else {
			$otherPropTypesHandled[] = '_txt';
		}
		return $otherPropTypesHandled;
	}

	public static function getDefaultPropTypeLists() {
		return array(
			'_wpg' => array( 'is_list' => true, 'size' => 100 )
		);
	}

	public static function getOtherPropTypeListsHandled() {
		if ( defined( 'SMWDataItem::TYPE_STRING' ) ) {
			// SMW < 1.9
			return array( '_str' );
		} else {
			return array( '_txt' );
		}
	}

	public static function getDefaultCargoTypes() {
		return array();
	}

	public static function getOtherCargoTypesHandled() {
		return array( 'Page', 'String' );
	}

	public static function getDefaultCargoTypeLists() {
		return array(
			'Page' => array( 'is_list' => true, 'size' => 100 )
		);
	}

	public static function getOtherCargoTypeListsHandled() {
		return array( 'String' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum, $sfgEDSettings;

		$other_args['is_list'] = true;

		if ( array_key_exists( 'values from external data', $other_args ) ) {
			$autocompleteSettings = 'external data';
			$remoteDataType = null;
			if ( array_key_exists( 'origName', $other_args ) ) {
				$name = $other_args['origName'];
			} else {
				$name = $input_name;
			}
			$sfgEDSettings[$name] = array();
			if ( $other_args['values from external data'] != null ) {
				$sfgEDSettings[$name]['title'] = $other_args['values from external data'];
			}
			if ( array_key_exists( 'image', $other_args ) ) {
				$image_param =  $other_args['image'];
				$sfgEDSettings[$name]['image'] = $image_param;
				global $edgValues;
				for ($i = 0; $i < count($edgValues[$image_param]); $i++) {
					$image = $edgValues[$image_param][$i];
					if ( strpos( $image, "http" ) !== 0 ) {
						$file = wfFindFile( $image );
						if ( $file ) {
							$url = $file->getFullUrl();
							$edgValues[$image_param][$i] = $url;
						} else {
							$edgValues[$image_param][$i] = "";
						}
					}
				}
			}
			if ( array_key_exists( 'description', $other_args ) ) {
				$sfgEDSettings[$name]['description'] = $other_args['description'];
			}
		} else {
			list( $autocompleteSettings, $remoteDataType, $delimiter ) = SFTextWithAutocompleteInput::setAutocompleteValues( $other_args );
		}

		if ( is_array( $cur_value ) ) {
			$cur_value = implode( $delimiter, $cur_value );
		}

		$className = 'sfTokens ';
		$className .= ( $is_mandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		$input_id = 'input_' . $sfgFieldNum;

		if ( array_key_exists( 'size', $other_args ) ) {
			$size = $other_args['size'];
		} else {
			$size = '100';
		}

		$inputAttrs = array(
			'id' => $input_id,
			'size' => $size,
			'class' => $className,
			'tabindex' => $sfgTabIndex,
			'autocompletesettings' => $autocompleteSettings,
		);
		if ( array_key_exists( 'origName', $other_args ) ) {
			$inputAttrs['origName'] = $other_args['origName'];
		}
		if ( array_key_exists( 'existing values only', $other_args ) ) {
			$inputAttrs['existingvaluesonly'] = 'true';
		}
		if ( !is_null( $remoteDataType ) ) {
			$inputAttrs['autocompletedatatype'] = $remoteDataType;
		}
		if ( $is_disabled ) {
			$inputAttrs['disabled'] = true;
		}
		if ( array_key_exists( 'maxlength', $other_args ) ) {
			$inputAttrs['maxlength'] = $other_args['maxlength'];
		}
		if ( array_key_exists( 'placeholder', $other_args ) ) {
			$inputAttrs['placeholder'] = $other_args['placeholder'];
		}
		if ( array_key_exists( 'max values', $other_args ) ) {
			$inputAttrs['maxvalues'] = $other_args['max values'];
		}
		$text = "\n\t" . Html::input( $input_name, $cur_value, 'text', $inputAttrs ) . "\n";

		$spanClass = 'inputSpan';
		if ( $is_mandatory ) {
			$spanClass .= ' mandatoryFieldSpan';
		}
		$text = "\n" . Html::rawElement( 'span', array( 'class' => $spanClass ), $text );

		return $text;
	}


	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'size',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_size' )->text()
		);
		$params[] = array(
			'name' => 'placeholder',
			'type' => 'string',
			'description' => wfMessage( 'sf_forminputs_placeholder' )->text()
		);
		$params[] = array(
			'name' => 'existing values only',
			'type' => 'boolean',
			'description' => wfMessage( 'sf_forminputs_existingvaluesonly' )->text()
		);
		$params[] = array(
			'name' => 'max values',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_maxvalues' )->text()
		);
		$params = array_merge( $params, SFTextWithAutocompleteInput::getAutocompletionParameters() );

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
