<?php

namespace DataValues\Geo\Parsers;

use ValueParsers\ParserOptions;

/**
 * Parser for geographical coordinates in Decimal Degree notation.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author H. Snater < mediawiki@snater.com >
 */
class DdCoordinateParser extends GeoCoordinateParserBase {

	/**
	 * The symbol representing degrees.
	 * @since 0.1
	 */
	const OPT_DEGREE_SYMBOL = 'degree';

	/**
	 * @param ParserOptions|null $options
	 */
	public function __construct( ParserOptions $options = null ) {
		parent::__construct( $options );

		$this->defaultOption( self::OPT_DEGREE_SYMBOL, '°' );

		$this->defaultDelimiters = array( $this->getOption( self::OPT_DEGREE_SYMBOL ) );
	}

	/**
	 * @see GeoCoordinateParserBase::getParsedCoordinate
	 */
	protected function getParsedCoordinate( $coordinateSegment ) {
		$coordinateSegment = $this->resolveDirection( $coordinateSegment );
		return $this->parseCoordinate( $coordinateSegment );
	}

	/**
	 * @see GeoCoordinateParserBase::areValidCoordinates
	 */
	protected function areValidCoordinates( array $normalizedCoordinateSegments ) {
		// TODO: Implement localized decimal separator.
		$baseRegExp = '\d{1,3}(\.\d{1,20})?' . $this->getOption( self::OPT_DEGREE_SYMBOL );

		// Cache whether the coordinates are specified in directional format (a mixture of
		// directional and non-directional is regarded invalid).
		$directional = false;

		$match = false;

		foreach( $normalizedCoordinateSegments as $i => $segment ) {
			$direction = '('
				. $this->getOption( self::OPT_NORTH_SYMBOL ) . '|'
				. $this->getOption( self::OPT_SOUTH_SYMBOL ) . ')';

			if( $i === 1 ) {
				$direction = '('
					. $this->getOption( self::OPT_EAST_SYMBOL ) . '|'
					. $this->getOption( self::OPT_WEST_SYMBOL ) . ')';
			}

			$match = preg_match(
				'/^(' . $baseRegExp . $direction . '|' . $direction . $baseRegExp . ')$/i',
				$segment
			);

			if( $directional ) {
				// Directionality is only set after parsing latitude: When the latitude is
				// is directional, the longitude needs to be as well. Therefore we break here since
				// checking for directionality is the only check needed for longitude.
				break;
			} elseif( $match ) {
				// Latitude is directional, no need to check for non-directionality.
				$directional = true;
				continue;
			}

			$match = preg_match( '/^(-)?' . $baseRegExp . '$/i', $segment );

			if( !$match ) {
				// Does neither match directional nor non-directional.
				break;
			}
		}

		return ( 1 === $match );
	}

	/**
	 * @see GeoCoordinateParserBase::stringParse
	 */
	protected function stringParse( $value ) {
		return parent::stringParse( $this->getNormalizedNotation( $value ) );
	}

	/**
	 * Returns a normalized version of the coordinate string.
	 *
	 * @param string $coordinates
	 *
	 * @return string
	 */
	protected function getNormalizedNotation( $coordinates ) {
		$coordinates = str_replace(
			array( '&#176;', '&deg;' ),
			$this->getOption( self::OPT_DEGREE_SYMBOL ), $coordinates
		);

		$coordinates = $this->removeInvalidChars( $coordinates );

		return $coordinates;
	}

	/**
	 * Returns a string with whitespace, control characters and characters with ASCII values above
	 * 126 removed.
	 *
	 * @see GeoCoordinateParserBase::removeInvalidChars
	 */
	protected function removeInvalidChars( $string ) {
		return str_replace( ' ', '', parent::removeInvalidChars( $string ) );
	}

	/**
	 * Converts a coordinate segment to float representation.
	 *
	 * @param string $coordinateSegment
	 *
	 * @return float
	 */
	protected function parseCoordinate( $coordinateSegment ) {
		return (float)str_replace(
			$this->getOption( self::OPT_DEGREE_SYMBOL ),
			'',
			$coordinateSegment
		);
	}

	/**
	 * @see GeoCoordinateParserBase::splitString
	 */
	protected function splitString( $normalizedCoordinateString ) {
		$separator = $this->getOption( self::OPT_SEPARATOR_SYMBOL );

		$normalizedCoordinateSegments = explode( $separator, $normalizedCoordinateString );

		if( count( $normalizedCoordinateSegments ) !== 2 ) {
			// Separator not present within the string, trying to figure out the segments by
			// splitting after the first direction character or degree symbol:
			$delimiters = $this->defaultDelimiters;

			$ns = array(
				$this->getOption( self::OPT_NORTH_SYMBOL ),
				$this->getOption( self::OPT_SOUTH_SYMBOL )
			);

			$ew = array(
				$this->getOption( self::OPT_EAST_SYMBOL ),
				$this->getOption( self::OPT_WEST_SYMBOL )
			);

			foreach( $ns as $delimiter ) {
				if( mb_strpos( $normalizedCoordinateString, $delimiter ) === 0 ) {
					// String starts with "north" or "west" symbol: Separation needs to be done
					// before the "east" or "west" symbol.
					$delimiters = array_merge( $ew, $delimiters );
					break;
				}
			}

			if( count( $delimiters ) !== count( $this->defaultDelimiters ) + 2 ) {
				$delimiters = array_merge( $ns, $delimiters );
			}

			foreach( $delimiters as $delimiter ) {
				$delimiterPos = mb_strpos( $normalizedCoordinateString, $delimiter );
				if( $delimiterPos !== false ) {
					$adjustPos = ( in_array( $delimiter, $ew ) ) ? 0 : mb_strlen( $delimiter );
					$normalizedCoordinateSegments = array(
						mb_substr( $normalizedCoordinateString, 0, $delimiterPos + $adjustPos ),
						mb_substr( $normalizedCoordinateString, $delimiterPos + $adjustPos )
					);
					break;
				}
			}
		}

		return $normalizedCoordinateSegments;
	}

}
