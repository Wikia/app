<?php

namespace Deserializers\Tests\Phpunit\Exceptions;

use Deserializers\Exceptions\MissingTypeException;

/**
 * @covers Deserializers\Exceptions\MissingTypeException
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MissingTypeExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		new MissingTypeException();
		$this->assertTrue( true );
	}

	public function testConstructorWithAllArguments() {
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new MissingTypeException( $message, $previous );

		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

}
