<?php


namespace Wikia\Search\Test\Services;


use Wikia\Search\Services\EntitySearchService;
use Wikia\Search\Test\BaseTest;

class DummyEntitySearchService extends EntitySearchService {

	protected $blacklistedWikiIds = [ 1 ];
	protected $excludedWikis = [ 'uncyclopedia.wikia.com' ];

	public function getSelectQueryObject() {
		$select = $this->getSelect();
		$this->applyBlackListedWikisQuery( $select );
		return $select;
	}
}

class DummyEntitySearchServiceXwiki extends EntitySearchService {

	protected $BLACKLISTED_WIKI_IDS = [ 1 ];
	protected $excludedWikis = [ 'uncyclopedia.wikia.com' ];

	protected function getCore() {
		return static::XWIKI_CORE;
	}

	public function getSelectQueryObject() {
		$select = $this->getSelect();
		$this->applyBlackListedWikisQuery( $select );
		return $select;
	}
}

class EntitySearchServiceTest extends BaseTest {

	public function testBlackListedWikiId() {

		$dummy = new DummyEntitySearchService();
		$select = $dummy->getSelectQueryObject();

		$filterQueries = $select->getFilterQueries();
		$this->assertTrue( isset($filterQueries["widblacklist"]) );

		$query = $select->getFilterQuery("widblacklist");
		$this->assertEquals("-(wid:1)", $query->getQuery(), "filter query use defined wiki ids");

		$dummy->appendBlacklistedWikiId(2);
		$select = $dummy->getSelectQueryObject();
		$query2 = $select->getFilterQuery("widblacklist");
		$this->assertEquals("-(wid:1) AND -(wid:2)", $query2->getQuery(), "filter query use defined wiki ids");
	}

	public function testBlackListedHosts() {
		$dummy = new DummyEntitySearchService();
		$select = $dummy->getSelectQueryObject();

		$filterQueries = $select->getFilterQueries();
		$this->assertTrue( isset($filterQueries["excl"]) );

		$query = $select->getFilterQuery("excl");
		$this->assertEquals("-(host:uncyclopedia.wikia.com)", $query->getQuery(), "filter query use defined wiki hosts");
	}

	public function testBlackListedHostsXWiki() {
		$dummy = new DummyEntitySearchServiceXwiki();
		$select = $dummy->getSelectQueryObject();

		$filterQueries = $select->getFilterQueries();
		$this->assertTrue( isset($filterQueries["excl"]) );

		$query = $select->getFilterQuery("excl");
		$this->assertEquals("-(hostname_s:uncyclopedia.wikia.com)", $query->getQuery(), "filter query use defined wiki hosts");
	}


}
