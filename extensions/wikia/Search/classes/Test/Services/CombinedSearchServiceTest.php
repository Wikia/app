<?php


namespace Wikia\Search\Test\Services;


use Wikia\Search\Services\CombinedSearchService;
use Wikia\Search\Test\BaseTest;
use Wikia\Search\Test\ConfigMock;

class CombinedSearchServiceTest extends BaseTest {

	public function testSearch() {
		$configMock = $this->getMock('Wikia\Search\Test\ConfigMock');
		$this->mockClass( 'Wikia\Search\Config', new ConfigMock() );

		$service = new CombinedSearchService();
		$result = $service->search( "q", ["pl"], [1], []);
	}
}
