<?php
/**
 * File holding the SFOpenLayersInput class
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFOpenLayersInput class.
 *
 * @ingroup SFFormInput
 */
class SFOpenLayersInput extends SFFormInput {
	public static function getName() {
		return 'openlayers';
	}

	public static function getDefaultPropTypes() {
		return array();
	}

	public static function getDefaultCargoTypes() {
		return array( 'Coordinates' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		global $sfgTabIndex, $sfgFieldNum;
		global $wgOut;

		$scripts = array(
			"http://www.openlayers.org/api/OpenLayers.js"
		);
		$scriptsHTML = '';
		foreach ( $scripts as $script ) {
			$scriptsHTML .= Html::linkedScript( $script );
		}
		$wgOut->addHeadItem( $scriptsHTML, $scriptsHTML );
		$wgOut->addModules( 'ext.semanticforms.maps' );

		$parsedCurValue = self::parseCoordinatesString( $cur_value );

		$coordsInput = Html::element( 'input', array( 'type' => 'text', 'class' => 'sfCoordsInput', 'name' => $input_name, 'value' => $parsedCurValue, 'size' => 40 ) );
		$mapUpdateButton = Html::element( 'input', array( 'type' => 'button', 'class' => 'sfUpdateMap', 'value' => wfMessage( 'sf-maps-setmarker' )->parse() ), null );
		// For OpenLayers, doing an address lookup, i.e. a geocode,
		// will require a separate geocoding address, which may
		// require a server-side reader to access that API.
		// For now, let's just not do this, since the Google Maps
		// input is much more widely used anyway.
		// @TODO - add this in.
		//$addressLookupInput = Html::element( 'input', array( 'type' => 'text', 'class' => 'sfAddressInput', 'size' => 40, 'placeholder' => wfMessage( 'sf-maps-enteraddress' )->parse() ), null );
		//$addressLookupButton = Html::element( 'input', array( 'type' => 'button', 'class' => 'sfLookUpAddress', 'value' => wfMessage( 'sf-maps-lookupcoordinates' )->parse() ), null );
		$mapCanvas = Html::element( 'div', array( 'class' => 'sfMapCanvas', 'id' => 'sfMapCanvas' . $sfgFieldNum, 'style' => 'height: 500px; width: 500px;' ), null );

		$fullInputHTML = <<<END
<div style="padding-bottom: 10px;">
$coordsInput
$mapUpdateButton
</div>

END;
/*
		$fullInputHTML = <<<END
<div style="padding-bottom: 10px;">
$addressLookupInput
$addressLookupButton
</div>

END;
*/
		$fullInputHTML .= "$mapCanvas\n";
		$text = Html::rawElement( 'div', array( 'class' => 'sfOpenLayersInput' ), $fullInputHTML );

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

	/**
	 * Parses one half of a set of coordinates into a number.
	 *
	 * Copied from CargoStore::coordinatePartToNumber() in the Cargo
	 * extension.
	 */
	public static function coordinatePartToNumber( $coordinateStr ) {
		$degreesSymbols = array( "\x{00B0}", "d" );
		$minutesSymbols = array( "'", "\x{2032}", "\x{00B4}" );
		$secondsSymbols = array( '"', "\x{2033}", "\x{00B4}\x{00B4}" );

		$numDegrees = null;
		$numMinutes = null;
		$numSeconds = null;

		foreach ( $degreesSymbols as $degreesSymbol ) {
			$pattern = '/([\d\.]+)' . $degreesSymbol . '/u';
			if ( preg_match( $pattern, $coordinateStr, $matches ) ) {
				$numDegrees = floatval( $matches[1] );
				break;
			}
		}
		if ( $numDegrees == null ) {
			throw new MWException( "Error: could not parse degrees in \"$coordinateStr\"." );
		}

		foreach ( $minutesSymbols as $minutesSymbol ) {
			$pattern = '/([\d\.]+)' . $minutesSymbol . '/u';
			if ( preg_match( $pattern, $coordinateStr, $matches ) ) {
				$numMinutes = floatval( $matches[1] );
				break;
			}
		}
		if ( $numMinutes == null ) {
			// This might not be an error - the number of minutes
			// might just not have been set.
			$numMinutes = 0;
		}

		foreach ( $secondsSymbols as $secondsSymbol ) {
			$pattern = '/(\d+)' . $secondsSymbol . '/u';
			if ( preg_match( $pattern, $coordinateStr, $matches ) ) {
				$numSeconds = floatval( $matches[1] );
				break;
			}
		}
		if ( $numSeconds == null ) {
			// This might not be an error - the number of seconds
			// might just not have been set.
			$numSeconds = 0;
		}

		return ( $numDegrees + ( $numMinutes / 60 ) + ( $numSeconds / 3600 ) );
	}

	/**
	 * Parses a coordinate string in (hopefully) any standard format.
	 *
	 * Copied from CargoStore::parseCoordinateString() in the Cargo
	 * extension.
	 */
	public static function parseCoordinatesString( $coordinatesString ) {
		$coordinatesString = trim( $coordinatesString );
		if ( $coordinatesString == null ) {
			return;
		}

		// This is safe to do, right?
		$coordinatesString = str_replace( array( '[', ']' ), '', $coordinatesString );
		// See if they're separated by commas.
		if ( strpos( $coordinatesString, ',' ) > 0 ) {
			$latAndLonStrings = explode( ',', $coordinatesString );
		} else {
			// If there are no commas, the first half, for the
			// latitude, should end with either 'N' or 'S', so do a
			// little hack to split up the two halves.
			$coordinatesString = str_replace( array( 'N', 'S' ), array( 'N,', 'S,' ), $coordinatesString );
			$latAndLonStrings = explode( ',', $coordinatesString );
		}

		if ( count( $latAndLonStrings ) != 2 ) {
			throw new MWException( "Error parsing coordinates string: \"$coordinatesString\"." );
		}
		list( $latString, $lonString ) = $latAndLonStrings;

		// Handle strings one at a time.
		$latIsNegative = false;
		if ( strpos( $latString, 'S' ) > 0 ) {
			$latIsNegative = true;
		}
		$latString = str_replace( array( 'N', 'S' ), '', $latString );
		if ( is_numeric( $latString ) ) {
			$latNum = floatval( $latString );
		} else {
			$latNum = self::coordinatePartToNumber( $latString );
		}
		if ( $latIsNegative ) {
			$latNum *= -1;
		}

		$lonIsNegative = false;
		if ( strpos( $lonString, 'W' ) > 0 ) {
			$lonIsNegative = true;
		}
		$lonString = str_replace( array( 'E', 'W' ), '', $lonString );
		if ( is_numeric( $lonString ) ) {
			$lonNum = floatval( $lonString );
		} else {
			$lonNum = self::coordinatePartToNumber( $lonString );
		}
		if ( $lonIsNegative ) {
			$lonNum *= -1;
		}

		return "$latNum, $lonNum";
	}

}
