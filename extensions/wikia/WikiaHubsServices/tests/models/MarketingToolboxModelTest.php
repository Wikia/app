<?php

class MarketingToolboxModelTest extends WikiaBaseTest {

	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	public function testGetModuleName() {
		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('msg'));

		$functionWrapperMock->expects($this->once())
			->method('msg')
			->with('marketing-toolbox-hub-module-top10-list')
			->will($this->returnValue('testNameFor Top 10 list'));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		$model = new MarketingToolboxModel();

		$model->setApp($app);

		$this->assertEquals(
			'testNameFor Top 10 list',
			$model->getModuleName(MarketingToolboxModuleTop10listService::MODULE_ID)
		);
	}

	public function testGetNotTranslatedModuleName() {
		$testDatas = array(
			MarketingToolboxModuleSliderService::MODULE_ID => 'Slider',
			MarketingToolboxModulePulseService::MODULE_ID => 'Pulse',
			MarketingToolboxModuleWikiaspicksService::MODULE_ID => 'Wikiaspicks',
			MarketingToolboxModuleFeaturedvideoService::MODULE_ID => 'Featuredvideo',
			MarketingToolboxModuleExploreService::MODULE_ID => 'Explore',
			MarketingToolboxModuleFromthecommunityService::MODULE_ID => 'Fromthecommunity',
			MarketingToolboxModulePollsService::MODULE_ID => 'Polls',
			MarketingToolboxModuleTop10listService::MODULE_ID => 'Top10list',
			MarketingToolboxModulePopularvideosService::MODULE_ID => 'Popularvideos'
		);

		$model = new MarketingToolboxModel();

		foreach ($testDatas as $moduleId => $expectedModuleName) {
			$this->assertEquals(
				$expectedModuleName,
				$model->getNotTranslatedModuleName($moduleId)
			);
		}
	}

	public function testGetAvailableSections() {
		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('msg'));

		$functionWrapperMock->expects($this->at(0))
			->method('msg')
			->with($this->equalTo('marketing-toolbox-section-hubs-button'))
			->will($this->returnValue('test name for hubs section'));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		$model = new MarketingToolboxModel($app);

		$sections = $model->getAvailableSections();
		$this->assertArrayHasKey(MarketingToolboxModel::SECTION_HUBS, $sections);
		$this->assertEquals('test name for hubs section', $sections[MarketingToolboxModel::SECTION_HUBS]);
	}

	public function testGetSectionName() {
		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('msg'));

		$functionWrapperMock->expects($this->at(0))
			->method('msg')
			->with($this->equalTo('marketing-toolbox-section-hubs-button'))
			->will($this->returnValue('test name for hubs section'));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		$model = new MarketingToolboxModel($app);

		$this->assertEquals(
			'test name for hubs section',
			$model->getSectionName(MarketingToolboxModel::SECTION_HUBS)
		);
	}

	public function testGetAvailableVerticals() {
		$model = new MarketingToolboxModel();
		$verticals = $model->getAvailableVerticals(MarketingToolboxModel::SECTION_HUBS);

		$this->assertArrayHasKey(WikiFactoryHub::CATEGORY_ID_GAMING, $verticals);
		$this->assertArrayHasKey(WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT, $verticals);
		$this->assertArrayHasKey(WikiFactoryHub::CATEGORY_ID_LIFESTYLE, $verticals);
	}

	public function testGetModuleUrl() {
		$params = array(
			'moduleId' => MarketingToolboxModulePulseService::MODULE_ID,
			'date' => 123456,
			'region' => 'pl',
			'verticalId' => WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
			'sectionId' => MarketingToolboxModel::SECTION_HUBS
		);

		$titleMock = $this->getMock('Title', array('getLocalURL'));
		$titleMock->expects($this->once())
			->method('getLocalURL')
			->with($this->equalTo($params))
			->will($this->returnValue('test returned url'));

		$specialPageMock = $this->getMock('SpecialPage', array('getTitleFor'));

		$specialPageMock->staticExpects($this->once())
			->method('getTitleFor')
			->with(
			$this->equalTo('MarketingToolbox'),
			$this->equalTo('editHub')
		)
			->will($this->returnValue($titleMock));

		$model = new MarketingToolboxModel();
		$model->setSpecialPageClass($specialPageMock);

		$url = $model->getModuleUrl(
			$params['region'],
			$params['sectionId'],
			$params['verticalId'],
			$params['date'],
			$params['moduleId']
		);

		$this->assertEquals('test returned url', $url);
	}

	public function testGetModulesDataFromDefault() {
		$params = array(
			'langCode' => 'pl',
			'sectionId' => MarketingToolboxModel::SECTION_HUBS,
			'verticalId' => WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
			'timestamp' => 789654,
			'activeModule' => MarketingToolboxModuleWikiaspicksService::MODULE_ID
		);

		// Mock database
		$dbMock = $this->getMock('DatabaseMysql', array('selectField', 'makeList'));
		$dbMock->expects($this->once())
			->method('selectField')
			->will($this->returnValue(0));
		$dbMock->expects($this->any())
			->method('makeList')
			->will($this->returnValue(''));

		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('GetDB'));

		$functionWrapperMock->expects($this->any())
			->method('GetDB')
			->will($this->returnValue($dbMock));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		// Mock model
		$modelMock = $this->getMock('MarketingToolboxModel', array('getModulesDataFromDb', 'getModuleUrl'), array($app));

		$modelMock->expects($this->once())
			->method('getModulesDataFromDb')
			->with(
			$this->equalTo($params['langCode']),
			$this->equalTo($params['sectionId']),
			$this->equalTo($params['verticalId']),
			$this->equalTo($params['timestamp'])
		)
			->will($this->returnValue(array()));

		$modelMock->expects($this->any())
			->method('getModuleUrl')
			->will($this->returnValue('test href'));

		$modulesData = $modelMock->getModulesData(
			$params['langCode'],
			$params['sectionId'],
			$params['verticalId'],
			$params['timestamp'],
			$params['activeModule']
		);

		// make assert
		$this->assertArrayHasKey('lastEditTime', $modulesData);
		$this->assertArrayHasKey('lastEditor', $modulesData);
		$this->assertArrayHasKey('moduleList', $modulesData);
		$this->assertArrayHasKey('activeModuleName', $modulesData);

		$this->assertNull($modulesData['lastEditTime']);
		$this->assertNull($modulesData['lastEditor']);
		$this->assertNotNull($modulesData['activeModuleName']);
		$this->assertEquals(9, count($modulesData['moduleList']));

		foreach ($modulesData['moduleList'] as $module) {
			$this->assertArrayHasKey('status', $module);
			$this->assertArrayHasKey('data', $module);
			$this->assertArrayHasKey('lastEditTime', $module);
			$this->assertArrayHasKey('lastEditorId', $module);
			$this->assertArrayHasKey('name', $module);
			$this->assertArrayHasKey('href', $module);

			$this->assertEquals(1, $module['status']);
			$this->assertNull($module['lastEditTime']);
			$this->assertNull($module['lastEditorId']);
			$this->assertEquals(array(), $module['data']);
			$this->assertNotNull($module['name']);
			$this->assertEquals('test href', $module['href']);
		}
	}

	public function testGetModulesDataWithoutDefaults() {
		$params = array(
			'langCode' => 'pl',
			'sectionId' => MarketingToolboxModel::SECTION_HUBS,
			'verticalId' => WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
			'timestamp' => 789654,
			'activeModule' => MarketingToolboxModuleWikiaspicksService::MODULE_ID
		);
		$lastPublishTimestamp = 66789;
		$lastEditorName = 'test UserName';

		$mockDataForModule = array(
			'status' => 1,
			'lastEditTime' => 123654,
			'lastEditorId' => 666,
			'data' => array('test variable' => 'eight')
		);
		$mockDataForLastModule = array(
			'status' => 1,
			'lastEditTime' => 98745658,
			'lastEditorId' => 123,
			'data' => array('second test variable' => 'variable')
		);

		$mockedModulesData = array();
		for ($i = 1; $i < 9; $i++) {
			$mockedModulesData[$i] = $mockDataForModule;
		}
		$mockedModulesData[9] = $mockDataForLastModule;


		// Mock database
		$dbMock = $this->getMock('DatabaseMysql', array('selectField', 'makeList'));
		$dbMock->expects($this->once())
			->method('selectField')
			->will($this->returnValue($lastPublishTimestamp));
		$dbMock->expects($this->any())
			->method('makeList')
			->will($this->returnValue(''));

		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('GetDB'));

		$functionWrapperMock->expects($this->any())
			->method('GetDB')
			->will($this->returnValue($dbMock));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		// User Mock
		$userMock = $this->getMock(
			'User',
			array('newFromId', 'getName')
		);
		$userMock->expects($this->once())
			->method('getName')
			->will($this->returnValue($lastEditorName));

		$userMock->staticExpects($this->once())
			->method('newFromId')
			->will($this->returnValue($userMock));

		// Mock model
		$modelMock = $this->getMock(
			'MarketingToolboxModel',
			array('getModulesDataFromDb', 'getModuleUrl', 'getDefaultModuleList'),
			array($app)
		);

		$modelMock->expects($this->at(0))
			->method('getModulesDataFromDb')
			->with(
			$this->equalTo($params['langCode']),
			$this->equalTo($params['sectionId']),
			$this->equalTo($params['verticalId']),
			$this->equalTo($lastPublishTimestamp)
		)
			->will($this->returnValue($mockedModulesData));
		$modelMock->expects($this->at(1))
			->method('getModulesDataFromDb')
			->with(
			$this->equalTo($params['langCode']),
			$this->equalTo($params['sectionId']),
			$this->equalTo($params['verticalId']),
			$this->equalTo($params['timestamp'])
		)
			->will($this->returnValue(
			array()
		));

		$modelMock->expects($this->any())
			->method('getModuleUrl')
			->will($this->returnValue('test href'));

		$modelMock->expects($this->exactly(0))
			->method('getDefaultModuleList');

		$modelMock->setUserClass($userMock);

		$modulesData = $modelMock->getModulesData(
			$params['langCode'],
			$params['sectionId'],
			$params['verticalId'],
			$params['timestamp'],
			$params['activeModule']
		);

		// make assert
		$this->assertArrayHasKey('lastEditTime', $modulesData);
		$this->assertArrayHasKey('lastEditor', $modulesData);
		$this->assertArrayHasKey('moduleList', $modulesData);
		$this->assertArrayHasKey('activeModuleName', $modulesData);

		$this->assertEquals(123654, $modulesData['lastEditTime']);
		$this->assertEquals($lastEditorName, $modulesData['lastEditor']);
		$this->assertNotNull($modulesData['activeModuleName']);
		$this->assertEquals(9, count($modulesData['moduleList']));

		for ($i = 1; $i < 9; $i++) {
			$module = $modulesData['moduleList'][$i];

			$this->assertArrayHasKey('status', $module);
			$this->assertArrayHasKey('data', $module);
			$this->assertArrayHasKey('lastEditTime', $module);
			$this->assertArrayHasKey('lastEditorId', $module);
			$this->assertArrayHasKey('name', $module);
			$this->assertArrayHasKey('href', $module);

			$this->assertEquals(1, $module['status']);
			$this->assertEquals($mockDataForModule['lastEditTime'], $module['lastEditTime']);
			$this->assertEquals($mockDataForModule['lastEditorId'], $module['lastEditorId']);
			$this->assertEquals($mockDataForModule['data'], $module['data']);
			$this->assertNotNull($module['name']);
			$this->assertEquals('test href', $module['href']);
		}

		$module = $modulesData['moduleList'][9];

		$this->assertArrayHasKey('status', $module);
		$this->assertArrayHasKey('data', $module);
		$this->assertArrayHasKey('lastEditTime', $module);
		$this->assertArrayHasKey('lastEditorId', $module);
		$this->assertArrayHasKey('name', $module);
		$this->assertArrayHasKey('href', $module);

		$this->assertEquals(1, $module['status']);
		$this->assertEquals($mockDataForLastModule['lastEditTime'], $module['lastEditTime']);
		$this->assertEquals($mockDataForLastModule['lastEditorId'], $module['lastEditorId']);
		$this->assertEquals($mockDataForLastModule['data'], $module['data']);
		$this->assertNotNull($module['name']);
		$this->assertEquals('test href', $module['href']);
	}

	/**
	 * Test saving module when there is no data
	 */
	public function testSaveModuleInsert() {

		$dataToInsert = array(
			'lang' => 'pl',
			'sectionId' => MarketingToolboxModel::SECTION_HUBS,
			'verticalId' => WikiFactoryHub::CATEGORY_ID_GAMING,
			'timestamp' => 1234567,
			'moduleId' => MarketingToolboxModulePollsService::MODULE_ID,
			'data' => array('test1' => 'test2', 'hola hola' => 'espaniola'),
			'editorId' => 666
		);

		$dbMock = $this->getMock('DatabaseMysql', array('selectField', 'insert'));
		$dbMock->expects($this->once())
			->method('selectField')
			->will($this->returnValue(0));

		$dbMock->expects($this->once())
			->method('insert')
			->with(
			$this->equalTo(MarketingToolboxModel::HUBS_TABLE_NAME),
			$this->equalTo(
				array(
					'module_data' => json_encode($dataToInsert['data']),
					'last_editor_id' => $dataToInsert['editorId'],
					'lang_code' => $dataToInsert['lang'],
					'vertical_id' => $dataToInsert['verticalId'],
					'module_id' => $dataToInsert['moduleId'],
					'hub_date' => $dbMock->timestamp($dataToInsert['timestamp'])
				)
			)
		);

		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('GetDB'));

		$functionWrapperMock->expects($this->any())
			->method('GetDB')
			->will($this->returnValue($dbMock));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		$model = new MarketingToolboxModel($app);

		$model->saveModule(
			$dataToInsert['lang'],
			$dataToInsert['sectionId'],
			$dataToInsert['verticalId'],
			$dataToInsert['timestamp'],
			$dataToInsert['moduleId'],
			$dataToInsert['data'],
			$dataToInsert['editorId']
		);

	}

	/**
	 * Test saving module when there is data already saved
	 */
	public function testSaveModuleUpdate() {

		$dataToInsert = array(
			'lang' => 'pl',
			'sectionId' => MarketingToolboxModel::SECTION_HUBS,
			'verticalId' => WikiFactoryHub::CATEGORY_ID_GAMING,
			'timestamp' => 1234567,
			'moduleId' => MarketingToolboxModulePollsService::MODULE_ID,
			'data' => array('test1' => 'test2', 'hola hola' => 'espaniola'),
			'editorId' => 666
		);

		$dbMock = $this->getMock('DatabaseMysql', array('selectField', 'update'));
		$dbMock->expects($this->once())
			->method('selectField')
			->will($this->returnValue(1));

		$dbMock->expects($this->once())
			->method('update')
			->with(
			$this->equalTo(MarketingToolboxModel::HUBS_TABLE_NAME),
			$this->equalTo(
				array(
					'module_data' => json_encode($dataToInsert['data']),
					'last_editor_id' => $dataToInsert['editorId']
				)
			),
			$this->equalTo(
				array(
					'lang_code' => $dataToInsert['lang'],
					'vertical_id' => $dataToInsert['verticalId'],
					'module_id' => $dataToInsert['moduleId'],
					'hub_date' => $dbMock->timestamp($dataToInsert['timestamp'])
				)
			)
		);

		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('GetDB'));

		$functionWrapperMock->expects($this->any())
			->method('GetDB')
			->will($this->returnValue($dbMock));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		$model = new MarketingToolboxModel($app);

		$model->saveModule(
			$dataToInsert['lang'],
			$dataToInsert['sectionId'],
			$dataToInsert['verticalId'],
			$dataToInsert['timestamp'],
			$dataToInsert['moduleId'],
			$dataToInsert['data'],
			$dataToInsert['editorId']
		);

	}

	/**
	 * @dataProvider extractTitleFromVETWikitextDataProvider
	 */
	public function testExtractTitleFromVETWikitext($wikiText, $expFileName) {
		$model = new MarketingToolboxModel();
		$actualResult = $model->extractTitleFromVETWikitext($wikiText);
		$this->assertEquals($expFileName, $actualResult);
	}

	public function extractTitleFromVETWikitextDataProvider() {
		return array(
			array(
				'[[File:Batman - Following|thumb|right|335 px]]',
				'Batman - Following'
			),
			array(
				'[[Grafika:Batman - Following|thumb|right|335 px]]',
				'Batman - Following'
			),
			array(
				'File:Batman - Following|thumb|right|335 px',
				'Batman - Following'
			),
			array(
				'Grafika:Batman - Following|thumb|right|335 px',
				'Batman - Following'
			),
			array(
				'[[Batman - Following|thumb|right|335 px]]',
				false
			),
		);
	}

	public function testGetDataPublished() {
		$model = new MarketingToolboxModel();

		$statuses = $model->getAvailableStatuses();
		$selectData = array(
			array(
				'hub_date' => '2012-12-25',
				'module_status' => $statuses['PUBLISHED'],
			)
		);

		$dbMock = $this->getMock('DatabaseMysql', array('makeList', 'select', 'fetchRow'));

		$dbMock->expects($this->any())
			->method('makeList')
			->will($this->returnValue(''));

		$dbMock->expects($this->at(2))
			->method('fetchRow')
			->will($this->returnValue($selectData[0]));

		$dbMock->expects($this->at(3))
			->method('fetchRow')
			->will($this->returnValue(false));

		$dbMock->expects($this->once())
			->method('select')
			->will($this->returnValue(array()));

		$this->mockGlobalFunction('GetDB', $dbMock);
		$this->mockApp();

		// create object second time to use mocked F:app()
		$model = new MarketingToolboxModel();


		$data = $model->getCalendarData('en', 2, 1351728000, 1364774400);

		$this->assertArrayHasKey('2012-12-25', $data);
		$this->assertEquals($statuses['PUBLISHED'], $data['2012-12-25']);
	}

	public function testGetCalendarDataNotPublished() {
		$model = new MarketingToolboxModel();

		$statuses = $model->getAvailableStatuses();
		$selectData = array(
			array(
				'hub_date' => '2012-12-25',
				'module_status' => $statuses['NOT_PUBLISHED'],
			)
		);

		$dbMock = $this->getMock('DatabaseMysql', array('makeList', 'select', 'fetchRow'));

		$dbMock->expects($this->any())
			->method('makeList')
			->will($this->returnValue(''));

		$dbMock->expects($this->at(2))
			->method('fetchRow')
			->will($this->returnValue($selectData[0]));

		$dbMock->expects($this->at(3))
			->method('fetchRow')
			->will($this->returnValue(false));

		$dbMock->expects($this->once())
			->method('select')
			->will($this->returnValue(array()));

		$this->mockGlobalFunction('GetDB', $dbMock);
		$this->mockApp();

		// create object second time to use mocked F:app()
		$model = new MarketingToolboxModel();


		$data = $model->getCalendarData('en', 2, 1351728000, 1364774400);

		$this->assertArrayHasKey('2012-12-25', $data);
		$this->assertEquals($statuses['NOT_PUBLISHED'], $data['2012-12-25']);
	}

	public function testGetCalendarDataEmptyData() {

		$dbMock = $this->getMock('DatabaseMysql', array('makeList', 'select', 'fetchRow'));

		$dbMock->expects($this->any())
			->method('makeList')
			->will($this->returnValue(''));

		$dbMock->expects($this->at(2))
			->method('fetchRow')
			->will($this->returnValue(false));

		$dbMock->expects($this->once())
			->method('select')
			->will($this->returnValue(array()));

		$this->mockGlobalFunction('GetDB', $dbMock);
		$this->mockApp();

		$model = new MarketingToolboxModel();

		$data = $model->getCalendarData('en', 2, 1351728000, 1364774400);

		$this->assertEmpty($data);
	}

	public function testGetCalendarDataComplex() {
		$model = new MarketingToolboxModel();

		$statuses = $model->getAvailableStatuses();
		$selectData = array(
			array(
				'hub_date' => '2012-12-25',
				'module_status' => $statuses['PUBLISHED'],
			),
			array(
				'hub_date' => '2013-01-05',
				'module_status' => $statuses['NOT_PUBLISHED'],
			),
			array(
				'hub_date' => '2013-01-08',
				'module_status' => $statuses['NOT_PUBLISHED'],
			)
		);

		$dbMock = $this->getMock('DatabaseMysql', array('makeList', 'select', 'fetchRow'));

		$dbMock->expects($this->any())
			->method('makeList')
			->will($this->returnValue(''));

		$dbMock->expects($this->at(2))
			->method('fetchRow')
			->will($this->returnValue($selectData[0]));

		$dbMock->expects($this->at(3))
			->method('fetchRow')
			->will($this->returnValue($selectData[1]));

		$dbMock->expects($this->at(4))
			->method('fetchRow')
			->will($this->returnValue($selectData[2]));

		$dbMock->expects($this->at(5))
			->method('fetchRow')
			->will($this->returnValue(false));

		$dbMock->expects($this->once())
			->method('select')
			->will($this->returnValue(array()));

		$this->mockGlobalFunction('GetDB', $dbMock);
		$this->mockApp();

		// create object second time to use mocked F:app()
		$model = new MarketingToolboxModel();


		$data = $model->getCalendarData('en', 2, 1351728000, 1364774400);

		$this->assertArrayHasKey('2012-12-25', $data);
		$this->assertArrayHasKey('2013-01-05', $data);
		$this->assertArrayHasKey('2013-01-08', $data);
		$this->assertEquals($statuses['PUBLISHED'], $data['2012-12-25']);
		$this->assertEquals($statuses['NOT_PUBLISHED'], $data['2013-01-05']);
		$this->assertEquals($statuses['NOT_PUBLISHED'], $data['2013-01-08']);
	}

}