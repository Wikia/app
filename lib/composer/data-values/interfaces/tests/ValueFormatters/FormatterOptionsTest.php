<?php

namespace ValueFormatters\Test;

use ValueFormatters\FormatterOptions;

/**
 * @covers ValueFormatters\FormatterOptions
 *
 * @group ValueFormatters
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FormatterOptionsTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$options = array(
			'foo' => 42,
			'bar' => 4.2,
			'baz' => array( 'o_O', false, null, '42' => 42, array() )
		);

		$formatterOptions = new FormatterOptions( $options );

		foreach ( $options as $option => $value ) {
			$this->assertSame(
				serialize( $value ),
				serialize( $formatterOptions->getOption( $option ) ),
				'Option should be set properly'
			);
		}

		$this->assertFalse( $formatterOptions->hasOption( 'ohi' ) );
	}

	public function testConstructorFail() {
		$options = array(
			'foo' => 42,
			'bar' => 4.2,
			42 => array( 'o_O', false, null, '42' => 42, array() )
		);

		$this->setExpectedException( 'Exception' );

		new FormatterOptions( $options );
	}

	public function setOptionProvider() {
		$argLists = array();

		$formatterOptions = new FormatterOptions();

		$argLists[] = array( $formatterOptions, 'foo', 42 );
		$argLists[] = array( $formatterOptions, 'bar', 42 );
		$argLists[] = array( $formatterOptions, 'foo', 'foo' );
		$argLists[] = array( $formatterOptions, 'foo', null );

		return $argLists;
	}

	/**
	 * @dataProvider setOptionProvider
	 */
	public function testSetAndGetOption( FormatterOptions $options, $option, $value ) {
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

		$formatterOptions = new FormatterOptions( $options );

		foreach ( array_keys( $options ) as $option ) {
			$this->assertTrue( $formatterOptions->hasOption( $option ) );
		}

		$this->assertFalse( $formatterOptions->hasOption( 'ohi' ) );
		$this->assertFalse( $formatterOptions->hasOption( 'Foo' ) );
	}

	public function testSetOption() {
		$formatterOptions = new FormatterOptions( array( 'foo' => 'bar' ) );

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
			$formatterOptions->setOption( $value[0], $value[1] );
			$this->assertSame( $value[1], $formatterOptions->getOption( $value[0] ) );
		}
	}

	/**
	 * @dataProvider nonExistingOptionsProvider
	 */
	public function testGetOption( $nonExistingOption ) {
		$this->assertTrue( true );
		$formatterOptions = new FormatterOptions( array( 'foo' => 'bar' ) );

		$this->setExpectedException( 'OutOfBoundsException' );

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

		$formatterOptions = new FormatterOptions( $options );

		foreach ( array_keys( $options ) as $option ) {
			$formatterOptions->requireOption( $option );
		}

		$this->setExpectedException( 'Exception' );

		$formatterOptions->requireOption( 'Foo' );
	}

	public function testDefaultOption() {
		$options = array(
			'foo' => 42,
			'bar' => 4.2,
			'baz' => array( 'o_O', false, null, '42' => 42, array() )
		);

		$formatterOptions = new FormatterOptions( $options );

		foreach ( $options as $option => $value ) {
			$formatterOptions->defaultOption( $option, 9001 );

			$this->assertSame(
				serialize( $value ),
				serialize( $formatterOptions->getOption( $option ) ),
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
			$formatterOptions->defaultOption( $option, $value );

			$this->assertSame(
				serialize( $value ),
				serialize( $formatterOptions->getOption( $option ) ),
				'Defaulting a not set option should affect its value'
			);
		}
	}

}
