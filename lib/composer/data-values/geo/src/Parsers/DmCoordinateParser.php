<?php

namespace DataValues\Geo\Parsers;

use ValueParsers\ParseException;
use ValueParsers\ParserOptions;

/**
 * Parser for geographical coordinates in Decimal Minute notation.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author H. Snater < mediawiki@snater.com >
 */
class DmCoordinateParser extends DdCoordinateParser {

	const FORMAT_NAME = 'dm-coordinate';

	/**
	 * The symbols representing minutes.
	 * @since 0.1
	 */
	const OPT_MINUTE_SYMBOL = 'minute';

	/**
	 * @param ParserOptions|null $options
	 */
	public function __construct( ParserOptions $options = null ) {
		parent::__construct( $options );

		$this->defaultOption( self::OPT_MINUTE_SYMBOL, "'" );

		$this->defaultDelimiters = array( $this->getOption( self::OPT_MINUTE_SYMBOL ) );
	}

	/**
	 * @see GeoCoordinateParserBase::areValidCoordinates
	 */
	protected function areValidCoordinates( array $normalizedCoordinateSegments ) {
		// At least one coordinate segment needs to have minutes specified.
		$regExpStrict = '\d{1,3}'
			. preg_quote( $this->getOption( self::OPT_DEGREE_SYMBOL ) )
			// TODO: Implement localized decimal separator.
			. '(\d{1,2}(\.\d{1,20})?'
			. preg_quote( $this->getOption( self::OPT_MINUTE_SYMBOL ) )
			. ')';
		$regExpLoose = $regExpStrict . '?';

		// Cache whether minutes have been detected within the coordinate:
		$detectedMinute = false;

		// Cache whether the coordinates are specified in directional format (a mixture of
		// directional and non-directional is regarded invalid).
		$directional = false;

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
				'/^(' . $regExpStrict . $direction . '|' . $direction . $regExpStrict . ')$/i',
				$segment
			);

			if( $match ) {
				$detectedMinute = true;
			} else {
				$match = preg_match(
					'/^(' . $regExpLoose . $direction . '|' . $direction . $regExpLoose . ')$/i',
					$segment
				);
			}

			if( $match ) {
				$directional = true;
			} elseif ( !$directional ) {
				$match = preg_match( '/^(-)?' . $regExpStrict . '$/i', $segment );

				if( $match ) {
					$detectedMinute = true;
				} else  {
					$match = preg_match( '/^(-)?' . $regExpLoose . '$/i', $segment );
				}
			}

			if( !$match ) {
				return false;
			}
		}

		return $detectedMinute;
	}

	/**
	 * @see DdCoordinateParser::getNormalizedNotation
	 */
	protected function getNormalizedNotation( $coordinates ) {
		$minute = $this->getOption( self::OPT_MINUTE_SYMBOL );

		$coordinates = str_replace( array( '&#8242;', '&prime;', '´', '′' ), $minute, $coordinates );

		$coordinates = parent::getNormalizedNotation( $coordinates );

		$coordinates = $this->removeInvalidChars( $coordinates );

		return $coordinates;
	}

	/**
	 * @see DdCoordinateParser::parseCoordinate
	 */
	protected function parseCoordinate( $coordinateSegment ) {
		$isNegative = substr( $coordinateSegment, 0, 1 ) === '-';

		if ( $isNegative ) {
			$coordinateSegment = substr( $coordinateSegment, 1 );
		}

		$degreeSymbol = $this->getOption( self::OPT_DEGREE_SYMBOL );
		$exploded = explode( $degreeSymbol, $coordinateSegment );

		if( count( $exploded ) !== 2 ) {
			throw new ParseException(
				'Unable to explode coordinate segment by degree symbol (' . $degreeSymbol . ')',
				$coordinateSegment,
				self::FORMAT_NAME
			);
		}

		list( $degrees, $minutes ) = $exploded;

		$minutes = substr( $minutes, 0, -1 );

		$coordinateSegment = $degrees + $minutes / 60;

		if ( $isNegative ) {
			$coordinateSegment *= -1;
		}

		return (float)$coordinateSegment;
	}

}
