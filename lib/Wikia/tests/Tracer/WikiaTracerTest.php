<?php

use Wikia\Tracer\WikiaTracer;

/**
 * Tests WikiaTracer class
 *
 * @group WikiaTracer
 */
class WikiaTracerTest extends WikiaBaseTest {

	/**
	 * @param string $caller
	 * @param string $expected
	 * @dataProvider getAppNameFromCallerProvider
	 */
	public function testGetAppNameFromCaller( $caller, $expected ) {
		$this->assertEquals( $expected, WikiaTracer::getAppNameFromCaller( $caller ) );
	}

	public function getAppNameFromCallerProvider() {
		return [
			[
				'Wikia\Service\Helios\HeliosClientImpl:Wikia\Service\Helios\{closure}',
				'Helios'
			],
			[
				'Wikia\Service\Gateway\ConsulUrlProvider:getUrl',
				'ConsulUrlProvider:getUrl'
			]
		];
	}
}
