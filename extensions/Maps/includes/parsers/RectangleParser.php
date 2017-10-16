<?php

namespace Maps;

use DataValues\Geo\Parsers\GeoCoordinateParser;
use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Rectangle;
use ValueParsers\ParseException;
use ValueParsers\StringValueParser;

/**
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Kim Eik
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class RectangleParser extends StringValueParser {

	private $supportGeocoding = true;

	// TODO: use options
	private $metaDataSeparator = '~';

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 3.0
	 *
	 * @param string $value
	 *
	 * @return Rectangle
	 */
	public function stringParse( $value ) {
		$metaData = explode( $this->metaDataSeparator , $value );
		$rectangleData = explode( ':' , array_shift( $metaData ) );

		$rectangle = new Rectangle(
			$this->stringToLatLongValue( $rectangleData[0] ),
			$this->stringToLatLongValue( $rectangleData[1] )
		);

		if ( $metaData !== array() ) {
			$rectangle->setTitle( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$rectangle->setText( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$rectangle->setStrokeColor( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$rectangle->setStrokeOpacity( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$rectangle->setStrokeWeight( array_shift( $metaData ) );
		}

		return $rectangle;
	}

	private function stringToLatLongValue( $location ) {
		if ( $this->supportGeocoding && Geocoders::canGeocode() ) {
			$location = Geocoders::attemptToGeocode( $location );

			if ( $location === false ) {
				throw new ParseException( 'Failed to parse or geocode' );
			}

			assert( $location instanceof LatLongValue );
			return $location;
		}

		$parser = new GeoCoordinateParser( new \ValueParsers\ParserOptions() );
		return $parser->parse( $location );
	}

}
