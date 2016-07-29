<?php

namespace ValueValidators\Test;

use ValueValidators\Error;
use ValueValidators\Result;

/**
 * @covers ValueValidators\Result
 *
 * @group ValueValidators
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class ResultTest extends \PHPUnit_Framework_TestCase {

	public function testNewSuccess() {
		$result = Result::newSuccess();

		$this->assertTrue( $result->isValid() );
		$this->assertEmpty( $result->getErrors() );
	}

	public function testNewError() {
		$result = Result::newError( array(
			Error::newError( 'foo' ),
			Error::newError( 'bar' ),
		) );

		$this->assertFalse( $result->isValid() );
		$this->assertCount( 2, $result->getErrors() );
	}

	public static function provideMerge() {
		$errors = array(
			Error::newError( 'foo' ),
			Error::newError( 'bar' ),
		);

		return array(
			array(
				Result::newSuccess(),
				Result::newSuccess(),
				true,
				0,
				'success + success'
			),
			array(
				Result::newSuccess(),
				Result::newError( $errors ),
				false,
				2,
				'success + error'
			),
			array(
				Result::newSuccess(),
				Result::newError( $errors ),
				false,
				2,
				'error + success'
			),
			array(
				Result::newError( $errors ),
				Result::newError( $errors ),
				false,
				4,
				'error + error'
			),
		);
	}

	/**
	 * @dataProvider provideMerge
	 */
	public function testMerge( $a, $b, $expectedValid, $expectedErrorCount, $message ) {
		$result = Result::merge( $a, $b );

		$this->assertEquals( $expectedValid, $result->isValid(), $message );
		$this->assertCount( $expectedErrorCount, $result->getErrors(), $message );
	}

}
