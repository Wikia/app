<?php

class PopularArticlesModelTest extends WikiaBaseTest {
	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass( get_class($obj) );
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function() use ($obj, $method){
			$args = func_get_args();
			return $method->invokeArgs($obj, $args);
		};
	}

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../../../';
		global $wgAutoloadClasses;
		$wgAutoloadClasses['MarketingToolboxModel']	= $dir . '../WikiaHubsServices/models/MarketingToolboxModel.class.php';
		$wgAutoloadClasses['AbstractMarketingToolboxModel']	= $dir . '../WikiaHubsServices/models/AbstractMarketingToolboxModel.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleSliderService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleSliderService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleFromthecommunityService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleFromthecommunityService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleWikiaspicksService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleWikiaspicksService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleEditableService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleEditableService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleFeaturedvideoService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleFeaturedvideoService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleExploreService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleExploreService.class.php';
		$wgAutoloadClasses['MarketingToolboxModulePollsService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModulePollsService.class.php';
		$wgAutoloadClasses['MarketingToolboxModulePopularvideosService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModulePopularvideosService.class.php';
		$wgAutoloadClasses['MarketingToolboxExploreModel'] = $dir . '../WikiaHubsServices/models/MarketingToolboxExploreModel.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleWAMService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleWAMService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleNonEditableService'] = $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleNonEditableService.class.php';
		$wgAutoloadClasses['MarketingToolboxModuleService'] =  $dir . '../WikiaHubsServices/modules/MarketingToolboxModuleService.class.php';
		$wgAutoloadClasses['MarketingToolboxV3Model']	= $dir . '../WikiaHubsServices/models/MarketingToolboxV3Model.class.php';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}
	private function mockRecentlyEditedPageIdsQuery(){
		$mockQueryResults = $this->getMock("ResultWrapper", array('fetchObject'), array(), '', false);

		$mockDb = $this->getMock('DatabaseMysql', array('query'));
		$mockDb->expects($this->any())->method('query')->will($this->returnValue($mockQueryResults));

		$this->mockGlobalFunction('wfGetDb', $mockDb);

		// pre-populate results
		$args = func_get_args();




		return $mockQueryResults;
	}

	private function fakeRecentlyEditedQueryRow(Title $title){
		$row = new stdClass();
		$row->page_namespace = $title->getNamespace();
		$row->page_title = $title->getBaseText();
		$row->page_id = $title->getArticleId();
		return $row;
	}


	public function testRecentlyEditedPageIds_SkipMainPage() {
		$mainPage = Title::newMainPage();

		$mockResults = $this->mockRecentlyEditedPageIdsQuery();
		$mockResults->expects($this->at(0))->method("fetchObject")
			->will($this->returnValue($this->fakeRecentlyEditedQueryRow($mainPage)));

		$fn = self::getFn(new PopularArticlesModel(), 'getRecentlyEditedPageIds');
		$result = $fn(0);

		$this->assertEmpty($result);
	}

	public function testRecentlyEditedPageIds_ReturnPageIds() {
		$someTitle = Title::newFromText("some title");
		$row0 = $this->fakeRecentlyEditedQueryRow($someTitle);
		$row1 = clone $row0;
		$row0->page_id = 0;
		$row1->page_id = 1;

		$mockResults = $this->mockRecentlyEditedPageIdsQuery();
		$mockResults->expects($this->at(0))->method("fetchObject")
			->will($this->returnValue($row0));
		$mockResults->expects($this->at(1))->method("fetchObject")
			->will($this->returnValue($row1));

		$fn = self::getFn(new PopularArticlesModel(), 'getRecentlyEditedPageIds');
		$result = $fn(0);

		$this->assertEquals($result[0], 0);
		$this->assertEquals($result[1], 1);
	}


	public function testGetArticles(){
		$row = $this->fakeRecentlyEditedQueryRow(Title::newFromText("some title"));

		$mockResults = $this->mockRecentlyEditedPageIdsQuery();
		$mockResults->expects($this->at(0))->method("fetchObject")
			->will($this->returnValue($row));
		$mockResults->expects($this->at(1))->method("fetchObject")
			->will($this->returnValue($row));



		$mockPop = $this->getMock("PopularArticlesModel", ["getRecentlyEditedPageIds"]);
//		$mockPop->expects($this->any())->method("filterResultsOverQuality")->will($this->returnValue($article_feed));

		$mockPop->getArticles(0);


	}

}
