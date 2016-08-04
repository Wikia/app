<?php

namespace Maps;

use DataValues\Geo\Parsers\GeoCoordinateParser;
use Maps\Elements\ImageOverlay;
use Maps\Elements\WmsOverlay;
use ValueParsers\ParseException;
use ValueParsers\StringValueParser;

/**
 * @since 3.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ImageOverlayParser extends StringValueParser {

	/**
	 * @since 3.1
	 *
	 * @param string $value
	 *
	 * @return WmsOverlay
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		$parameters = explode( '~', $value );
		$imageParameters = explode( ':', $parameters[0], 3 );

		if ( count( $imageParameters ) === 3 ) {
			$boundsNorthEast = $this->stringToLatLongValue( $imageParameters[0] );
			$boundsSouthWest = $this->stringToLatLongValue( $imageParameters[1] );
			$imageUrl = \MapsMapper::getFileUrl( $imageParameters[2] );

			return new ImageOverlay( $boundsNorthEast, $boundsSouthWest, $imageUrl );
		}

		throw new ParseException( 'Need 3 parameters for an image overlay' );
	}

	private function stringToLatLongValue( $location ) {
		$parser = new GeoCoordinateParser( new \ValueParsers\ParserOptions() );
		return $parser->parse( $location );
	}

}
