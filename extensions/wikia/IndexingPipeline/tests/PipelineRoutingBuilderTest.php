<?php

use Wikia\IndexingPipeline\PipelineRoutingBuilder;

class PipelineRoutingBuilderTest extends WikiaBaseTest {

	public function testEmptyBuild() {
		$expected = "";
		$this->assertEquals( $expected, PipelineRoutingBuilder::create()
			->build() );
	}

	public function testNameOnly() {
		$expected = "test";
		$this->assertEquals( $expected, PipelineRoutingBuilder::create()
			->addName( "test" )
			->build() );
	}

	public function testAllArgs() {
		$expected = "test._action:create._namespace:content";
		$this->assertEquals( $expected, PipelineRoutingBuilder::create()
			->addName( "test" )
			->addAction( PipelineRoutingBuilder::ACTION_CREATE )
			->addNamespace( 0 )
			->build() );
	}

	public function testAllArgsInRandomOrder() {
		$expected = "test._namespace:content._action:create";
		$this->assertEquals( $expected, PipelineRoutingBuilder::create()
			->addNamespace( 0 )
			->addAction( PipelineRoutingBuilder::ACTION_CREATE )
			->addName( "test" )
			->build() );
	}

	public function testTypeAndStringNamespace() {
		$expected = "test._type:wikia._namespace:test";
		$this->assertEquals( $expected, PipelineRoutingBuilder::create()
			->addName( "test" )
			->addType( PipelineRoutingBuilder::TYPE_WIKIA )
			->addNamespace( "test" )
			->build() );
	}

	public function testWrongNSid() {
		$expected = "test";
		$this->assertEquals( $expected, PipelineRoutingBuilder::create()
			->addName( "test" )
			->addNamespace( -10 )
			->build()
		);
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function testWrongAction() {
		$expected = "test";
		$this->assertEquals( $expected, PipelineRoutingBuilder::create()
			->addName( "test" )
			->addAction( "test" )
			->build()
		);
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function testWrongType() {
		$expected = "test";
		$this->assertEquals( $expected, PipelineRoutingBuilder::create()
			->addName( "test" )
			->addType( "test" )
			->build()
		);
	}

}
