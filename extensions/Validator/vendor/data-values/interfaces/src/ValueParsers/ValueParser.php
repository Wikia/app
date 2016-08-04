<?php

namespace ValueParsers;

/**
 * Interface for value parsers, typically (but not limited to) expecting a string and returning a
 * DataValue object.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface ValueParser {

	/**
	 * Identifier for the option that holds the code of the language in which the parser should
	 * operate.
	 * @since 0.1
	 */
	const OPT_LANG = 'lang';

	/**
	 * @since 0.1
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function parse( $value );

}
