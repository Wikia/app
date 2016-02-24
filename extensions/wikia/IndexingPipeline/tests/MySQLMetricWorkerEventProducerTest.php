<?php

use Wikia\IndexingPipeline\MySQLMetricEventProducer;

class MySQLMetricEventProducerTest extends WikiaBaseTest {
	private $eventProducer;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../IndexingPipeline.setup.php';
		parent::setUp();

		$this->eventProducer = new MySQLMetricEventProducer();
	}


	/**
	 * @param array $pageId
	 * @param $wgCityId
	 * @param array $expectedOutput
	 * @dataProvider testPrepareMessageDataProvider
	 */
	public function testPrepareMessage( $pageId, $wgCityId, $expectedOutput ) {
		$this->mockGlobalVariable('wgCityId', $wgCityId);
		$this->assertEquals(
			$expectedOutput,
			$this->eventProducer->prepareMessage( $pageId )
		);
	}

	public function testPrepareMessageDataProvider() {
		return [
			[
				'pageId' => '453',
				'wgCityId' => '1000',
				'expect' => (object)array(
					"id" => "1000_453",
					"update" => (object)array(
						'matches_mv' => (object)array(
							'mainpage_b' => 'true'
						)
					)
				)
			],
			[
				'pageId' => '111',
				'wgCityId' => '333',
				'expect' => (object)array(
					"id" => "333_111",
					"update" => (object)array(
						'matches_mv' => (object)array(
							'mainpage_b' => 'true'
						)
					)
				)
			]
		];
	}
}
