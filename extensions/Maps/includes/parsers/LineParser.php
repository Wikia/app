<?php

namespace Maps;

use DataValues\Geo\Parsers\GeoCoordinateParser;
use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Line;
use ValueParsers\StringValueParser;

/**
 * ValueParser that parses the string representation of a line.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Kim Eik
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LineParser extends StringValueParser {

	protected $supportGeocoding = true;

	// TODO: use options
	protected $metaDataSeparator = '~';

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 3.0
	 *
	 * @param string $value
	 *
	 * @return Line
	 */
	public function stringParse( $value ) {
		$parts = explode( $this->metaDataSeparator , $value );

		$line = $this->constructShapeFromLatLongValues( $this->parseCoordinates(
			explode( ':' , array_shift( $parts ) )
		) );

		$this->handleCommonParams( $parts, $line );

		return $line;
	}

	/**
	 * @since 3.0
	 *
	 * @param string[] $coordinateStrings
	 *
	 * @return LatLongValue[]
	 */
	protected function parseCoordinates( array $coordinateStrings ) {
		$coordinates = array();
		$coordinateParser = new GeoCoordinateParser( new \ValueParsers\ParserOptions() );

		$supportsGeocoding = $this->supportGeocoding && \Maps\Geocoders::canGeocode();

		foreach ( $coordinateStrings as $coordinateString ) {
			if ( $supportsGeocoding ) {
				$coordinate = \Maps\Geocoders::attemptToGeocode( $coordinateString );

				if ( $coordinate === false ) {
					// TODO
				}
				else {
					$coordinates[] = $coordinate;
				}
			}
			else {
				$coordinates[] = $coordinateParser->parse( $coordinateString );
			}
		}

		return $coordinates;
	}

	protected function constructShapeFromLatLongValues( array $locations ) {
		return new Line( $locations );
	}

	/**
	 * This method requires that parameters are positionally correct,
	 * 1. Link (one parameter) or bubble data (two parameters)
	 * 2. Stroke data (three parameters)
	 * 3. Fill data (two parameters)
	 * e.g ...title~text~strokeColor~strokeOpacity~strokeWeight~fillColor~fillOpacity
	 *
	 * @since 3.0
	 *
	 * @param array $params
	 * @param Line $line
	 */
	protected function handleCommonParams( array &$params, Line &$line ) {
		//Handle bubble and link parameters

		//create link data
		$linkOrTitle = array_shift( $params );
		if ( $link = $this->isLinkParameter( $linkOrTitle ) ) {
			$this->setLinkFromParameter( $line , $link );
		} else {
			//create bubble data
			$this->setBubbleDataFromParameter( $line , $params , $linkOrTitle );
		}


		//handle stroke parameters
		if ( $color = array_shift( $params ) ) {
			$line->setStrokeColor( $color );
		}

		if ( $opacity = array_shift( $params ) ) {
			$line->setStrokeOpacity( $opacity );
		}

		if ( $weight = array_shift( $params ) ) {
			$line->setStrokeWeight( $weight );
		}
	}

	protected function setBubbleDataFromParameter( Line &$line , &$params , $title ) {
		if ( $title ) {
			$line->setTitle( $title );
		}
		if ( $text = array_shift( $params ) ) {
			$line->setText( $text );
		}
	}

	protected function setLinkFromParameter( Line &$line , $link ) {
		if ( filter_var( $link , FILTER_VALIDATE_URL , FILTER_FLAG_SCHEME_REQUIRED ) ) {
			$line->setLink( $link );
		} else {
			$title = \Title::newFromText( $link );
			$line->setLink( $title->getFullURL() );
		}
	}

	/**
	 * Checks if a string is prefixed with link:
	 * @static
	 * @param $link
	 * @return bool|string
	 * @since 2.0
	 */
	private function isLinkParameter( $link ) {
		if ( strpos( $link , 'link:' ) === 0 ) {
			return substr( $link , 5 );
		}

		return false;
	}

}
