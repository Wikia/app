<?php

namespace Wikia\Measurements;

class DummyDriverTest extends \WikiaBaseTest {
	public function testCanUse() {
		$this->assertTrue( (new DummyDriver())->canUse() );
	}

	public function testMeasureTimeDoesNotThrow() {
		(new DummyDriver())->measureTime( "foo" , 0.1 ); // does not throw
	}
}
