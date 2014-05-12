<?php
require_once __DIR__ . '/../../api/WikiaHubsApiController.class.php';

class WikiaHubsApiControllerTest extends WikiaBaseTest {
	const WIKIAREQUEST_DEFAULT_VALUE = 0;
	
	protected $modulesIds = array(1, 2, 3);
	protected $verticalIds = array(4, 5, 6);



	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		require_once(dirname(__FILE__) . '/../../../WikiaHubsServices/WikiaHubsServices.setup.php');
		parent::setUp();
	}

	/**
	 * @dataProvider getModuleDataV2ExceptionsProvider
	 */
	public function testGetModuleDataV2Exceptions($requestParams, $exceptionDetailsMsg) {
		$requestGetIntMap = array(
			array(
				WikiaHubsApiController::PARAMETER_MODULE,
				self::WIKIAREQUEST_DEFAULT_VALUE,
				$requestParams[WikiaHubsApiController::PARAMETER_MODULE],
			),
			array(
				WikiaHubsApiController::PARAMETER_VERTICAL,
				self::WIKIAREQUEST_DEFAULT_VALUE,
				$requestParams[WikiaHubsApiController::PARAMETER_VERTICAL]
			),
			array(
				WikiaHubsApiController::PARAMETER_TIMESTAMP,
				self::WIKIAREQUEST_DEFAULT_VALUE,
				$requestParams[WikiaHubsApiController::PARAMETER_TIMESTAMP],
			),
		);

		$requestMock = $this->getMock('WikiaRequest', array('getInt', 'getVal'), array(), '', false);
		$requestMock->expects($this->any())
			->method('getInt')
			->will($this->returnValueMap($requestGetIntMap));
		$requestMock->expects($this->once())
			->method('getVal')
			->with($this->equalTo(WikiaHubsApiController::PARAMETER_LANG))
			->will($this->returnValue('en'));
		
		$modelMock = $this->getMock('MarketingToolboxModel', array('getModulesIds', 'getVerticalsIds'));
		$modelMock->expects($this->any())
			->method('getModulesIds')
			->will($this->returnValue($this->modulesIds));
		$modelMock->expects($this->any())
			->method('getVerticalsIds')
			->will($this->returnValue($this->verticalIds));
		
		$apiMock = $this->getMock('WikiaHubsApiController', array('getModel'));
		$apiMock->expects($this->once())
			->method('getModel')
			->will($this->returnValue($modelMock));
		$apiMock->setRequest($requestMock);
		
		try {
			$apiMock->getModuleDataV2();
			$this->fail('We expected an exception here...');
		} catch( Exception $e ) {
			$this->assertEquals($exceptionDetailsMsg, $e->getDetails());
		}
	}
	
	public function getModuleDataV2ExceptionsProvider() {
		return array(
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => null,
					WikiaHubsApiController::PARAMETER_VERTICAL => 4,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 1359676800,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_MODULE),
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 1,
					WikiaHubsApiController::PARAMETER_VERTICAL => null,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 1359676800,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_VERTICAL),
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 2,
					WikiaHubsApiController::PARAMETER_VERTICAL => 5,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => null,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_TIMESTAMP),
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 0,
					WikiaHubsApiController::PARAMETER_VERTICAL => 6,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 1359676800,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_MODULE),
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 3,
					WikiaHubsApiController::PARAMETER_VERTICAL => 0,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 1359676800,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_VERTICAL),
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 3,
					WikiaHubsApiController::PARAMETER_VERTICAL => 6,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 0,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_TIMESTAMP),
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 3,
					WikiaHubsApiController::PARAMETER_VERTICAL => 6,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => time() + rand(),
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_TIMESTAMP),
			),
		);
	}

	/**
	 * @dataProvider getModuleDataV3ExceptionsProvider
	 */
	public function testGetModuleDataV3Exceptions($requestParams, $exceptionDetailsMsg, $isValidCityId) {
		$requestGetIntMap = array(
			array(
				WikiaHubsApiController::PARAMETER_MODULE,
				self::WIKIAREQUEST_DEFAULT_VALUE,
				$requestParams[WikiaHubsApiController::PARAMETER_MODULE],
			),
			array(
				WikiaHubsApiController::PARAMETER_CITY,
				self::WIKIAREQUEST_DEFAULT_VALUE,
				$requestParams[WikiaHubsApiController::PARAMETER_CITY]
			),
			array(
				WikiaHubsApiController::PARAMETER_TIMESTAMP,
				self::WIKIAREQUEST_DEFAULT_VALUE,
				$requestParams[WikiaHubsApiController::PARAMETER_TIMESTAMP],
			),
		);

		$requestMock = $this->getMock('WikiaRequest', array('getInt'), array(), '', false);
		$requestMock->expects($this->any())
			->method('getInt')
			->will($this->returnValueMap($requestGetIntMap));

		$modelMock = $this->getMock('MarketingToolboxV3Model', array('getModulesIds'));
		$modelMock->expects($this->any())
			->method('getModulesIds')
			->will($this->returnValue($this->modulesIds));

		$apiMock = $this->getMock('WikiaHubsApiController', array('getModelV3', 'isValidCity'));
		$apiMock->expects($this->once())
			->method('getModelV3')
			->will($this->returnValue($modelMock));
		$apiMock->expects($this->any())
			->method('isValidCity')
			->will($this->returnValue($isValidCityId));
		$apiMock->setRequest($requestMock);

		try {
			$apiMock->getModuleDataV3();
			$this->fail('We expected an exception here...');
		} catch( Exception $e ) {
			$this->assertEquals($exceptionDetailsMsg, $e->getDetails());
		}
	}

	public function getModuleDataV3ExceptionsProvider() {
		return array(
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => null,
					WikiaHubsApiController::PARAMETER_CITY => 1,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 1359676800,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_MODULE),
				'isValidCityId' => true,
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 1,
					WikiaHubsApiController::PARAMETER_CITY => null,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 1359676800,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_CITY),
				'isValidCityId' => false,
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 2,
					WikiaHubsApiController::PARAMETER_CITY => 2,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => null,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_TIMESTAMP),
				'isValidCityId' => true,
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 0,
					WikiaHubsApiController::PARAMETER_CITY => 3,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 1359676800,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_MODULE),
				'isValidCityId' => true,
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 3,
					WikiaHubsApiController::PARAMETER_CITY => 0,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 1359676800,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_CITY),
				'isValidCityId' => false,
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 3,
					WikiaHubsApiController::PARAMETER_CITY => 2,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => 0,
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_TIMESTAMP),
				'isValidCityId' => true,
			),
			array(
				'requestParams' => array(
					WikiaHubsApiController::PARAMETER_MODULE => 3,
					WikiaHubsApiController::PARAMETER_CITY => 2,
					WikiaHubsApiController::PARAMETER_TIMESTAMP => time() + rand(),
				),
				'exceptionDetailsMsg' => InvalidParameterApiException::getDetailsMsg(WikiaHubsApiController::PARAMETER_TIMESTAMP),
				'isValidCityId' => true,
			),
		);
	}
}
