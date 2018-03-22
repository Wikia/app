<?php

namespace ValueFormatters;

/**
 * Interface for value formatters, typically (but not limited to) expecting a DataValue object and
 * returning a string.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface ValueFormatter {

	/**
	 * Identifier for the option that holds the code of the language in which the formatter should
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
	 * @throws FormattingException
	 */
	public function format( $value );

}
