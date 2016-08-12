<?php

namespace DataValues\Geo\Parsers;

use DataValues\Geo\Values\LatLongValue;
use ValueParsers\ParseException;
use ValueParsers\StringValueParser;

/**
 * ValueParser that parses the string representation of a geographical coordinate.
 *
 * The resulting objects are of type @see LatLongValue.
 *
 * Supports the following notations:
 * - Degree minute second
 * - Decimal degrees
 * - Decimal minutes
 * - Float
 *
 * And for all these notations direction can be indicated either with
 * + and - or with N/E/S/W, the later depending on the set options.
 *
 * The delimiter between latitude and longitude can be set in the options.
 * So can the symbols used for degrees, minutes and seconds.
 *
 * Some code in this class has been borrowed from the
 * MapsCoordinateParser class of the Maps extension for MediaWiki.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GeoCoordinateParser extends StringValueParser {

	const TYPE_FLOAT = 'float';
	const TYPE_DMS = 'dms';
	const TYPE_DM = 'dm';
	const TYPE_DD = 'dd';

	/**
	 * The symbols representing the different directions for usage in directional notation.
	 * @since 0.1
	 */
	const OPT_NORTH_SYMBOL = 'north';
	const OPT_EAST_SYMBOL = 'east';
	const OPT_SOUTH_SYMBOL = 'south';
	const OPT_WEST_SYMBOL = 'west';

	/**
	 * The symbols representing degrees, minutes and seconds.
	 * @since 0.1
	 */
	const OPT_DEGREE_SYMBOL = 'degree';
	const OPT_MINUTE_SYMBOL = 'minute';
	const OPT_SECOND_SYMBOL = 'second';

	/**
	 * The symbol to use as separator between latitude and longitude.
	 * @since 0.1
	 */
	const OPT_SEPARATOR_SYMBOL = 'separator';

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 0.1
	 *
	 * @param string $value
	 *
	 * @return LatLongValue
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		foreach ( $this->getParsers() as $parser ) {
			try {
				return $parser->parse( $value );
			}
			catch ( ParseException $parseException ) {
				continue;
			}
		}

		throw new ParseException( 'The format of the coordinate could not be determined. Parsing failed.' );
	}

	/**
	 * @return  StringValueParser[]
	 */
	protected function getParsers() {
		$parsers = array();

		$parsers[] = new FloatCoordinateParser( $this->options );
		$parsers[] = new DmsCoordinateParser( $this->options );
		$parsers[] = new DmCoordinateParser( $this->options );
		$parsers[] = new DdCoordinateParser( $this->options );

		return $parsers;
	}

	/**
	 * Convenience function for determining if something is a valid coordinate string.
	 * Analogous to creating an instance of the parser, parsing the string and checking isValid on the result.
	 *
	 * @since 0.1
	 *
	 * @param string $string
	 *
	 * @return boolean
	 */
	public static function areCoordinates( $string ) {
		static $parser = null;

		if ( $parser === null ) {
			$parser = new self();
		}

		return $parser->parse( $string )->isValid();
	}

}
