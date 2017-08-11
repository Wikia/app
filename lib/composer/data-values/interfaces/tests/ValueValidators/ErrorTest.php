<?php

namespace ValueValidators\Test;

use ValueValidators\Error;

/**
 * @covers ValueValidators\Error
 *
 * @group ValueValidators
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ErrorTest extends \PHPUnit_Framework_TestCase {

	public function newErrorProvider() {
		$argLists = [];

		$argLists[] = [];

		$argLists[] = [ '' ];
		$argLists[] = [ 'foo' ];
		$argLists[] = [ ' foo bar baz.' ];

		$argLists[] = [ ' foo bar ', null ];
		$argLists[] = [ ' foo bar ', 'length' ];

		$argLists[] = [ ' foo bar ', null, 'something-went-wrong' ];
		$argLists[] = [ ' foo bar ', null, 'something-went-wrong', [ 'foo', 'bar' ] ];

		return $argLists;
	}

	/**
	 * @dataProvider newErrorProvider
	 */
	public function testNewError() {
		$args = func_get_args();

		$error = call_user_func_array( [ Error::class, 'newError' ], $args );

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
			$this->assertSame( $args[0], $error->getText() );
		}

		if ( count( $args ) > 1 ) {
			$this->assertSame( $args[1], $error->getProperty() );
		}

		if ( count( $args ) > 2 ) {
			$this->assertSame( $args[2], $error->getCode() );
		}

		if ( count( $args ) > 3 ) {
			$this->assertSame( $args[3], $error->getParameters() );
		}
	}

}
