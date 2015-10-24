<?php

class PipelineEventProducerTest extends WikiaBaseTest {
	private $pipelineEventProducer;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PipelineEventProducer.setup.php';
		$this->pipelineEventProducer = new PipelineEventProducer();
		parent::setUp();
	}

	/** @test
	 * @param $inputData
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider prepareRouteTestDataProvider
	 */
	public function prepareRouteTest($inputData, $expectedOutput, $description) {
		$actualOutput = $this->pipelineEventProducer->prepareRoute( $inputData['action'], $inputData['ns'], $inputData['flags'], $inputData['data'] );

		$this->assertEquals( $expectedOutput, $actualOutput, $description );
	}

	public function prepareRouteTestDataProvider() {
		global $wgCanonicalNamespaceNames;
		return [
			[
				'data' => [
					'action' => PipelineEventProducer::ACTION_CREATE,
					'ns' => strtolower( $wgCanonicalNamespaceNames[ NS_TEMPLATE ] ),
					'flags' => [],
					'data' => []
				],
				'expect' => 'MWEventsProducer._action:create._namespace:template',
				'description' => 'Create template action'
			],
			[
				'data' => [
					'action' => PipelineEventProducer::ACTION_UPDATE,
					'ns' => PipelineEventProducer::CONTENT,
					'flags' => [],
					'data' => [ 'isNew' => false ]
				],
				'expect' => 'MWEventsProducer._action:update._namespace:content._content:isNew',
				'description' => 'Article undelete(restore) action'
			],
			[
				'data' => [
					'action' => PipelineEventProducer::ACTION_UPDATE,
					'ns' => PipelineEventProducer::CONTENT,
					'flags' => [],
					'data' => [ 'redirectId' => 578437 ]
				],
				'expect' => 'MWEventsProducer._action:update._namespace:content._content:redirectId',
				'description' => 'Article title move action'
			]
			,
			[
				'data' => [
					'action' => PipelineEventProducer::ACTION_DELETE,
					'ns' => strtolower( $wgCanonicalNamespaceNames[ NS_USER_TALK ] ),
					'flags' => [],
					'data' => []
				],
				'expect' => 'MWEventsProducer._action:delete._namespace:user_talk',
				'description' => 'User talk page delete action'
			]
		];
	}
}