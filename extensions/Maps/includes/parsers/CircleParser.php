<?php

namespace Maps;

use DataValues\Geo\Parsers\GeoCoordinateParser;
use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Circle;
use ValueParsers\ParseException;
use ValueParsers\StringValueParser;

/**
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Kim Eik
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CircleParser extends StringValueParser {

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
	 * @return Circle
	 */
	public function stringParse( $value ) {
		$metaData = explode( $this->metaDataSeparator , $value );
		$circleData = explode( ':' , array_shift( $metaData ) );

		$circle = new Circle( $this->stringToLatLongValue( $circleData[0] ), (float)$circleData[1] );

		if ( $metaData !== array() ) {
			$circle->setTitle( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$circle->setText( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$circle->setStrokeColor( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$circle->setStrokeOpacity( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$circle->setStrokeWeight( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$circle->setFillColor( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$circle->setFillOpacity( array_shift( $metaData ) );
		}

		return $circle;
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
