<?php
/**
 * File holding the SFTextAreaWithAutocompleteInput class
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFTextAreaWithAutocompleteInput class.
 *
 * @ingroup SFFormInput
 */
class SFTextAreaWithAutocompleteInput extends SFTextAreaInput {
	public static function getName() {
		return 'textarea with autocomplete';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getDefaultCargoTypes() {
		return array();
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params = array_merge( $params, SFTextWithAutocompleteInput::getAutocompletionParameters() );
		return $params;
	}

	protected function getTextAreaAttributes() {
		$textarea_attrs = parent::getTextAreaAttributes();

		// If 'no autocomplete' was specified, print a regular
		// textarea instead.
		if ( !array_key_exists( 'no autocomplete', $this->mOtherArgs ) ||
			$this->mOtherArgs['no autocomplete'] == false
		) {
			list( $autocompleteSettings, $remoteDataType, $delimiter ) = SFTextWithAutocompleteInput::setAutocompleteValues( $this->mOtherArgs );

			if ( !is_null( $remoteDataType ) ) {
				$textarea_attrs['autocompletedatatype'] = $remoteDataType;
			}

			$textarea_attrs['autocompletesettings'] = $autocompleteSettings;

			$textarea_attrs['class'] .= ' autocompleteInput';
		}

		return $textarea_attrs;
	}
}
