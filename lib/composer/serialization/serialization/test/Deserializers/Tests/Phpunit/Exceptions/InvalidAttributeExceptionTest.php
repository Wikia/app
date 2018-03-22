<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\InvalidAttributeException;

/**
 * @covers Deserializers\Exceptions\InvalidAttributeException
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class InvalidAttributeExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$attributeName = 'theGame';
		$attributeValue = 'youJustLostIt';

		$exception = new InvalidAttributeException( $attributeName, $attributeValue );

		$this->assertRequiredFieldsAreSet( $exception, $attributeName, $attributeValue );
	}

	public function testConstructorWithAllArguments() {
		$attributeName = 'theGame';
		$attributeValue = 'youJustLostIt';
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new InvalidAttributeException( $attributeName, $attributeValue, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $attributeName, $attributeValue );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( InvalidAttributeException $exception, $attributeName, $attributeValue ) {
		$this->assertEquals( $attributeName, $exception->getAttributeName() );
		$this->assertEquals( $attributeValue, $exception->getAttributeValue() );
	}

}
