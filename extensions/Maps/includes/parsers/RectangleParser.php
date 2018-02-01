<?php

namespace Maps;

use Maps\Elements\Rectangle;
use ValueParsers\ParseException;
use ValueParsers\StringValueParser;
use ValueParsers\ValueParser;

/**
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Kim Eik
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class RectangleParser implements ValueParser {

	private $metaDataSeparator = '~';

	private $geocoder;

	public function __construct() {
		$this->geocoder = MapsFactory::newDefault()->newGeocoder();
	}

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 3.0
	 *
	 * @param string $value
	 *
	 * @return Rectangle
	 */
	public function parse( $value ) {
		$metaData = explode( $this->metaDataSeparator, $value );
		$rectangleData = explode( ':', array_shift( $metaData ) );

		$rectangle = new Rectangle(
			$this->stringToLatLongValue( $rectangleData[0] ),
			$this->stringToLatLongValue( $rectangleData[1] )
		);

		if ( $metaData !== [] ) {
			$rectangle->setTitle( array_shift( $metaData ) );
		}

		if ( $metaData !== [] ) {
			$rectangle->setText( array_shift( $metaData ) );
		}

		if ( $metaData !== [] ) {
			$rectangle->setStrokeColor( array_shift( $metaData ) );
		}

		if ( $metaData !== [] ) {
			$rectangle->setStrokeOpacity( array_shift( $metaData ) );
		}

		if ( $metaData !== [] ) {
			$rectangle->setStrokeWeight( array_shift( $metaData ) );
		}

		return $rectangle;
	}

	private function stringToLatLongValue( $location ) {
		$latLong = $this->geocoder->geocode( $location );

		if ( $location === null ) {
			throw new ParseException( 'Failed to parse or geocode' );
		}

		return $latLong;
	}

}
