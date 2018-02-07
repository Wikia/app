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
 * @license GPL-2.0+
 * @author Daniel Kinzler
 */
class ResultTest extends \PHPUnit_Framework_TestCase {

	public function testNewSuccess() {
		$result = Result::newSuccess();

		$this->assertTrue( $result->isValid() );
		$this->assertEmpty( $result->getErrors() );
	}

	public function testNewError() {
		$result = Result::newError( [
			Error::newError( 'foo' ),
			Error::newError( 'bar' ),
		] );

		$this->assertFalse( $result->isValid() );
		$this->assertCount( 2, $result->getErrors() );
	}

	public static function provideMerge() {
		$errors = [
			Error::newError( 'foo' ),
			Error::newError( 'bar' ),
		];

		return [
			[
				Result::newSuccess(),
				Result::newSuccess(),
				true,
				0,
				'success + success'
			],
			[
				Result::newSuccess(),
				Result::newError( $errors ),
				false,
				2,
				'success + error'
			],
			[
				Result::newSuccess(),
				Result::newError( $errors ),
				false,
				2,
				'error + success'
			],
			[
				Result::newError( $errors ),
				Result::newError( $errors ),
				false,
				4,
				'error + error'
			],
		];
	}

	/**
	 * @dataProvider provideMerge
	 */
	public function testMerge( $a, $b, $expectedValid, $expectedErrorCount, $message ) {
		$result = Result::merge( $a, $b );

		$this->assertSame( $expectedValid, $result->isValid(), $message );
		$this->assertCount( $expectedErrorCount, $result->getErrors(), $message );
	}

}
