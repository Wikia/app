<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\MissingAttributeException;

/**
 * @covers Deserializers\Exceptions\MissingAttributeException
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MissingAttributeExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		$attributeName = 'theGame';

		$exception = new MissingAttributeException( $attributeName );

		$this->assertRequiredFieldsAreSet( $exception, $attributeName );
	}

	public function testConstructorWithAllArguments() {
		$attributeName = 'theGame';
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new MissingAttributeException( $attributeName, $message, $previous );

		$this->assertRequiredFieldsAreSet( $exception, $attributeName );
		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

	protected function assertRequiredFieldsAreSet( MissingAttributeException $exception, $attributeName ) {
		$this->assertEquals( $attributeName, $exception->getAttributeName() );
	}

}
