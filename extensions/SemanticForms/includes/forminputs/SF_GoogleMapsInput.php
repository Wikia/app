<?php
/**
 * File holding the SFGoogleMapsInput class
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFGoogleMapsInput class.
 *
 * @ingroup SFFormInput
 */
class SFGoogleMapsInput extends SFFormInput {
	public static function getName() {
		return 'googlemaps';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum;
		global $wgOut;

                $scripts = array(
                        "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"
                );
                $scriptsHTML = '';
                foreach ( $scripts as $script ) {
                        $scriptsHTML .= Html::linkedScript( $script );
                }
                $wgOut->addHeadItem( $scriptsHTML, $scriptsHTML );
                $wgOut->addModules( 'ext.semanticforms.maps' );

		$parsedCurValue = SFOpenLayersInput::parseCoordinatesString( $cur_value );

		$coordsInput = Html::element( 'input', array( 'type' => 'text', 'class' => 'sfCoordsInput', 'name' => $input_name, 'value' => $parsedCurValue, 'size' => 40 ) );
		$mapUpdateButton = Html::element( 'input', array( 'type' => 'button', 'class' => 'sfUpdateMap', 'value' => wfMessage( 'sf-maps-setmarker' )->parse() ), null );
		$addressLookupInput = Html::element( 'input', array( 'type' => 'text', 'class' => 'sfAddressInput', 'size' => 40, 'placeholder' => wfMessage( 'sf-maps-enteraddress' )->parse() ), null );
		$addressLookupButton = Html::element( 'input', array( 'type' => 'button', 'class' => 'sfLookUpAddress', 'value' => wfMessage( 'sf-maps-lookupcoordinates' )->parse() ), null );
		$mapCanvas = Html::element( 'div', array( 'class' => 'sfMapCanvas', 'style' => 'height: 500px; width: 500px;' ), 'Map goes here...' );

		$fullInputHTML = <<<END
<div style="padding-bottom: 10px;">
$coordsInput
$mapUpdateButton
</div>
<div style="padding-bottom: 10px;">
$addressLookupInput
$addressLookupButton
</div>
$mapCanvas

END;
		$text = Html::rawElement( 'div', array( 'class' => 'sfGoogleMapsInput' ), $fullInputHTML );

		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
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
