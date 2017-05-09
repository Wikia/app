<?php

namespace ValueParsers\Test;

use InvalidArgumentException;
use PHPUnit_Framework_MockObject_Matcher_Invocation;
use PHPUnit_Framework_TestCase;
use ValueParsers\DispatchingValueParser;
use ValueParsers\ParseException;
use ValueParsers\ValueParser;

/**
 * @covers ValueParsers\DispatchingValueParser
 *
 * @group ValueParsers
 * @group WikibaseLib
 * @group Wikibase
 *
 * @licence GNU GPL v2+
 * @author Thiemo Mättig
 */
class DispatchingValueParserTest extends PHPUnit_Framework_TestCase {

	/**
	 * @param PHPUnit_Framework_MockObject_Matcher_Invocation $invocation
	 *
	 * @return ValueParser
	 */
	private function getParser( PHPUnit_Framework_MockObject_Matcher_Invocation $invocation ) {
		$mock = $this->getMockBuilder( 'ValueParsers\ValueParser' )
			->disableOriginalConstructor()
			->getMock();

		$mock->expects( $invocation )
			->method( 'parse' )
			->will( $this->returnCallback( function( $value ) {
				if ( $value === 'invalid' ) {
					throw new ParseException( 'failed' );
				}
				return $value;
			} ) );

		return $mock;
	}

	/**
	 * @dataProvider invalidConstructorArgumentsProvider
	 * @expectedException InvalidArgumentException
	 */
	public function testGivenInvalidConstructorArguments_constructorThrowsException( $parsers, $format ) {
		new DispatchingValueParser( $parsers, $format );
	}

	public function invalidConstructorArgumentsProvider() {
		$parsers = array(
			$this->getParser( $this->never() ),
		);

		return array(
			array( array(), 'format' ),
			array( $parsers, null ),
			array( $parsers, '' ),
		);
	}

	public function testParse() {
		$parser = new DispatchingValueParser(
			array(
				$this->getParser( $this->once() ),
				$this->getParser( $this->never() ),
			),
			'format'
		);

		$this->assertEquals( 'valid', $parser->parse( 'valid' ) );
	}

	public function testParseThrowsException() {
		$parser = new DispatchingValueParser(
			array(
				$this->getParser( $this->once() ),
			),
			'format'
		);

		$this->setExpectedException( 'ValueParsers\ParseException' );
		$parser->parse( 'invalid' );
	}

}
