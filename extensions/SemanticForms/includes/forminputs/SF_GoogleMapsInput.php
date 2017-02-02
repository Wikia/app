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
class SFGoogleMapsInput extends SFOpenLayersInput {
	public static function getName() {
		return 'googlemaps';
	}

	public static function getDefaultCargoTypes() {
		return array();
	}

	public static function getOtherCargoTypesHandled() {
		return array( 'Coordinates' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgGoogleMapsKey, $sfgTabIndex, $sfgFieldNum;
		global $wgOut;

		$scripts = array(
			"https://maps.googleapis.com/maps/api/js?v=3.exp&key=$sfgGoogleMapsKey"
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
		$height = self::getHeight( $other_args );
		$width = self::getWidth( $other_args );
		$mapCanvas = Html::element( 'div', array( 'class' => 'sfMapCanvas', 'style' => "height: $height; width: $width;" ), 'Map goes here...' );

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
