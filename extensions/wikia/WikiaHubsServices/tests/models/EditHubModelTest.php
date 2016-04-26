<?php

class EditHubModelTest extends WikiaBaseTest {

	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05506 ms
	 */
	public function testGetModuleName() {
		$mockMsg = $this->getGlobalFunctionMock( 'wfMessage' );

		$model = new EditHubModel();

		$mockMsg->expects($this->once())
			->method('wfMessage')
			->with('wikia-hubs-module-slider')
			->will($this->returnValue('testNameFor slider'));

		$this->assertEquals(
			'testNameFor slider',
			$model->getModuleName(WikiaHubsModuleSliderService::MODULE_ID)
		);
	}

	public function testGetNotTranslatedModuleName() {
		$testDatas = array(
			WikiaHubsModuleSliderService::MODULE_ID => 'Slider',
			WikiaHubsModuleWikiaspicksService::MODULE_ID => 'Wikiaspicks',
			WikiaHubsModuleFeaturedvideoService::MODULE_ID => 'Featuredvideo',
			WikiaHubsModuleExploreService::MODULE_ID => 'Explore',
			WikiaHubsModuleFromthecommunityService::MODULE_ID => 'Fromthecommunity',
			WikiaHubsModulePollsService::MODULE_ID => 'Polls',
			WikiaHubsModulePopularvideosService::MODULE_ID => 'Popularvideos'
		);

		$model = new EditHubModel();

		foreach ($testDatas as $moduleId => $expectedModuleName) {
			$this->assertEquals(
				$expectedModuleName,
				$model->getNotTranslatedModuleName($moduleId)
			);
		}
	}

