<?php

namespace Wikia\Measurements;

class NewrelicDriverTest extends \WikiaBaseTest {
	public function testCanUse() {
		// This is weak. Don't really see better way to test it. I think this is better than nothing.
		if ( extension_loaded("newrelic") ) {
			$this->assertTrue( (new NewrelicDriver())->canUse() );
		} else  {
			$this->assertFalse( (new NewrelicDriver())->canUse() );
		}
	}

	public function testMeasureTime() {
		$this->mockGlobalFunction("newrelic_custom_metric", null);

		(new NewrelicDriver())->measureTime( "foo", 0.1 );
	}
}
