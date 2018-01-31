<?php

namespace ParamProcessor\Tests;

use ParamProcessor\MediaWikiTitleValue;
use ParamProcessor\TitleParser;

/**
 * @group Validator
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TitleParserTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider validInputProvider
	 */
	public function testValidInputs( $input, $expected ) {
		$parser = new TitleParser();

		$this->assertEquals(
			$expected,
			$parser->parse( $input )
		);
	}

	public function validInputProvider() {
		$argLists = [];

		$valid = [
			'Foo bar',
			'Ohi there!',
		];

		foreach ( $valid as $value ) {
			$argLists[] = [ $value, new MediaWikiTitleValue( \Title::newFromText( $value ) ) ];
		}

		return $argLists;
	}

}