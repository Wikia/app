<?php

namespace ValueParsers;

use DataValues\BooleanValue;

/**
 * ValueParser that parses the string representation of a boolean.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class BoolParser extends StringValueParser {

	const FORMAT_NAME = 'bool';

	protected $values = array(
		'yes' => true,
		'on' => true,
		'1' => true,
		'true' => true,
		'no' => false,
		'off' => false,
		'0' => false,
		'false' => false,
	);

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @param string $value
	 *
	 * @return BooleanValue
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		$rawValue = $value;

		$value = strtolower( $value );

		if ( array_key_exists( $value, $this->values ) ) {
			return new BooleanValue( $this->values[$value] );
		}

		throw new ParseException( 'Not a boolean', $rawValue, self::FORMAT_NAME );
	}

}
