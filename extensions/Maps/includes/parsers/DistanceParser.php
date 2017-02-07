<?php

namespace Maps;

use ValueParsers\ParseException;
use ValueParsers\StringValueParser;

/**
 * ValueParser that parses the string representation of a distance.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DistanceParser extends StringValueParser {

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 3.0
	 *
	 * @param string $value
	 *
	 * @return float
	 * @throws ParseException
	 */
	public function stringParse( $value ) {
		$distance = \MapsDistanceParser::parseDistance( $value );

		if ( $distance === false ) {
			throw new ParseException( 'Not a distance' );
		}

		return $distance;
	}

}
