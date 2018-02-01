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
 * @license GPL-2.0+
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
	abstract public function validProvider();

	/**
	 * @since 0.1
	 *
	 * @param FormatterOptions|null $options
	 *
	 * @return ValueFormatter
	 */
	abstract protected function getInstance( FormatterOptions $options = null );

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
	public function testValidFormat(
		$value,
		$expected,
		FormatterOptions $options = null,
		ValueFormatter $formatter = null
	) {
		if ( $formatter === null ) {
			$formatter = $this->getInstance( $options );
		}

		$this->assertSame( $expected, $formatter->format( $value ) );
	}

}
