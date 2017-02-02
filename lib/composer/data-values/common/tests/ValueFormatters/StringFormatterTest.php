<?php

namespace ValueFormatters\Test;

use DataValues\StringValue;
use ValueFormatters\FormatterOptions;
use ValueFormatters\StringFormatter;

/**
 * @covers ValueFormatters\StringFormatter
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class StringFormatterTest extends ValueFormatterTestBase {

	/**
	 * @deprecated since 0.2, just use getInstance.
	 */
	protected function getFormatterClass() {
		throw new \LogicException( 'Should not be called, use getInstance' );
	}

	/**
	 * @see ValueFormatterTestBase::getInstance
	 *
	 * @param FormatterOptions|null $options
	 *
	 * @return StringFormatter
	 */
	protected function getInstance( FormatterOptions $options = null ) {
		return new StringFormatter( $options );
	}

	/**
	 * @see ValueFormatterTestBase::validProvider
	 */
	public function validProvider() {
		$strings = array(
			'ice cream',
			'cake',
			'',
			' a ',
			'  ',
		);

		$argLists = array();

		foreach ( $strings as $string ) {
			$argLists[] = array( new StringValue( $string ), $string );
		}

		return $argLists;
	}

}
