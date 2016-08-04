<?php

namespace Maps;

use Maps\Elements\WmsOverlay;
use ValueParsers\ParseException;
use ValueParsers\StringValueParser;

/**
 * ValueParser that parses the string representation of a WMS layer
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class WmsOverlayParser extends StringValueParser {

	/**
	 * Parses the provided string and returns the result.
	 *
	 * @since 3.0
	 *
	 * @param string $value
	 *
	 * @return WmsOverlay
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		$separator = " ";
		$metaData = explode($separator, $value);

		if ( count( $metaData ) >= 2 ) {
			$wmsOverlay = new WmsOverlay( $metaData[0], $metaData[1] );
			if ( count( $metaData ) == 3) {
				$wmsOverlay->setWmsStyleName( $metaData[2] );
			}

			return $wmsOverlay;
		}

		throw new ParseException( 'Need at least two parameters, url to WMS server and map layer name' );
	}
}
