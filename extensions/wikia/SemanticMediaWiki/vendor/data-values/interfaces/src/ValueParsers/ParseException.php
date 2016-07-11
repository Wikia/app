<?php

namespace ValueParsers;

/**
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ParseException extends \RuntimeException {

	/**
	 * @var string|null
	 */
	private $expectedFormat;

	/**
	 * @var string|null
	 */
	private $rawValue;

	/**
	 * @param string $message        A plain english message describing the error
	 * @param string $rawValue       The raw value that failed to be parsed
	 * @param string $expectedFormat An identifier for the format the raw value
	 *                               did not match
	 *
	 * @since 0.1.4
	 */
	public function __construct( $message, $rawValue = null, $expectedFormat = null ) {
		parent::__construct( $message );
		$this->expectedFormat = $expectedFormat;
		$this->rawValue = $rawValue;
	}

	/**
	 * An identifier for the format the raw value did not match.
	 *
	 * This does not necessarily specify the exact format the throwing parser accepts.
	 * For example, a PositiveFloatParser might throw a ParseException with the
	 * expected format 'float' if the value does not even parse as a float, while
	 * in fact the parser would only accept positive floats. However, if the user
	 * enters a negative float, the parser must throw with a more specific format,
	 * i. e. 'positive-float'.
	 *
	 * @since 0.1.4
	 */
	public function getExpectedFormat() {
		return $this->expectedFormat;
	}

	/**
	 * The raw value which was not parsable.
	 *
	 * This is not necessarily the value an user entered, but the rawest value
	 * that's available at the throwing site.
	 *
	 * @since 0.1.4
	 */
	public function getRawValue() {
		return $this->rawValue;
	}
}
