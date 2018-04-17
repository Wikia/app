<?php

namespace Maps;

use Maps\Elements\ImageOverlay;
use ValueParsers\ParseException;
use ValueParsers\ValueParser;

/**
 * @since 3.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ImageOverlayParser implements ValueParser {

	private $geocoder;

	public function __construct() {
		$this->geocoder = MapsFactory::newDefault()->newGeocoder();
	}

	/**
	 * @since 3.1
	 *
	 * @param string $value
	 *
	 * @return ImageOverlay
	 * @throws ParseException
	 */
	public function parse( $value ) {
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
		$latLong = $this->geocoder->geocode( $location );

		if ( $location === null ) {
			throw new ParseException( 'Failed to parse or geocode' );
		}

		return $latLong;
	}

}
