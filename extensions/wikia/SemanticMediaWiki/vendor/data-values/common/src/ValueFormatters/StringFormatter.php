<?php

namespace ValueFormatters;

use DataValues\StringValue;
use InvalidArgumentException;

/**
 * Formatter for string values
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class StringFormatter extends ValueFormatterBase {

	/**
	 * Formats a StringValue data value
	 *
	 * @param mixed $dataValue value to format
	 *
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public function format( $dataValue ) {
		if ( !( $dataValue instanceof StringValue ) ) {
			throw new InvalidArgumentException( 'DataValue is not a StringValue.' );
		}

		return $dataValue->getValue();
	}

}
