<?php

namespace ValueFormatters\Test;

use ValueFormatters\FormatterOptions;
use ValueFormatters\ValueFormatter;

/**
 * Base for unit tests for ValueFormatter implementing classes.
 *
 * @since 0.1
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ValueFormatterTestBase extends \PHPUnit_Framework_TestCase {

	/**
	 * Returns a list with valid inputs and their associated formatting output.
	 *
	 * @since 0.1
	 *
	 * @return array[]
	 */
	public abstract function validProvider();

	/**
	 * Returns the name of the ValueFormatter implementing class.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected abstract function getFormatterClass();

	/**
	 * @since 0.1
	 *
	 * @param FormatterOptions $options
	 *
	 * @return ValueFormatter
	 */
	protected function getInstance( FormatterOptions $options ) {
		$class = $this->getFormatterClass();
		return new $class( $options );
	}

	/**
	 * @dataProvider validProvider
	 *
	 * @since 0.1
	 *
	 * @param mixed $value
	 * @param mixed $expected
	 * @param FormatterOptions|null $options
	 * @param ValueFormatter|null $formatter
	 */
	public function testValidFormat( $value, $expected, FormatterOptions $options = null, ValueFormatter $formatter = null ) {
		if ( $options === null ) {
			$options = new FormatterOptions();
		}

		if ( is_null( $formatter ) ) {
			$formatter = $this->getInstance( $options );
		}

		$this->assertEquals( $expected, $formatter->format( $value ) );
	}

}
