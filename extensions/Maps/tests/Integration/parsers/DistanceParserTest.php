<?php

namespace Maps\Test;

use Maps\DistanceParser;
use ValueParsers\ParseException;

/**
 * @covers \Maps\DistanceParser
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DistanceParserTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		if ( !defined( 'MEDIAWIKI' ) ) {
			$this->markTestSkipped( 'MediaWiki is not available' );
		}
	}

	/**
	 * @dataProvider validInputProvider
	 */
	public function testValidInputs( $input, $expected ) {
		$this->assertSame(
			$expected,
			( new DistanceParser() )->parse( $input )
		);
	}

	public function validInputProvider() {
		return [
			[ '1', 1.0 ],
			[ '1m', 1.0 ],
			[ '42 km', 42000.0 ],
			[ '4.2 km', 4200.0 ],
			[ '4.2 m', 4.2 ],
			[ '4.02 m', 4.02 ],
			[ '4.02 km', 4020.0 ],
			[ '0.001 km', 1.0 ],
		];
	}

	/**
	 * @dataProvider invalidInputProvider
	 */
	public function testGivenInvalidInput_exceptionIsThrown( $input ) {
		$parser = new DistanceParser();

		$this->setExpectedException( ParseException::class );
		$parser->parse( $input );
	}

	public function invalidInputProvider() {
		return [
			[ '' ],
			[ 'kittens' ],
			[ '1 kittens' ],
			[ '-1m' ],
			[ 'foo m' ],
			[ '1m foo' ],
			[ 'foo 1m' ],
			[ 'm1' ],
			[ '4. m' ],
			[ '4.2.1 m' ],
		];
	}

}
