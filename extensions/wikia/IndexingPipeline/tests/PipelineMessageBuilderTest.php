<?php

/**
 * @covers Wikia\IndexingPipeline\PipelineMessageBuilder
 */
class PipelineMessageBuilderTest extends WikiaBaseTest {

	/** @var Wikia\IndexingPipeline\PipelineMessageBuilder $pipelineMessageBuilder */
	private $pipelineMessageBuilder;

	protected function setUp() {
		parent::setUp();

		$this->pipelineMessageBuilder = Wikia\IndexingPipeline\PipelineMessageBuilder::create();
	}

	public function testEmptyMessage() {
		$this->assertEquals( new stdClass(), $this->pipelineMessageBuilder->build() );
	}

	public function testDefaultWikiIdMsg() {
		( new \Wikia\Util\GlobalStateWrapper( [ 'wgCityId' => 1 ] ) )->wrap( function () {
			$expected = new stdClass();
			$expected->cityId = 1;
			$this->assertEquals( $expected, $this->pipelineMessageBuilder
				->addWikiId()
				->build() );
		} );
	}

	public function testWikiIdMsg() {
		$expected = new stdClass();
		$expected->cityId = 2;
		$this->assertEquals( $expected, $this->pipelineMessageBuilder
			->addWikiId( 2 )
			->build() );
	}

	public function testAllIdsMsg() {
		$expected = new stdClass();
		$expected->cityId = 2;
		$expected->pageId = 2;
		$expected->revisionId = 2;
		$this->assertEquals( $expected, $this->pipelineMessageBuilder
			->addWikiId( 2 )
			->addPageId( 2 )
			->addRevisionId( 2 )
			->build() );
	}

	public function testParamAdding() {
		$expected = new stdClass();
		$expected->test = 'test';
		$this->assertEquals( $expected, $this->pipelineMessageBuilder
			->addParam( 'test', 'test' )
			->build() );
	}

	public function testMultipleParamsAdding() {
		$expected = new stdClass();
		$expected->test = 'test';
		$expected->test2 = 'test2';
		$this->assertEquals( $expected, $this->pipelineMessageBuilder
			->addParams( [ 'test' => 'test', 'test2' => 'test2' ] )
			->build() );
	}

}
