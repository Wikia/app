<?php

namespace DataValues\Geo\Parsers;

use ValueParsers\ParseException;

/**
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author H. Snater < mediawiki@snater.com >
 */
class FloatCoordinateParser extends GeoCoordinateParserBase {

	const FORMAT_NAME = 'float-coordinate';

	/**
	 * @see GeoCoordinateParserBase::getParsedCoordinate
	 */
	protected function getParsedCoordinate( $coordinateSegment ) {
		return (float)$this->resolveDirection( str_replace( ' ', '', $coordinateSegment ) );
	}

	/**
	 * @see GeoCoordinateParserBase::areValidCoordinates
	 */
	protected function areValidCoordinates( array $normalizedCoordinateSegments ) {
		// TODO: Implement localized decimal separator.
		$baseRegExp = '\d{1,3}(\.\d{1,20})?';

		// Cache whether the coordinates are specified in directional format (a mixture of
		// directional and non-directional is regarded invalid).
		$directional = false;

		$match = false;

		foreach( $normalizedCoordinateSegments as $i => $segment ) {
			$segment = str_replace( ' ', '', $segment );

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

			if( $directional && !$match ) {
				// Latitude is directional, longitude not.
				break;
			} elseif( $match ) {
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
	 * @see GeoCoordinateParserBase::splitString
	 */
	protected function splitString( $normalizedCoordinateString ) {
		$separator = $this->getOption( self::OPT_SEPARATOR_SYMBOL );

		$normalizedCoordinateSegments = explode( $separator, $normalizedCoordinateString );

		if( count( $normalizedCoordinateSegments ) !== 2 ) {
			// Separator not present within the string, trying to figure out the segments by
			// splitting at the the first SPACE after the first direction character or digit:
			$numberRegEx = '-?\d{1,3}(\.\d{1,20})?';

			$ns = '('
				. $this->getOption( self::OPT_NORTH_SYMBOL ) . '|'
				. $this->getOption( self::OPT_SOUTH_SYMBOL ) .')';

			$latitudeRegEx = '(' . $ns . '\s*)?' . $numberRegEx . '(\s*' . $ns . ')?';

			$ew = '('
				. $this->getOption( self::OPT_EAST_SYMBOL ) . '|'
				. $this->getOption( self::OPT_WEST_SYMBOL ) .')';

			$longitudeRegEx = '(' . $ew . '\s*)?' . $numberRegEx . '(\s*' . $ew . ')?';

			$match = preg_match(
				'/^(' . $latitudeRegEx . ') (' . $longitudeRegEx . ')$/i',
				$normalizedCoordinateString,
				$matches
			);

			if( $match ) {
				$normalizedCoordinateSegments = array( $matches[1], $matches[7] );
			}
		}

		if( count( $normalizedCoordinateSegments ) !== 2 ) {
			throw new ParseException(
				'Unable to split input into two coordinate segments',
				$normalizedCoordinateString,
				self::FORMAT_NAME
			);
		}

		return $normalizedCoordinateSegments;
	}

}
