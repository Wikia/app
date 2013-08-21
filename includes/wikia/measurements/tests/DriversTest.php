<?php

namespace Wikia\Measurements;

class DriversTest extends \WikiaBaseTest {

	public function testResetDefault() {
		Drivers::resetDefault();
		$this->assertNotNull( Drivers::get() );
	}

	public function testSetAndGet() {
		$driver = $this->getMock( "Wikia\\Measurements\\Driver" );
		Drivers::set($driver);
		$this->assertEquals( $driver, Drivers::get() );
	}

}
