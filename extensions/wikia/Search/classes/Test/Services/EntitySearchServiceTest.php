<?php

namespace Wikia\Search\Test\Services;

use Wikia\Search\Services\EntitySearchService;
use Wikia\Search\Test\BaseTest;

class EntitySearchServiceTest extends BaseTest {

	/** @test */
	public function shouldCreateCorrectSelect( $config ) {
		$mock = $this->getMockBuilder( 'EntitySearchService' )
			->enableOriginalConstructor()
			->getMock();

		$mock->query();

		var_dump( $mock );
	}

	public function configProvider() {
		return [
			[
				[
					'adapter' => "Solarium_Client_Adapter_Curl",
					'adapteroptions' => [
						'host' => "search",
						'port' => null,
						'path' => "/solr/",
						'proxy' => "127.0.0.1:6081",
					]
				]
			],
		];
	}

}