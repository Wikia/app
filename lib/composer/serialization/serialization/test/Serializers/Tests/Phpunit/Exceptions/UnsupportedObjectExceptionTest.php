<?php

namespace Serializers\Tests\Phpunit\Exceptions;

use Serializers\Exceptions\UnsupportedObjectException;

/**
 * @covers Serializers\Exceptions\UnsupportedObjectException
 *
 * @group Serialization
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class UnsupportedObjectExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$object = array( 'the' => 'game' );

		$exception = new UnsupportedObjectException( $object );

		$this->assertRequiredFieldsAreSet( $exception, $object );
	}

	public function testConstructorWithAllArguments() {
		$object = array( 'the' => 'game' );
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new UnsupportedObjectException( $object, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $object );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( UnsupportedObjectException $exception, $object ) {
		$this->assertEquals( $object, $exception->getUnsupportedObject() );
	}

}
