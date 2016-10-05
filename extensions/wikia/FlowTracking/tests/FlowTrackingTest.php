<?php

class FlowTrackingTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../FlowTracking.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider urlQueriesDataProvider
	 */
	public function testGetParamsFromUrlQuery( $url, $expectedParams ) {
		$params = FlowTrackingHooks::getParamsFromUrlQuery( $url );

		$this->assertEquals( $expectedParams, $params );
	}

	public function urlQueriesDataProvider() {
		return [
			[
				'http://www.wikia.com?a=1&b=2&c=3',
				[
					'a' => '1',
					'b' => '2',
					'c' => '3'
				]
			],
			[
				'http://www.wikia.com?a=1&b=2#test',
				[
					'a' => '1',
					'b' => '2'
				]
			],
			[
				'http://www.wikia.com',
				[]
			]
		];
	}

}
