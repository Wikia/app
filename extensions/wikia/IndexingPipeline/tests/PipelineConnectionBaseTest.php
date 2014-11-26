<?php
/**
 * Created by adam
 * Date: 26.11.14
 */
require_once "$IP/extensions/wikia/IndexingPipeline/PipelineConnectionBase.class.php";

class PipelineConnectionBaseTest extends WikiaBaseTest {

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
		$pipe = new PipelineConnectionBase();
		$this->assertAttributeEquals($wgIndexingPipeline['host'], 'host', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['port'], 'port', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['user'], 'user', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['pass'], 'pass', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['vhost'], 'vhost', $pipe);
		$this->assertAttributeEquals($wgIndexingPipeline['deadExchange'], 'deadExchange', $pipe);
	}
}