<?

class MarketingToolboxModelTest extends WikiaBaseTest {

	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../SpecialMarketingToolbox.setup.php';
		parent::setUp();
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
			'moduleId' => MarketingToolboxModel::MODULE_POLLS,
			'data' => array('test1' => 'test2', 'hola hola' => 'espaniola'),
			'editorId' => 666
		);

		$model = new MarketingToolboxModel();

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

		$model->setApp($app);

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
			'moduleId' => MarketingToolboxModel::MODULE_POLLS,
			'data' => array('test1' => 'test2', 'hola hola' => 'espaniola'),
			'editorId' => 666
		);

		$model = new MarketingToolboxModel();

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
			)
		);

		$functionWrapperMock = $this->getMock('WikiaFunctionWrapper', array('GetDB'));

		$functionWrapperMock->expects($this->any())
			->method('GetDB')
			->will($this->returnValue($dbMock));

		$app = new WikiaApp(null, null, null, $functionWrapperMock);

		$model->setApp($app);

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
}