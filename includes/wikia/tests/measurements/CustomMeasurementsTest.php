<?php

class CustomMeasurementsTest extends WikiaBaseTest {

	public function testMeasureTime() {
		$categoryName = 'foo';
		$measureName = 'bar';
		$callback = function () { return 'x'; };
		$returnedValue = 'baz';

		$driver = $this->getMock( "CustomMeasurementsDriver" );
		$driver->expects( $this->once() )
			->method( 'measureTime' )
			//->with( $this->equalTo( $categoryName, $measureName, $callback ) )
			->will( $this->returnValue( $returnedValue ) );

		$measurements = new CustomMeasurements( $categoryName, $driver );
		$this->assertEquals( $returnedValue, $measurements->measureTime( $measureName, $callback ) );
	}
}
