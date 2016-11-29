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
	 * @see ValueFormatter::format
	 *
	 * @param StringValue $dataValue
	 *
	 * @throws InvalidArgumentException
	 * @return string Text
	 */
	public function format( $dataValue ) {
		if ( !( $dataValue instanceof StringValue ) ) {
			throw new InvalidArgumentException( 'Data value type mismatch. Expected a StringValue.' );
		}

		return $dataValue->getValue();
	}

}
