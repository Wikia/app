<?php

namespace Wikia\Measurements;

class TimeTest extends \WikiaBaseTest {

	public function testStop() {
		$driver = $this->buildMock();
		$driver->expects( $this->once() )
			->method( 'measureTime' );

		$measurements = new Time( "foo", $driver );
		$measurements->stop();
	}

	public function testAutoDestroy() {
		$driver = $this->buildMock();
		$driver->expects( $this->once() )
			->method( 'measureTime' );

		$measurements = new Time( "foo", $driver );
	}
	public function testRun() {
		$driver = $this->buildMock();
		$driver->expects( $this->once() )
			->method( 'measureTime' );
		Drivers::set( $driver );

		$this->assertEquals( "foo", Time::run("bar", function() { return "foo"; } ) );
	}

	public function testStart() {
		$driver = $this->buildMock();
		$driver->expects( $this->once() )
			->method( 'measureTime' );
		Drivers::set( $driver );

		Time::start("bar");
	}

	protected  function buildMock() {
		return $this->getMock( "Wikia\\Measurements\\Driver", ["measureTime", "canUse"] );
	}
}
