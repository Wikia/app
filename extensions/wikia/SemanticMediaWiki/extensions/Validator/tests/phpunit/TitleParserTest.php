<?php

namespace ParamProcessor\Tests;

use ParamProcessor\MediaWikiTitleValue;
use ValueParsers\Test\StringValueParserTest;

/**
 * @group Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TitleParserTest extends StringValueParserTest {

	/**
	 * @see ValueParserTestBase::validInputProvider
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function validInputProvider() {
		$argLists = array();

		$valid = array(
			'Foo bar',
			'Ohi there!',
		);

		foreach ( $valid as $value ) {
			$argLists[] = array( $value, new MediaWikiTitleValue( \Title::newFromText( $value ) ) );
		}

		return $argLists;
	}

	/**
	 * @see ValueParserTestBase::getParserClass
	 * @since 0.1
	 * @return string
	 */
	protected function getParserClass() {
		return 'ParamProcessor\TitleParser';
	}

}