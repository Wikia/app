<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\UnsupportedTypeException;

/**
 * @covers Deserializers\Exceptions\UnsupportedTypeException
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class UnsupportedTypeExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$unsupportedType = 'fooBarBaz';

		$exception = new UnsupportedTypeException( $unsupportedType );

		$this->assertRequiredFieldsAreSet( $exception, $unsupportedType );
	}

	public function testConstructorWithAllArguments() {
		$unsupportedType = 'fooBarBaz';
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new UnsupportedTypeException( $unsupportedType, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $unsupportedType );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( UnsupportedTypeException $exception, $unsupportedType ) {
		$this->assertEquals( $unsupportedType, $exception->getUnsupportedType() );
	}

}
