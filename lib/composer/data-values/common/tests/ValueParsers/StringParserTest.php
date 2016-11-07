<?php

namespace ValueParsers\Test;

use DataValues\DataValue;
use DataValues\StringValue;
use ValueParsers\Normalizers\StringNormalizer;
use ValueParsers\StringParser;

/**
 * @covers ValueParsers\StringParser
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class StringParserTest extends \PHPUnit_Framework_TestCase {

	public function provideParse() {
		$normalizer = $this->getMock( 'ValueParsers\Normalizers\StringNormalizer' );
		$normalizer->expects( $this->once() )
			->method( 'normalize' )
			->will( $this->returnCallback( function( $value ) {
				return strtolower( trim( $value ) );
			} ) );

		return array(
			'simple' => array( 'hello world', null, new StringValue( 'hello world' ) ),
			'normalize' => array( '  Hello World  ', $normalizer, new StringValue( 'hello world' ) ),
		);
	}

	/**
	 * @dataProvider provideParse
	 */
	public function testParse( $input, StringNormalizer $normalizer = null, DataValue $expected ) {
		$parser = new StringParser( $normalizer );
		$value = $parser->parse( $input );

		$this->assertInstanceOf( 'DataValues\StringValue', $value );
		$this->assertEquals( $expected->toArray(), $value->toArray() );
	}

	public function nonStringProvider() {
		return array(
			'null' => array( null ),
			'array' => array( array() ),
			'int' => array( 7 ),
		);
	}

	/**
	 * @dataProvider nonStringProvider
	 */
	public function testGivenNonString_parseThrowsException( $input ) {
		$parser = new StringParser();
		$this->setExpectedException( 'InvalidArgumentException' );
		$parser->parse( $input );
	}

}
