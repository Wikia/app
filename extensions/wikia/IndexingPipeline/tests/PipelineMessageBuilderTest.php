<?php

use Wikia\IndexingPipeline\PipelineMessageBuilder;

class PipelineMessageBuilderTest extends WikiaBaseTest {

	public function testEmptyMessage() {
		$this->assertEquals( new stdClass(), PipelineMessageBuilder::create()
			->build() );
	}

	public function testDefaultWikiIdMsg() {
		( new \Wikia\Util\GlobalStateWrapper( [ 'wgCityId' => 1 ] ) )->wrap( function () {
			$expected = new stdClass();
			$expected->cityId = 1;
			$this->assertEquals( $expected, PipelineMessageBuilder::create()
				->addWikiId()
				->build() );
		} );
	}

	public function testWikiIdMsg() {
		$expected = new stdClass();
		$expected->cityId = 2;
		$this->assertEquals( $expected, PipelineMessageBuilder::create()
			->addWikiId( 2 )
			->build() );
	}

	public function testAllIdsMsg() {
		$expected = new stdClass();
		$expected->cityId = 2;
		$expected->pageId = 2;
		$expected->revisionId = 2;
		$this->assertEquals( $expected, PipelineMessageBuilder::create()
			->addWikiId( 2 )
			->addPageId( 2 )
			->addRevisionId( 2 )
			->build() );
	}

	public function testParamAdding() {
		$expected = new stdClass();
		$expected->test = 'test';
		$this->assertEquals( $expected, PipelineMessageBuilder::create()
			->addParam( 'test', 'test' )
			->build() );
	}

	public function testMultipleParamsAdding() {
		$expected = new stdClass();
		$expected->test = 'test';
		$expected->test2 = 'test2';
		$this->assertEquals( $expected, PipelineMessageBuilder::create()
			->addParams( [ 'test' => 'test', 'test2' => 'test2' ] )
			->build() );
	}

}