	/**
	 * @group Broken
	 */
	public function testGetModuleUrl() {
		$params = array(
			'moduleId' => WikiaHubsModuleSliderService::MODULE_ID,
			'date' => 123456,
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
			$this->equalTo('EditHub'),
			$this->equalTo('editHub')
		)
			->will($this->returnValue($titleMock));

		$model = new EditHubModel();
		$model->setSpecialPageClass($specialPageMock);

		$url = $model->getModuleUrl( $params['date'], $params['moduleId']
		);

		$this->assertEquals('test returned url', $url);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.01248 ms
	 */
	public function testGetModulesDataFromDefault() {
		$moduleParams = array(
			'cityId' => 1213456,
			'timestamp' => 789654,
			'activeModule' => WikiaHubsModuleWikiaspicksService::MODULE_ID
		);

		// Mock database
		$dbMock = $this->getDatabaseMock(array('makeList'));
		$dbMock->expects($this->any())
			->method('makeList')
			->will($this->returnValue(''));

		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('GetDB'));

		$functionWrapperMock->expects($this->any())
			->method('GetDB')
			->will($this->returnValue($dbMock));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		// Mock model
		$modelMock = $this->getMock('EditHubModel', array('getModulesDataFromDb', 'getModuleUrl', 'getLastPublishedTimestamp'), array($app));

		$modelMock->expects($this->once())
			->method('getModulesDataFromDb')
			->with(
			$this->equalTo($moduleParams['cityId']),
			$this->equalTo($moduleParams['timestamp'])
		)
			->will($this->returnValue(array()));

		$modelMock->expects($this->any())
			->method('getModuleUrl')
			->will($this->returnValue('test href'));

		$modelMock->expects($this->any())
			->method('getLastPublishedTimestamp')
			->will($this->returnValue(0));

		$modulesData = $modelMock->getModulesData(
			$moduleParams['cityId'],
			$moduleParams['timestamp'],
			$moduleParams['activeModule']
		);

		// make assert
		$this->assertArrayHasKey('lastEditTime', $modulesData);
		$this->assertArrayHasKey('lastEditor', $modulesData);
		$this->assertArrayHasKey('moduleList', $modulesData);
		$this->assertArrayHasKey('activeModuleName', $modulesData);

		$this->assertNull($modulesData['lastEditTime']);
		$this->assertNull($modulesData['lastEditor']);
		$this->assertNotNull($modulesData['activeModuleName']);
		$this->assertEquals(7, count($modulesData['moduleList']));

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

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.01649 ms
	 */
	public function testGetModulesDataWithoutDefaults() {
		$moduleParams = array(
			'cityId' => 1213456,
			'timestamp' => 789654,
			'activeModule' => WikiaHubsModuleWikiaspicksService::MODULE_ID
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

		// Mock database
		$dbMock = $this->getDatabaseMock(array('makeList'));
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
			'EditHubModel',
			array('getModulesDataFromDb', 'getModuleUrl', 'getDefaultModuleList', 'getLastPublishedTimestamp'),
			array($app)
		);

		$moduleIds = $modelMock->getEditableModulesIds();

		$mockedModulesData = array();
		foreach ($moduleIds as $i) {
			$mockedModulesData[$i] = $mockDataForModule;
		}
		$mockedModulesData[9] = $mockDataForLastModule;

		$modelMock->expects($this->at(1))
			->method('getModulesDataFromDb')
			->with(
			$this->equalTo($moduleParams['cityId']),
			$this->equalTo($lastPublishTimestamp)
		)
			->will($this->returnValue($mockedModulesData));
		$modelMock->expects($this->at(2))
			->method('getModulesDataFromDb')
			->with(
			$this->equalTo($moduleParams['cityId']),
			$this->equalTo($moduleParams['timestamp'])
		)
			->will($this->returnValue(
			array()
		));

		$modelMock->expects($this->any())
			->method('getModuleUrl')
			->will($this->returnValue('test href'));

		$modelMock->expects($this->any())
			->method('getLastPublishedTimestamp')
			->will($this->returnValue($lastPublishTimestamp));

		$modelMock->expects($this->exactly(0))
			->method('getDefaultModuleList');

		$modelMock->setUserClass($userMock);

		$modulesData = $modelMock->getModulesData(
			$moduleParams['cityId'],
			$moduleParams['timestamp'],
			$moduleParams['activeModule']
		);

		// make assert
		$this->assertArrayHasKey('lastEditTime', $modulesData);
		$this->assertArrayHasKey('lastEditor', $modulesData);
		$this->assertArrayHasKey('moduleList', $modulesData);
		$this->assertArrayHasKey('activeModuleName', $modulesData);

		$this->assertEquals(123654, $modulesData['lastEditTime']);
		$this->assertEquals($lastEditorName, $modulesData['lastEditor']);
		$this->assertNotNull($modulesData['activeModuleName']);
		$this->assertEquals(7, count($modulesData['moduleList']));

		foreach ($moduleIds as $i) {
			if ($i == end($moduleIds)){
				continue;
			}
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
	 * @group Slow
	 * @slowExecutionTime 0.05746 ms
	 * Test saving module when there is no data
	 */
	public function testSaveModuleInsert() {
		$params = array(
			'langCode' => 'pl',
			'cityId' => 123456,
			'verticalId' => WikiFactoryHub::CATEGORY_ID_GAMING,
		);

		$dataToInsert = array(
			'lang' => $params['langCode'],
			'sectionId' => $params['sectionId'],
			'verticalId' => $params['verticalId'],
			'timestamp' => 1234567,
			'moduleId' => WikiaHubsModulePollsService::MODULE_ID,
			'data' => array('test1' => 'test2', 'hola hola' => 'espaniola'),
			'editorId' => 666
		);

		$dbMock = $this->getDatabaseMock(array('selectField', 'insert'));
		$dbMock->expects($this->once())
			->method('selectField')
			->will($this->returnValue(0));

		$dbMock->expects($this->once())
			->method('insert')
			->with(
			$this->equalTo(EditHubModel::HUBS_TABLE_NAME),
			$this->equalTo(
				array(
					'module_data' => json_encode($dataToInsert['data']),
					'last_editor_id' => $dataToInsert['editorId'],
					'lang_code' => $dataToInsert['lang'],
					'vertical_id' => $dataToInsert['verticalId'],
					'module_id' => $dataToInsert['moduleId'],
					'hub_date' => $dbMock->timestamp($dataToInsert['timestamp']),
					'city_id' => 123456
				)
			)
		);

		$mockGetDB = $this->getGlobalFunctionMock( 'wfGetDB' );

		$mockGetDB->expects($this->any())
			->method('wfGetDB')
			->will($this->returnValue($dbMock));

		$model = new EditHubModel();

		$model->saveModule(
			$params,
			$dataToInsert['timestamp'],
			$dataToInsert['moduleId'],
			$dataToInsert['data'],
			$dataToInsert['editorId']
		);

	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05797 ms
	 * Test saving module when there is data already saved
	 */
	public function testSaveModuleUpdate() {
		$params = array(
			'langCode' => 'pl',
			'cityId' => 123456,
			'verticalId' => WikiFactoryHub::CATEGORY_ID_GAMING,
		);

		$dataToInsert = array(
			'lang' => $params['langCode'],
			'sectionId' => $params['sectionId'],
			'verticalId' => $params['verticalId'],
			'timestamp' => 1234567,
			'moduleId' => WikiaHubsModulePollsService::MODULE_ID,
			'data' => array('test1' => 'test2', 'hola hola' => 'espaniola'),
			'editorId' => 666
		);

		$dbMock = $this->getDatabaseMock(array('selectField', 'update'));
		$dbMock->expects($this->once())
			->method('selectField')
			->will($this->returnValue(1));

		$dbMock->expects($this->once())
			->method('update')
			->with(
			$this->equalTo(EditHubModel::HUBS_TABLE_NAME),
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
					'hub_date' => $dbMock->timestamp($dataToInsert['timestamp']),
					'city_id' => 123456
				)
			)
		);

		$mockGetDB = $this->getGlobalFunctionMock( 'wfGetDB' );

		$mockGetDB->expects($this->any())
			->method('wfGetDB')
			->will($this->returnValue($dbMock));

		$model = new EditHubModel();

		$model->saveModule(
			$params,
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
		$model = new EditHubModel();
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

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05666 ms
	 */
	public function testGetDataPublished() {
		$model = new EditHubModel();

		$statuses = $model->getAvailableStatuses();
		$selectData = array(
			array(
				'hub_date' => '2012-12-25',
				'module_status' => $statuses['PUBLISHED'],
			)
		);

		$dbMock = $this->getDatabaseMock(array('makeList', 'select', 'fetchRow'));

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

		$this->mockGlobalFunction('wfGetDB', $dbMock);

		// create object second time to use mocked F:app()
		$model = new EditHubModel();


		$data = $model->getCalendarData('en', 2, 1351728000, 1364774400);

		$this->assertArrayHasKey('2012-12-25', $data);
		$this->assertEquals($statuses['PUBLISHED'], $data['2012-12-25']);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05577 ms
	 */
	public function testGetCalendarDataNotPublished() {
		$model = new EditHubModel();

		$statuses = $model->getAvailableStatuses();
		$selectData = array(
			array(
				'hub_date' => '2012-12-25',
				'module_status' => $statuses['NOT_PUBLISHED'],
			)
		);

		$dbMock = $this->getDatabaseMock(array('makeList', 'select', 'fetchRow'));

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

		$this->mockGlobalFunction('wfGetDB', $dbMock);

		// create object second time to use mocked F:app()
		$model = new EditHubModel();


		$data = $model->getCalendarData('en', 2, 1351728000, 1364774400);

		$this->assertArrayHasKey('2012-12-25', $data);
		$this->assertEquals($statuses['NOT_PUBLISHED'], $data['2012-12-25']);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0547 ms
	 */
	public function testGetCalendarDataEmptyData() {

		$dbMock = $this->getDatabaseMock(array('makeList', 'select', 'fetchRow'));

		$dbMock->expects($this->any())
			->method('makeList')
			->will($this->returnValue(''));

		$dbMock->expects($this->at(2))
			->method('fetchRow')
			->will($this->returnValue(false));

		$dbMock->expects($this->once())
			->method('select')
			->will($this->returnValue(array()));

		$this->mockGlobalFunction('wfGetDB', $dbMock);

		$model = new EditHubModel();

		$data = $model->getCalendarData('en', 2, 1351728000, 1364774400);

		$this->assertEmpty($data);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05753 ms
	 */
	public function testGetCalendarDataComplex() {
		$model = new EditHubModel();

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

		$dbMock = $this->getDatabaseMock(array('makeList', 'select', 'fetchRow'));

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

		$this->mockGlobalFunction('wfGetDB', $dbMock);

		// create object second time to use mocked F:app()
		$model = new EditHubModel();


		$data = $model->getCalendarData('en', 2, 1351728000, 1364774400);

		$this->assertArrayHasKey('2012-12-25', $data);
		$this->assertArrayHasKey('2013-01-05', $data);
		$this->assertArrayHasKey('2013-01-08', $data);
		$this->assertEquals($statuses['PUBLISHED'], $data['2012-12-25']);
		$this->assertEquals($statuses['NOT_PUBLISHED'], $data['2013-01-05']);
		$this->assertEquals($statuses['NOT_PUBLISHED'], $data['2013-01-08']);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05588 ms
	 * @dataProvider getDataModulesSavedDataProvider
	 */
	public function testCheckModulesSaved($savedModules, $expectedVal) {
		$dbMock = $this->getDatabaseMock(array( 'select', 'fetchRow'));

		$dbMock->expects($this->any())
			->method('fetchRow')
			->will($this->returnValue($savedModules));

		$dbMock->expects($this->once())
			->method('select')
			->will($this->returnValue(array()));

		$this->mockGlobalFunction('wfGetDB', $dbMock);

		$model = new EditHubModel();
		$returnedVal = $model->checkModulesSaved('en', '2','1360454400');

		$this->assertEquals($expectedVal, $returnedVal);
	}

	public function getDataModulesSavedDataProvider() {
		return array(
			array(
				'4', false
			),
			array(
				'7', true
			),
			array(
				'3', false
			),
			array(
				'5', false
			)
		);
	}

	private $visualizationData = array (
		'de' => array(
			'wikiId' => 111264,
			'wikiTitle' => 'Wikia Deutschland',
			'url' => 'http://de.wikia.com/',
			'db' => 'dehauptseite',
			'lang' => 'de'
		),
		'fr' => array(
			'wikiId' => 208826,
			'wikiTitle' => 'Wikia',
			'url' => 'http://fr.wikia.com/',
			'db' => 'fraccueil',
			'lang' => 'fr'
		),
		'es' => array(
			'wikiId' => 583437,
			'wikiTitle' => 'Wiki Esglobal',
			'url' => 'http://es.wikia.com/',
			'db' => 'esesglobal',
			'lang' => 'es'
		),
		'en' => array(
			'wikiId' => 80433,
			'wikiTitle' => 'Wikia',
			'url' => 'http://www.wikia.com/',
			'db' => 'wikiaglobal',
			'lang' => 'en'
		),
	);
}
