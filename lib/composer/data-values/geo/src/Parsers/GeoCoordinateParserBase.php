<?php

namespace DataValues\Geo\Parsers;

use DataValues\Geo\Values\LatLongValue;
use ValueParsers\ParseException;
use ValueParsers\ParserOptions;
use ValueParsers\StringValueParser;

/**
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author H. Snater < mediawiki@snater.com >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class GeoCoordinateParserBase extends StringValueParser {

	const FORMAT_NAME = 'geo-coordinate';

	/**
	 * The symbols representing the different directions for usage in directional notation.
	 * @since 0.1
	 */
	const OPT_NORTH_SYMBOL = 'north';
	const OPT_EAST_SYMBOL = 'east';
	const OPT_SOUTH_SYMBOL = 'south';
	const OPT_WEST_SYMBOL = 'west';

	/**
	 * The symbol to use as separator between latitude and longitude.
	 * @since 0.1
	 */
	const OPT_SEPARATOR_SYMBOL = 'separator';

	/**
	 * Delimiters used to split a coordinate string when unable to split by using the separator.
	 * @var string[]
	 */
	protected $defaultDelimiters;

	/**
	 * @since 0.1
	 *
	 * @param ParserOptions|null $options
	 */
	public function __construct( ParserOptions $options = null ) {
		parent::__construct( $options );

		$this->defaultOption( self::OPT_NORTH_SYMBOL, 'N' );
		$this->defaultOption( self::OPT_EAST_SYMBOL, 'E' );
		$this->defaultOption( self::OPT_SOUTH_SYMBOL, 'S' );
		$this->defaultOption( self::OPT_WEST_SYMBOL, 'W' );

		$this->defaultOption( self::OPT_SEPARATOR_SYMBOL, ',' );
	}

	/**
	 * Parses a single coordinate segment (either latitude or longitude) and returns it as a float.
	 *
	 * @since 0.1
	 *
	 * @param string $coordinateSegment
	 *
	 * @throws ParseException
	 * @return float
	 */
	abstract protected function getParsedCoordinate( $coordinateSegment );

	/**
	 * Returns whether a coordinate split into its two segments is in the representation expected by
	 * this parser.
	 *
	 * @since 0.1
	 *
	 * @param string[] $normalizedCoordinateSegments
	 *
	 * @return boolean
	 */
	abstract protected function areValidCoordinates( array $normalizedCoordinateSegments );

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 0.1
	 *
	 * @param string $value
	 *
	 * @throws ParseException
	 * @return LatLongValue
	 */
	protected function stringParse( $value ) {
		$rawValue = $value;

		$value = $this->removeInvalidChars( $value );

		$normalizedCoordinateSegments = $this->splitString( $value );

		if( !$this->areValidCoordinates( $normalizedCoordinateSegments ) ) {
			throw new ParseException( 'Not a valid geographical coordinate', $rawValue, static::FORMAT_NAME );
		}

		list( $latitude, $longitude ) = $normalizedCoordinateSegments;

		return new LatLongValue(
			$this->getParsedCoordinate( $latitude ),
			$this->getParsedCoordinate( $longitude )
		);
	}

	/**
	 * Returns a string trimmed and with control characters and characters with ASCII values above
	 * 126 removed. SPACE characters within the string are not removed to retain the option to split
	 * the string using that character.
	 *
	 * @since 0.1
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	protected function removeInvalidChars( $string ) {
		$filtered = array();

		foreach ( str_split( $string ) as $character ) {
			$asciiValue = ord( $character );

			if (
				( $asciiValue >= 32 && $asciiValue < 127 )
				|| $asciiValue == 194
				|| $asciiValue == 176
			) {
				$filtered[] = $character;
			}
		}

		return trim( implode( '', $filtered ) );
	}

	/**
	 * Splits a string into two strings using the separator specified in the options. If the string
	 * could not be split using the separator, the method will try to split the string by analyzing
	 * the used symbols. If the string could not be split into two parts, an empty array is
	 * returned.
	 *
	 * @since 0.1
	 *
	 * @param string $normalizedCoordinateString
	 *
	 * @throws ParseException if unable to split input string into two segments
	 * @return string[]
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

		if( count( $normalizedCoordinateSegments ) !== 2 ) {
			throw new ParseException( __CLASS__ . ': Unable to split string '
				. $normalizedCoordinateString . ' into two coordinate segments' );
		}

		return $normalizedCoordinateSegments;
	}

	/**
	 * Turns directional notation (N/E/S/W) of a single coordinate into non-directional notation
	 * (+/-).
	 * This method assumes there are no preceding or tailing spaces.
	 *
	 * @since 0.1
	 *
	 * @param string $coordinateSegment
	 *
	 * @return string
	 */
	protected function resolveDirection( $coordinateSegment ) {
		$n = $this->getOption( self::OPT_NORTH_SYMBOL );
		$e = $this->getOption( self::OPT_EAST_SYMBOL );
		$s = $this->getOption( self::OPT_SOUTH_SYMBOL );
		$w = $this->getOption( self::OPT_WEST_SYMBOL );

		// If there is a direction indicator, remove it, and prepend a minus sign for south and west
		// directions. If there is no direction indicator, the coordinate is already non-directional
		// and no work is required.
		foreach( array( $n, $e, $s, $w ) as $direction ) {
			// The coordinate segment may either start or end with a direction symbol.
			preg_match(
				'/^(' . $direction . '|)([^' . $direction . ']+)(' . $direction . '|)$/i',
				$coordinateSegment,
				$matches
			);

			if( $matches[1] === $direction || $matches[3] === $direction ) {
				$coordinateSegment = $matches[2];

				if ( in_array( $direction, array( $s, $w ) ) ) {
					$coordinateSegment = '-' . $coordinateSegment;
				}

				return $coordinateSegment;
			}
		}

		// Coordinate segment does not include a direction symbol.
		return $coordinateSegment;
	}

}
