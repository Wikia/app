<?php

namespace ValueFormatters;

/**
 * Interface for value formatters.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface ValueFormatter {

	/**
	 * Identifier for the option that holds the code of the language in which the parser should operate.
	 * @since 0.1
	 */
	const OPT_LANG = 'lang';

	/**
	 * Formats a value.
	 *
	 * @since 0.1
	 *
	 * @param mixed $value The value to format
	 *
	 * @return mixed
	 * @throws FormattingException
	 */
	public function format( $value );

}
