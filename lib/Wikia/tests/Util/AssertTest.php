<?php

use Wikia\Util\Assert;

class AssertTest extends PHPUnit_Framework_TestCase {
	public function testTrue() {
		$this->assertTrue( Assert::boolean( 1 == 1 ) );
		$this->assertTrue( Assert::boolean( 2 < 10 ) );
	}

	/**
	 * @expectedException Exception
	 */
	public function testFalse() {
		Assert::boolean( 2 > 10 );
	}
}
