<?php

class WikiaHubsServicesHelperTest extends WikiaBaseTest {
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider purgeHomePageVarnishDataProvider
	 */
	public function testPurgeHomePageVarnish($lang, $wikiId, $mainPageName) {
		$globalTitleMock = $this->getMock('GlobalTitle', array('purgeSquid'));
		$globalTitleMock->expects($this->once())
			->method('purgeSquid');

		$corporateModelMock = $this->getMock('WikiaCorporateModel', array('getCorporateWikiIdByLang'));

		$corporateModelMock->expects($this->any())
			->method('getCorporateWikiIdByLang')
			->will($this->returnValue($wikiId));

		$hubsHelperMockClass = $this->getMockClass(
			'WikiaHubsServicesHelper',
			array('getMainPageNameByWikiId', 'getGlobalTitleFromText')
		);

		$hubsHelperMock = $this->getMock($hubsHelperMockClass, array('getCorporateModel'));

		$hubsHelperMock->expects($this->any())
			->method('getCorporateModel')
			->will($this->returnValue($corporateModelMock));

		$hubsHelperMockClass::staticExpects($this->any())
			->method('getMainPageNameByWikiId')
			->will($this->returnValue($mainPageName));

		$hubsHelperMockClass::staticExpects($this->any())
			->method('getGlobalTitleFromText')
			->with(
				$this->equalTo($mainPageName),
				$this->equalTo($wikiId)
			)
			->will($this->returnValue($globalTitleMock));

		$hubsHelperMock->purgeHomePageVarnish($lang);
	}

	public function purgeHomePageVarnishDataProvider() {
		return array(
			array('en', 666, 'Wikia'),
			array('de', 123, 'mainpage'),
			array('es', 1, 'Main_page')
		);
	}

	/**
	 * @dataProvider purgeHubVarnish
	 */
	public function testPurgeHubVarnish($lang, $wikiId, $verticalId, $hubName) {
		$globalTitleMock = $this->getMock('GlobalTitle', array('purgeSquid'));
		$globalTitleMock->expects($this->once())
			->method('purgeSquid');

		$corporateModelMock = $this->getMock('WikiaCorporateModel', array('getCorporateWikiIdByLang'));

		$corporateModelMock->expects($this->any())
			->method('getCorporateWikiIdByLang')
			->will($this->returnValue($wikiId));

		$hubsHelperMockClass = $this->getMockClass(
			'WikiaHubsServicesHelper',
			array('getHubName', 'getGlobalTitleFromText')
		);

		$hubsHelperMock = $this->getMock($hubsHelperMockClass, array('getCorporateModel'));

		$hubsHelperMock->expects($this->any())
			->method('getCorporateModel')
			->will($this->returnValue($corporateModelMock));

		$hubsHelperMockClass::staticExpects($this->any())
			->method('getHubName')
			->with(
				$this->equalTo($wikiId),
				$this->equalTo($verticalId)
			)
			->will($this->returnValue($hubName));

		$hubsHelperMockClass::staticExpects($this->any())
			->method('getGlobalTitleFromText')
			->with(
				$this->equalTo($hubName),
				$this->equalTo($wikiId)
			)
			->will($this->returnValue($globalTitleMock));

		$hubsHelperMock->purgeHubVarnish($lang, $verticalId);
	}

	public function purgeHubVarnish() {
		return array(
			array('en', 666, WikiFactoryHub::CATEGORY_ID_GAMING, 'Videogames'),
			array('de', 123, WikiFactoryHub::CATEGORY_ID_GAMING, 'Videospiele'),
			array('es', 1, WikiFactoryHub::CATEGORY_ID_LIFESTYLE, 'Estilo_de_vida')
		);
	}
}