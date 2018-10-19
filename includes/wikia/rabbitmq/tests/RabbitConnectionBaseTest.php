<?php

use PHPUnit\Framework\TestCase;

class RabbitConnectionBaseTest extends TestCase {

	public function testShouldLoadConfigCorrectly() {
		$wgIndexingPipeline = [
			'vhost' => 'test-vhost',
			'exchange' => 'test-exchange',
		];

		$pipe = new \Wikia\Rabbit\ConnectionBase( $wgIndexingPipeline );

		$this->assertAttributeEquals( $wgIndexingPipeline['vhost'], 'vhost', $pipe );
		$this->assertAttributeEquals( $wgIndexingPipeline['exchange'], 'exchange', $pipe );
	}
}
