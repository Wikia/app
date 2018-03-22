<?php

namespace ValueParsers;

use DataValues\UnknownValue;

/**
 * Implementation of the ValueParser interface that does a null parse.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NullParser implements ValueParser {

	/**
	 * @see ValueParser::parse
	 *
	 * @param mixed $value
	 *
	 * @return UnknownValue
	 */
	public function parse( $value ) {
		return new UnknownValue( $value );
	}

}
