<?php

use \Wikia\IndexingPipeline;

class PipelineEventProducerTest extends WikiaBaseTest {
	private $pipelineEventProducer;
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../IndexingPipeline.setup.php';
		$this->pipelineEventProducer = new \Wikia\IndexingPipeline\PipelineEventProducer();
		parent::setUp();
	}

	/** @test
	 * @param $inputData
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider prepareRouteTestDataProvider
	 */
	public function prepareRouteTest($inputData, $expectedOutput, $description) {
		$actualOutput = $this->pipelineEventProducer->prepareRoute( $inputData['action'], $inputData['ns'], $inputData['data'] );
		$this->assertEquals( $expectedOutput, $actualOutput, $description );
	}
	public function prepareRouteTestDataProvider() {
		global $wgCanonicalNamespaceNames;
		return [
			[
				'data' => [
					'action' => \Wikia\IndexingPipeline\PipelineEventProducer::ACTION_CREATE,
					'ns' => strtolower( $wgCanonicalNamespaceNames[ NS_TEMPLATE ] ),
					'data' => []
				],
				'expect' => 'MWEventsProducer._action:create._namespace:template',
				'description' => 'Create template action'
			],
			[
				'data' => [
					'action' => \Wikia\IndexingPipeline\PipelineEventProducer::ACTION_UPDATE,
					'ns' => \Wikia\IndexingPipeline\PipelineEventProducer::NS_CONTENT,
					'data' => [
						'isNew' => false,
						'otherParam' => "other_value",
						'numberParam' => 45
					]
				],
				'expect' => 'MWEventsProducer._action:update._namespace:content._content:isNew._content:otherParam._content:numberParam',
				'description' => 'Article undelete(restore) action'
			],
			[
				'data' => [
					'action' => \Wikia\IndexingPipeline\PipelineEventProducer::ACTION_UPDATE,
					'ns' => \Wikia\IndexingPipeline\PipelineEventProducer::NS_CONTENT,
					'data' => [ 'redirectId' => 578437 ]
				],
				'expect' => 'MWEventsProducer._action:update._namespace:content._content:redirectId',
				'description' => 'Article title move action'
			]
			,
			[
				'data' => [
					'action' => \Wikia\IndexingPipeline\PipelineEventProducer::ACTION_DELETE,
					'ns' => strtolower( $wgCanonicalNamespaceNames[ NS_USER_TALK ] ),
					'data' => []
				],
				'expect' => 'MWEventsProducer._action:delete._namespace:user_talk',
				'description' => 'User talk page delete action'
			],
			[
				'data' => [
					'action' => \Wikia\IndexingPipeline\PipelineEventProducer::ACTION_CREATE,
					'ns' => strtolower( $wgCanonicalNamespaceNames[ NS_TEMPLATE ] ),
					'data' => null
				],
				'expect' => 'MWEventsProducer._action:create._namespace:template',
				'description' => 'Create template with null data array'
			],
			[
				'data' => [
					'action' => \Wikia\IndexingPipeline\PipelineEventProducer::ACTION_CREATE,
					'ns' => strtolower( $wgCanonicalNamespaceNames[ NS_TEMPLATE ] ),
					'data' => 5453
				],
				'expect' => 'MWEventsProducer._action:create._namespace:template',
				'description' => 'Create template with invalid data array'
			],
			[
				'data' => [
					'action' => \Wikia\IndexingPipeline\PipelineEventProducer::ACTION_CREATE,
					'ns' => strtolower( $wgCanonicalNamespaceNames[ NS_TEMPLATE ] )
				],
				'expect' => 'MWEventsProducer._action:create._namespace:template',
				'description' => 'Create template with no data array'
			]
		];
	}
}
