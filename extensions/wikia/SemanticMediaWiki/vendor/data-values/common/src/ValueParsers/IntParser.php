<?php

namespace ValueParsers;

use DataValues\NumberValue;

/**
 * ValueParser that parses the string representation of an integer.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class IntParser extends StringValueParser {

	const FORMAT_NAME = 'int';

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @param string $value
	 *
	 * @return NumberValue
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		$positiveValue = strpos( $value, '-' ) === 0 ? substr( $value, 1 ) : $value;

		if ( ctype_digit( $positiveValue ) ) {
			return new NumberValue( (int)$value );
		}

		throw new ParseException( 'Not an integer', $value, self::FORMAT_NAME );
	}

}
