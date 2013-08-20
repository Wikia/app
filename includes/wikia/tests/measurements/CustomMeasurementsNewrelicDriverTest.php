<?php

class CustomMeasurementsNewrelicDriverTest extends WikiaBaseTest {
	public function testCanUse() {
		// This is weak. Don't really see better way to test it. I think this is better than nothing.
		if ( extension_loaded("newrelic") ) {
			$this->assertTrue( (new CustomMeasurementsNewrelicDriver())->canUse() );
		} else  {
			$this->assertFalse( (new CustomMeasurementsNewrelicDriver())->canUse() );
		}
	}

	public function testMeasureTime() {
		$measurementCategory = 'foo';
		$measurementName = 'bar';
		$callable = function() { return 'baz'; };

		$this->mockGlobalFunction("newrelic_custom_metric", null);

		$this->assertEquals( 'baz', (new CustomMeasurementsNewrelicDriver())->measureTime($measurementCategory, $measurementName, $callable) );
	}
}
