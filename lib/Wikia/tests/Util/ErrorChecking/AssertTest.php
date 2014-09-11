<?php

use Wikia\Util\ErrorChecking\Assert;

class AssertTest extends PHPUnit_Framework_TestCase {
	public function testTrue() {
		$this->assertTrue( Assert::true( 1 == 1 ) );
		$this->assertTrue( Assert::true( 2 < 10 ) );
	}

	/**
	 * @expectedException Exception
	 */
	public function testFalse() {
		Assert::true( 2 > 10 );
	}
}
