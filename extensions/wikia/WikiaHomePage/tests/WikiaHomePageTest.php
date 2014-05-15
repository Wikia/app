<?php
require_once __DIR__ . '/../WikiaHomePage.setup.php';
require_once __DIR__ . '/../../WikiaHubsServices/WikiaHubsServicesHelper.class.php';
require_once __DIR__ . '/../../CityVisualization/CityVisualization.setup.php' ;

class WikiaHomePageTest extends WikiaBaseTest {
	const TEST_CITY_ID = 80433;
	const TEST_URL = 'http://testing';
	const TEST_MEMBER_DATE = 'Jun 2005';
	const MOCK_FILE_URL = 'Mock file URL';
	const BLANK_IMG_URL = 'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D';

	protected $wgServerOrg = null;

	protected function setUp() {
		parent::setUp();

		$this->mockStaticMethod( 'AvatarService', 'getAvatarUrl', null );
	}

	protected function setUpMock($cacheParams = null) {
		// mock cache
		$memcParams = array(
			'set' => null,
			'get' => null,
		);
		if (is_array($cacheParams)) {
			$memcParams = $memcParams + $cacheParams;
		}
		$this->setUpMockObject('stdClass', $memcParams, false, 'wgMemc');

		$this->mockGlobalVariable('wgCityId', self::TEST_CITY_ID);
	}

	protected function setUpMockObject($objectName, $objectParams = null, $needSetInstance = false, $globalVarName = null, $callOriginalConstructor = true, $globalFunc = array()) {
		$mockObject = $objectParams;
		if (is_array($objectParams)) {
			// extract params from methods
			$objectValues = array(); // $objectValues is stored in $objectParams[params]
			$methodParams = array();
			foreach ($objectParams as $key => $value) {
				if ($key == 'params' && !empty($value)) {
					$objectValues = array($value);
				} else {
					$methodParams[$key] = $value;
				}
			}
			$methods = array_keys($methodParams);

			// call original contructor or not
			if ($callOriginalConstructor) {
				$mockObject = $this->getMock($objectName, $methods, $objectValues);
			} else {
				$mockObject = $this->getMock($objectName, $methods, $objectValues, '', false);
			}

			foreach ($methodParams as $method => $value) {
				if ($value === null) {
					$mockObject->expects($this->any())
						->method($method);
				} else {
					if (is_array($value) && array_key_exists('mockExpTimes', $value) && array_key_exists('mockExpValues', $value)) {
						if ($value['mockExpValues'] == null) {
							$mockObject->expects($this->exactly($value['mockExpTimes']))
								->method($method);
						} else {
							$mockObject->expects($this->exactly($value['mockExpTimes']))
								->method($method)
								->will($this->returnValue($value['mockExpValues']));

						}
					} else {
						$mockObject->expects($this->any())
							->method($method)
							->will($this->returnValue($value));
					}
				}
			}
		}

		// mock global variable
		if (!empty($globalVarName)) {
			$this->mockGlobalVariable($globalVarName, $mockObject);
		}

		// mock global function
		if (!empty($globalFunc)) {
			$this->getGlobalFunctionMock( $globalFunc['name'] )
				->expects( $this->exactly( $globalFunc['time'] ) )
				->method( $globalFunc['name'] )
				->will( $this->returnValue( $mockObject ) );
		}

		// set instance
		if ($needSetInstance) {
			$this->mockClassEx($objectName, $mockObject);
		}
		return $mockObject;
	}


	/**
	 * @group Slow
	 * @slowExecutionTime 0.053 ms
	 */
	public function testGetList() {
		$this->markTestSkipped('This test needs to be rewritten to serve its purpose');
		$this->setUpMock();

		$wikiaHomePageHelperStub = $this->getMock(
			'WikiaHomePageHelper',
			array('getVarFromWikiFactory'));
		$wikiaHomePageHelperStub->expects($this->any())->method('getVarFromWikiFactory')->will($this->returnValue(5));

		$this->mockClass('WikiaHomePageHelper', $wikiaHomePageHelperStub);

		$visualizationStub = $this->getMock(
			'CityVisualization',
			array('getList'));
		$visualizationStub->expects($this->any())->method('getList')->will($this->returnValue(array()));
		$this->mockClass('CityVisualization', $visualizationStub);

		//2nd failover
		$response = $this->app->sendRequest('WikiaHomePageController', 'getList', array());
		$status = $response->getVal('wgWikiaBatchesStatus');
		$failoverData = $response->getVal('initialWikiBatchesForVisualization');

		$this->assertEquals('false', $status);
		$this->assertNotEmpty($failoverData);

		$wikiaHomePageControllerStub = $this->getMock('WikiaHomePageController', array('getMediaWikiMessage'));
		$mediaWikiMsgMock = <<<TXT
*Video Games
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
**A video games wiki|http://a-video-games-wiki.wikia.com|image|description
*Entertainment
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
**An entertainment wiki|http://an-entertainment-wiki.wikia.com|image|description
*Lifestyle
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
**A lifestyle wiki|http://a-lifestyle-wiki.wikia.com|image|description
TXT;
		$wikiaHomePageControllerStub->expects($this->any())->method('getMediaWikiMessage')->will($this->returnValue($mediaWikiMsgMock));
		$this->mockClass('WikiaHomePageController', $wikiaHomePageControllerStub);

		$response = $this->app->sendRequest('WikiaHomePageController', 'getList', array());
		$status = $response->getVal('wgWikiaBatchesStatus');
		$exception = $response->getVal('exception');
		$receivedData = $response->getVal('initialWikiBatchesForVisualization');
		$receivedData = json_decode($receivedData);
		asort($receivedData);

		$expectedData = '[{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]}]';
		$expectedData = json_decode($expectedData);
		asort($expectedData);

		//1st failover
		$this->assertEquals(
			array(
				'status' => 'false',
				'exception' => '',
				'failoverData' => $expectedData
			),
			array(
				'status' => $status,
				'exception' => $exception,
				'failoverData' => $failoverData
			)
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.05252 ms
	 * @dataProvider getProcessedWikisImgSizesDataProvider
	 */
	public function testGetProcessedWikisImgSizes($slotName, $width, $height) {
		$whh = new WikiaHomePageHelper();
		$size = $whh->getProcessedWikisImgSizes($slotName);

		$this->assertEquals($width, $size->width);
		$this->assertEquals($height, $size->height);
	}

	public function getProcessedWikisImgSizesDataProvider() {
		$whh = new WikiaHomePageHelper();
		return array(
			array(WikiaHomePageHelper::SLOTS_BIG_ARRAY_KEY, $whh->getRemixBigImgWidth(), $whh->getRemixBigImgHeight()),
			array(WikiaHomePageHelper::SLOTS_MEDIUM_ARRAY_KEY, $whh->getRemixMediumImgWidth(), $whh->getRemixMediumImgHeight()),
			array(WikiaHomePageHelper::SLOTS_SMALL_ARRAY_KEY, $whh->getRemixSmallImgWidth(), $whh->getRemixSmallImgHeight()),
			array(666, $whh->getRemixBigImgWidth(), $whh->getRemixBigImgHeight()),
		);
	}

}
