<?php

namespace Wikia\Measurements;

class NewrelicDriverTest extends \WikiaBaseTest {
	public function setUp() {
		parent::setUp();
		require_once __DIR__ . '/newrelic_custom_metric_mock.php';
	}

	public function testCanUse() {
		// This is weak. Don't really see better way to test it. I think this is better than nothing.
		if ( extension_loaded("newrelic") ) {
			$this->assertTrue( (new NewrelicDriver())->canUse() );
		} else  {
			$this->assertFalse( (new NewrelicDriver())->canUse() );
		}
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.01527 ms
	 */
	public function testMeasureTime() {
		$this->getGlobalFunctionMock("newrelic_custom_metric")
			->expects( $this->once() )
			->method( 'newrelic_custom_metric' )
			->with( "Custom/foo[seconds|call]", 100.0 );

		(new NewrelicDriver())->measureTime( "foo", 0.1 );
	}
}
