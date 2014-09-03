<?php


namespace Wikia\Search\Test\Services;


use Wikia\Search\Services\EntitySearchService;
use Wikia\Search\Test\BaseTest;

class DummyEntitySearchService extends EntitySearchService {
	public function setBlacklistedWikiIds( $wikiIds ) {
		$this->blacklistedWikiIds = $wikiIds;
	}
}

class EntitySearchServiceTest extends BaseTest {
	public function testBlacklistQueryMultipleItems() {
		$dummy = new DummyEntitySearchService();
		$dummy->setBlacklistedWikiIds( [ 1, 2, "99" ] );
		$query = $dummy->getBlacklistedWikiIdsQuery( "wid" );
		$this->assertEquals( $query, "-(wid:1) AND -(wid:2) AND -(wid:99)" );
	}

	public function testBlacklistQuerySingleItem() {
		$dummy = new DummyEntitySearchService();
		$dummy->setBlacklistedWikiIds( [ 1 ] );
		$query = $dummy->getBlacklistedWikiIdsQuery( "wid" );
		$this->assertEquals( $query, "-(wid:1)" );
	}
}
