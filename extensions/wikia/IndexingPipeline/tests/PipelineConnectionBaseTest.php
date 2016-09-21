<?php

class PipelineConnectionBaseTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../IndexingPipeline.setup.php';
		parent::setUp();
	}

	/** @test */
	public function shouldLoadConfigCorrectly() {
		global $wgIndexingPipeline;
		$wgIndexingPipeline = [
			'host' => 'test.host',
			'port' => 0,
			'user' => 'test-user',
			'pass' => 'test-pass',
			'vhost' => 'test-vhost',
			'exchange' => 'test-exchange',
			'deadExchange' => 'test-dead',
		];

		$pipe = new \Wikia\IndexingPipeline\ConnectionBase( $wgIndexingPipeline );
		$this->assertAttributeEquals($wgIndexingPipeline['host'], 'host', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['port'], 'port', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['user'], 'user', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['pass'], 'pass', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['vhost'], 'vhost', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['exchange'], 'exchange', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['deadExchange'], 'deadExchange', $pipe);
	}
}
