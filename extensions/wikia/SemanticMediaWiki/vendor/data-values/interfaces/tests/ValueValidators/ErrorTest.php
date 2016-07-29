<?php

namespace ValueValidators\Test;

use ValueValidators\Error;

/**
 * @covers ValueValidators\Error
 *
 * @group ValueValidators
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ErrorTest extends \PHPUnit_Framework_TestCase {

	public function newErrorProvider() {
		$argLists = array();

		$argLists[] = array();

		$argLists[] = array( '' );
		$argLists[] = array( 'foo' );
		$argLists[] = array( ' foo bar baz.' );

		$argLists[] = array( ' foo bar ', null );
		$argLists[] = array( ' foo bar ', 'length' );

		$argLists[] = array( ' foo bar ', null, 'something-went-wrong' );
		$argLists[] = array( ' foo bar ', null, 'something-went-wrong', array( 'foo', 'bar' ) );

		return $argLists;
	}

	/**
	 * @dataProvider newErrorProvider
	 */
	public function testNewError() {
		$args = func_get_args();

		$error = call_user_func_array( 'ValueValidators\Error::newError', $args );

		/**
		 * @var Error $error
		 */
		$this->assertInstanceOf( 'ValueValidators\Error', $error );

		$this->assertInternalType( 'string', $error->getText() );
		$this->assertInternalType( 'integer', $error->getSeverity() );
		$this->assertTrue( is_string( $error->getProperty() ) || is_null( $error->getProperty() ) );
		$this->assertInternalType( 'string', $error->getCode() );
		$this->assertInternalType( 'array', $error->getParameters() );

		if ( count( $args ) > 0 ) {
			$this->assertEquals( $args[0], $error->getText() );
		}

		if ( count( $args ) > 1 ) {
			$this->assertEquals( $args[1], $error->getProperty() );
		}

		if ( count( $args ) > 2 ) {
			$this->assertEquals( $args[2], $error->getCode() );
		}

		if ( count( $args ) > 3 ) {
			$this->assertEquals( $args[3], $error->getParameters() );
		}
	}

}
