<?php

class CustomMeasurementsDummyDriverTest extends WikiaBaseTest {
	public function testCanUse() {
		$this->assertTrue( (new CustomMeasurementsDummyDriver())->canUse() );
	}

	public function testMeasureTime() {
		$measurementCategory = 'foo';
		$measurementName = 'bar';
		$callable = function() { return 'baz'; };
		$this->assertEquals( 'baz', (new CustomMeasurementsDummyDriver())->measureTime($measurementCategory, $measurementName, $callable) );
	}
}
