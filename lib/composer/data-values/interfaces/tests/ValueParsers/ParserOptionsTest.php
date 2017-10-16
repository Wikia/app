<?php

namespace ValueParsers\Test;

use ValueParsers\ParserOptions;

/**
 * @covers ValueParsers\ParserOptions
 *
 * @group ValueParsers
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ParserOptionsTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$options = array(
			'foo' => 42,
			'bar' => 4.2,
			'baz' => array( 'o_O', false, null, '42' => 42, array() )
		);

		$parserOptions = new ParserOptions( $options );

		foreach ( $options as $option => $value ) {
			$this->assertSame(
				serialize( $value ),
				serialize( $parserOptions->getOption( $option ) ),
				'Option should be set properly'
			);
		}

		$this->assertFalse( $parserOptions->hasOption( 'ohi' ) );
	}

	public function testConstructorFail() {
		$options = array(
			'foo' => 42,
			'bar' => 4.2,
			42 => array( 'o_O', false, null, '42' => 42, array() )
		);

		$this->setExpectedException( 'Exception' );

		new ParserOptions( $options );
	}

	public function setOptionProvider() {
		$argLists = array();

		$parserOptions = new ParserOptions();

		$argLists[] = array( $parserOptions, 'foo', 42 );
		$argLists[] = array( $parserOptions, 'bar', 42 );
		$argLists[] = array( $parserOptions, 'foo', 'foo' );
		$argLists[] = array( $parserOptions, 'foo', null );

		return $argLists;
	}

	/**
	 * @dataProvider setOptionProvider
	 */
	public function testSetAndGetOption( ParserOptions $options, $option, $value ) {
		$options->setOption( $option, $value );

		$this->assertEquals(
			$value,
			$options->getOption( $option ),
			'Setting an option should work'
		);
	}

	public function testHashOption() {
		$options = array(
			'foo' => 42,
			'bar' => 4.2,
			'baz' => array( 'o_O', false, null, '42' => 42, array() )
		);

		$parserOptions = new ParserOptions( $options );

		foreach ( array_keys( $options ) as $option ) {
			$this->assertTrue( $parserOptions->hasOption( $option ) );
		}

		$this->assertFalse( $parserOptions->hasOption( 'ohi' ) );
		$this->assertFalse( $parserOptions->hasOption( 'Foo' ) );
	}

	public function testSetOption() {
		$parserOptions = new ParserOptions( array( 'foo' => 'bar' ) );

		$values = array(
			array( 'foo', 'baz' ),
			array( 'foo', 'bar' ),
			array( 'onoez', '' ),
			array( 'hax', 'zor' ),
			array( 'nyan', 9001 ),
			array( 'cat', 4.2 ),
			array( 'spam', array( '~=[,,_,,]:3' ) ),
		);

		foreach ( $values as $value ) {
			$parserOptions->setOption( $value[0], $value[1] );
			$this->assertSame( $value[1], $parserOptions->getOption( $value[0] ) );
		}
	}

	/**
	 * @dataProvider nonExistingOptionsProvider
	 */
	public function testGetOption( $nonExistingOption ) {
		$this->assertTrue( true );
		$formatterOptions = new ParserOptions( array( 'foo' => 'bar' ) );

		$this->setExpectedException( 'InvalidArgumentException' );

		$formatterOptions->getOption( $nonExistingOption );
	}

	public function nonExistingOptionsProvider() {
		$argLists = array();

		$argLists[] = array( 'bar' );
		$argLists[] = array( 'Foo' );
		$argLists[] = array( 'FOO' );
		$argLists[] = array( 'spam' );
		$argLists[] = array( 'onoez' );

		return $argLists;
	}

	public function testRequireOption() {
		$options = array(
			'foo' => 42,
			'bar' => 4.2,
			'baz' => array( 'o_O', false, null, '42' => 42, array() )
		);

		$parserOptions = new ParserOptions( $options );

		foreach ( array_keys( $options ) as $option ) {
			$parserOptions->requireOption( $option );
		}

		$this->setExpectedException( 'Exception' );

		$parserOptions->requireOption( 'Foo' );
	}

	public function testDefaultOption() {
		$options = array(
			'foo' => 42,
			'bar' => 4.2,
			'baz' => array( 'o_O', false, null, '42' => 42, array() )
		);

		$parserOptions = new ParserOptions( $options );

		foreach ( $options as $option => $value ) {
			$parserOptions->defaultOption( $option, 9001 );

			$this->assertSame(
				serialize( $value ),
				serialize( $parserOptions->getOption( $option ) ),
				'Defaulting a set option should not affect its value'
			);
		}

		$defaults = array(
			'N' => 42,
			'y' => 4.2,
			'a' => false,
			'n' => array( '42' => 42, array( '' ) )
		);

		foreach ( $defaults as $option => $value ) {
			$parserOptions->defaultOption( $option, $value );

			$this->assertSame(
				serialize( $value ),
				serialize( $parserOptions->getOption( $option ) ),
				'Defaulting a not set option should affect its value'
			);
		}
	}

}
