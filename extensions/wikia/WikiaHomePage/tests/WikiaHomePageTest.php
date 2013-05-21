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

		$this->mockGlobalVariable('wgWikiaHubsPages', array(
			1 => array('Lifestyle'),
			2 => array('Video_Games'),
			3 => array('Entertainment')
		));

		$this->mockApp();
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
			$this->mockGlobalFunction($globalFunc['name'], $mockObject, $globalFunc['time']);
		}

		// set instance
		if ($needSetInstance) {
			$this->mockClassEx($objectName, $mockObject);
		}
		return $mockObject;
	}

	/**
	 * @dataProvider getHubImagesDataProvider
	 */
	public function testGetHubImages($mockRawText, $mockFileParams, $mockImageServingParams, $expHubImages) {
		// setup
		$this->mockGlobalVariable('wgEnableWikiaHubsV2Ext', false);
		$this->setUpMockObject('Title', array('newFromText' => null, 'exists' => true), true);
		$this->setUpMockObject('Article', array('getRawText' => $mockRawText), true, null, false);
		$this->setUpMockObject('ImageServing', $mockImageServingParams, true, null, false);
		$mockFile = $this->setUpMockObject('File', $mockFileParams, true, null, false);

		if ($mockFileParams['exists']) {
			$mockFindFile = $this->getGlobalFunctionMock( 'wfFindFile' );
			$mockFindFile->expects( $this->any() )
				->method( 'wfFindFile' )
				->will( $this->returnValue( $mockFile ) );
		}
		$this->setUpMock();

		// test
		$response = $this->app->sendRequest('WikiaHomePage', 'getHubImages');

		$responseData = $response->getVal('hubImages');
		$this->assertEquals($expHubImages, $responseData);
	}

	public function getHubImagesDataProvider() {
		// 1 - empty html
		$mockRawText1 = '';
		$expHubImages1 = array(
			WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => '',
			WikiFactoryHub::CATEGORY_ID_GAMING => '',
			WikiFactoryHub::CATEGORY_ID_LIFESTYLE => '',
		);
		$mockFileParams1 = false;
		$mockImageServingParams1 = 0;

		// 2 - not empty html + gallery tag not exist
		$mockRawText2 = <<<TXT
<div class="WikiaGrid WikiaHubs" id="WikiaHubs">
<div class="grid-3 alpha">
</div>
</div>
TXT;

		// 3 - not empty html + gallery tag exist with orientation="right"
		$mockRawText3 = <<<TXT
<div class="grid-3 alpha">

<section style="margin-bottom:20px" class="grid-3 alpha"></html><gallery type="slider" orientation="right">
ninjagaiden_hero_030212.jpg|Ninja Gaiden 3 Starter Guide|link=http://ninjagaiden.wikia.com/wiki/User_blog:MarkvA/Ninja_Gaiden_Starter_Guide|linktext=Ryu Hayabusa is ready to spill more blood.|shorttext=Ninja Gaiden
halo_hero_030212_a.jpg|Which is the Best Halo Game?|link=http://halo.wikia.com/wiki/User_blog:MarkvA/Halo_Versus_Halo_-_Which_Game_is_Best|linktext=This is one fight Master Chief might lose.|shorttext=Halo vs. Halo
tombraider_hero_030212.jpg|Tomb Raider Quiz|link=http://laracroft.wikia.com/wiki/PlayQuiz:Tomb_Raider_Quiz|linktext=Get to know Lara Croft inside and out.|shorttext=Lara Croft Quiz
masseffect3_hero_030212_b.jpg|Mass Effect 3 Walkthrough|link=http://masseffect.wikia.com/wiki/Mass_Effect_3_Guide|linktext=Save the galaxy with our in-depth guide.|shorttext=Mass Effect 3
legobatman2_hero_031212.jpg|LEGO Batman 2 Details|link=http://lego.wikia.com/wiki/LEGO_Batman_2:_DC_Super_Heroes|linktext=The Man of Steel comes to Gotham City.|shorttext=LEGO Batman 2
</gallery><html></section>
</div>
TXT;

		// 4 - not empty html + gallery tag exists with orientation="mosaic" + file NOT exist
		$mockRawText4 = <<<TXT
<div class="grid-3 alpha">

<section style="margin-bottom:20px" class="grid-3 alpha"></html><gallery type="slider" orientation="mosaic">
ninjagaiden_hero_030212.jpg|Ninja Gaiden 3 Starter Guide|link=http://ninjagaiden.wikia.com/wiki/User_blog:MarkvA/Ninja_Gaiden_Starter_Guide|linktext=Ryu Hayabusa is ready to spill more blood.|shorttext=Ninja Gaiden
halo_hero_030212_a.jpg|Which is the Best Halo Game?|link=http://halo.wikia.com/wiki/User_blog:MarkvA/Halo_Versus_Halo_-_Which_Game_is_Best|linktext=This is one fight Master Chief might lose.|shorttext=Halo vs. Halo
tombraider_hero_030212.jpg|Tomb Raider Quiz|link=http://laracroft.wikia.com/wiki/PlayQuiz:Tomb_Raider_Quiz|linktext=Get to know Lara Croft inside and out.|shorttext=Lara Croft Quiz
masseffect3_hero_030212_b.jpg|Mass Effect 3 Walkthrough|link=http://masseffect.wikia.com/wiki/Mass_Effect_3_Guide|linktext=Save the galaxy with our in-depth guide.|shorttext=Mass Effect 3
legobatman2_hero_031212.jpg|LEGO Batman 2 Details|link=http://lego.wikia.com/wiki/LEGO_Batman_2:_DC_Super_Heroes|linktext=The Man of Steel comes to Gotham City.|shorttext=LEGO Batman 2
</gallery><html></section>
</div>
TXT;
		$mockFileParams4 = array(
			'exists' => false,
		);

		$expHubImages3 = array(
			WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => '',
			WikiFactoryHub::CATEGORY_ID_GAMING => '',
			WikiFactoryHub::CATEGORY_ID_LIFESTYLE => '',
		);

		// 4 - not empty html + gallery tag exists with orientation="mosaic" + file does not exist
		$expHubImages4 = array(
			WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => self::BLANK_IMG_URL,
			WikiFactoryHub::CATEGORY_ID_GAMING => self::BLANK_IMG_URL,
			WikiFactoryHub::CATEGORY_ID_LIFESTYLE => self::BLANK_IMG_URL,
		);

		// 5 - not empty html + gallery tag exists with orientation="mosaic" + file exists
		$expHubImages5 = array(
			WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => self::BLANK_IMG_URL,
			WikiFactoryHub::CATEGORY_ID_GAMING => self::BLANK_IMG_URL,
			WikiFactoryHub::CATEGORY_ID_LIFESTYLE => self::BLANK_IMG_URL,
		);
		$mockFileParams5 = array(
			'exists' => true,
			'getURL' => self::MOCK_FILE_URL,
			'getTimestamp' => '',
			'getName' => null,
			'getZoneUrl' => null,
			'getThumbUrl' => null,
		);

		return array(
			// 1 - empty html
			array($mockRawText1, $mockFileParams1, $mockImageServingParams1, $expHubImages1),
			// 2 - not empty html + gallery tag not exists
			array($mockRawText2, $mockFileParams1, $mockImageServingParams1, $expHubImages1),
			// 3 - not empty html + gallery tag exists with orientation="right"
			array($mockRawText3, $mockFileParams1, $mockImageServingParams1, $expHubImages3),
			// 4 - not empty html + gallery tag exists with orientation="mosaic" + file NOT exist
			array($mockRawText4, $mockFileParams4, $mockImageServingParams1, $expHubImages4),
			// 5 - not empty html + gallery tag exists with orientation="mosaic" + file exists
			array($mockRawText4, $mockFileParams5, $mockImageServingParams1, $expHubImages5),
		);
	}

	/**
	 * @dataProvider getHubV2ImagesDataProvider
	 */
	public function testGetHubV2Images($mockedImageUrl, $expHubImages) {
		// setup
		$this->mockGlobalVariable('wgEnableWikiaHubsV2Ext', true);
		$this->mockGlobalVariable('wgWikiaHubsV2Pages', array(
			WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'Entertainment',
			WikiFactoryHub::CATEGORY_ID_GAMING => 'Video_games',
			WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'Lifestyle',
		));

		$mock_cache = $this->getMock('stdClass', array('get', 'set'));
		$mock_cache->expects($this->any())
			->method('get')
			->will($this->returnValue(null));
		$mock_cache->expects($this->any())
			->method('set');
		$this->mockGlobalVariable('wgMemc', $mock_cache);

		$homePageMock = $this->getMock('WikiaHomePageController', array('getHubSliderData'));
		$homePageMock->expects($this->any())
			->method('getHubSliderData')
			->will($this->returnValue(array(
					'data' => array(
						'slides' => array(
							0 => array(
								'photoUrl' => $mockedImageUrl
							)
						)
					)
				)
			));

		$this->mockClass('WikiaHomePageController', $homePageMock);

		$this->setUpMock();

		$response = $this->app->sendRequest('WikiaHomePage', 'getHubImages');
		$responseData = $response->getVal('hubImages');

		$this->assertEquals($expHubImages, $responseData);
	}

	public function getHubV2ImagesDataProvider() {
		return array(
			array(
				null,
				array(
					WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => null,
					WikiFactoryHub::CATEGORY_ID_GAMING => null,
					WikiFactoryHub::CATEGORY_ID_LIFESTYLE => null,
				)
			),
			array(
				'testUrl',
				array(
					WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'testUrl',
					WikiFactoryHub::CATEGORY_ID_GAMING => 'testUrl',
					WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'testUrl',
				)
			),
		);
	}

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

		$expectedData = '[{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"bigslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"mediumslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}],"smallslots":[{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A video games wiki","wikiurl":"http:\/\/a-video-games-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"An entertainment wiki","wikiurl":"http:\/\/an-entertainment-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"},{"wikiid":0,"wikiname":"A lifestyle wiki","wikiurl":"http:\/\/a-lifestyle-wiki.wikia.com","wikinew":false,"wikihot":false,"wikipromoted":false,"wikiblocked":false,"main_image":"image","image":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]}]';
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
	 * @dataProvider getWikiAdminAvatarsDataProvider
	 */
	public function testGetWikiAdminAvatars($mockWikiId, $mockWikiServiceParam, $mockUserStatsServiceParam, $mockUserParam, $expAdminAvatars) {
		// setup
		$this->mockGlobalVariable('wgServer', self::TEST_URL);

		$this->setUpMockObject('WikiService', $mockWikiServiceParam, true);
		$this->setUpMockObject('User', $mockUserParam, true);

		$mockUserStatsService = $this->getMock('UserStatsService', array('getStats','getEditCountWiki'), array(1));
		$mockUserStatsService->expects($this->any())->method('getStats')
			->will($this->returnValue(
				array(
					'edits' => !empty($mockUserStatsServiceParam['getEditCountWiki']) ? $mockUserStatsServiceParam['getEditCountWiki'] : 0,
					'date' => 0,
					'likes' => 20 + rand(0, 50))
			)
		);
		$mockUserStatsService->expects($this->any())->method('getEditCountWiki')
			->will($this->returnValue(
				(!empty($mockUserStatsServiceParam['getEditCountWiki']) ? $mockUserStatsServiceParam['getEditCountWiki'] : 0)
			)
		);
		$this->mockClass('UserStatsService',$mockUserStatsService);


		$this->mockClass( 'GlobalTitle', $this->getMockWithMethods( 'GlobalTitle', array(
			'getFullURL' => self::TEST_URL,
		)), array( null, 'newFromText', 'newFromTextCached' ));

		$this->setUpMockObject('WikiaHomePageHelper', array(
			'formatMemberSinceDate' => self::TEST_MEMBER_DATE
		), true);

		$this->setUpMock();

		// test
		$helper = new WikiaHomePageHelper();
		$adminAvatars = array_values($helper->getWikiAdminAvatars($mockWikiId));

		$this->assertEquals($expAdminAvatars, $adminAvatars);
	}

	public function getWikiAdminAvatarsDataProvider() {
		// 1 - wikiId = 0
		$mockWikiId1 = 0;
		$mockWikiServiceParam1 = null;
		$mockUserStatsServiceParam1 = null;
		$mockUserParam1 = null;
		$expAdminAvatars1 = array();

		// 2 - no admins
		$mockWikiId2 = self::TEST_CITY_ID;
		$mockWikiServiceParam2 = array(
			'getWikiAdminIds' => array(),
		);
		$mockUserStatsServiceParam2 = array(
			'getWikiAdminIds' => array(),
			'getEditCountWiki' => rand(0,100),
			'params' => rand(0,100000),//user_id
		);

		// 3 - user not found
		$mockWikiServiceParam3 = array(
			'getWikiAdminIds' => array('123'),
		);
		$mockUserStatsServiceParam3 = array(
			'getEditCountWiki' => rand(0,100),
			'params' => rand(0,100000),//user_id
		);
		$mockUserParam3 = false;

		// 4 - don't have avatar
		$mockUserStatsServiceParam4 = array(
			'getEditCountWiki' => rand(0,100),
			'params' => rand(0,100000),//user_id
		);
		$mockUserParam4 = array(
			'newFromId' => null,
			'isBlocked' => false,
			'isBlockedGlobally' => false,
		);

		// 5 - admins have avatar < LIMIT_ADMIN_AVATARS + user edits = 0
		$mockWikiServiceParam5 = array(
			'getWikiAdminIds' => array('123')
		);
		$mockUserStatsServiceParam5 = array(
			'getEditCountWiki' => 0,
			'params' => rand(0,100000),//user_id
		);
		$mockUserParam5 = array(
			'newFromId' => null,
			'getName' => 'TestName',
			'isBlocked' => false,
			'isBlockedGlobally' => false,
		);
		$mockAvatarServiceParam5 = array(
			'getAvatarUrl' => null,
		);
		$expAdminAvatars5 = array(
			array(
				'avatarUrl' => null,
				'edits' => 0,
				'name' => 'TestName',
				'userPageUrl' => self::TEST_URL,
				'userContributionsUrl' => self::TEST_URL,
				'since' => self::TEST_MEMBER_DATE,
				'userId' => '123'
			),
		);

		// 6 - admins have avatar == LIMIT_ADMIN_AVATARS + user edits != 0
		$mockWikiServiceParam6 = array(
			'getWikiAdminIds' => array('2', '2', '2'),
		);
		$mockUserStatsServiceParam6 = array(
			'getEditCountWiki' => 5,
			'params' => '5338185',
		);
		$expAdminAvatars6 = array(
			array(
				'avatarUrl' => null,
				'edits' => 15,
				'name' => 'TestName',
				'userPageUrl' => self::TEST_URL,
				'userContributionsUrl' => self::TEST_URL,
				'since' => self::TEST_MEMBER_DATE,
				'userId' => '2'
			)
		);

		// 7 - admins have avatar > LIMIT_ADMIN_AVATARS + user edits != 0
		$mockWikiServiceParam7 = array(
			'getWikiAdminIds' => array('3', '3', '3', '3', '3', '3'),
		);
		$mockUserStatsServiceParam7 = array(
			'getEditCountWiki' => 5,
			'params' => '5338185',
		);
		$expAdminAvatars7 = array(
			array(
				'avatarUrl' => null,
				'edits' => 30,
				'name' => 'TestName',
				'userPageUrl' => self::TEST_URL,
				'userContributionsUrl' => self::TEST_URL,
				'since' => self::TEST_MEMBER_DATE,
				'userId' => '3'
			)
		);

		return array(
			'1 - wikiId = 0' =>
			array($mockWikiId1, $mockWikiServiceParam1, $mockUserStatsServiceParam1, $mockUserParam1, $expAdminAvatars1),
			'2 - no admins' =>
			array($mockWikiId2, $mockWikiServiceParam2, $mockUserStatsServiceParam2, $mockUserParam1, $expAdminAvatars1),
			'3 - user not found' =>
			array($mockWikiId2, $mockWikiServiceParam3, $mockUserStatsServiceParam3, $mockUserParam3, $expAdminAvatars1),
			'4 - don\'t have avatar' =>
			array($mockWikiId2, $mockWikiServiceParam2, $mockUserStatsServiceParam2, $mockUserParam4, $expAdminAvatars1),
			'5 - admins have avatar < LIMIT_ADMIN_AVATARS + user edits = 0' =>
			array($mockWikiId2, $mockWikiServiceParam5, $mockUserStatsServiceParam5, $mockUserParam5, $expAdminAvatars5),
			'6 - admins have avatar = LIMIT_ADMIN_AVATARS + user edits != 0' =>
			array($mockWikiId2, $mockWikiServiceParam6, $mockUserStatsServiceParam6, $mockUserParam5, $expAdminAvatars6),
			'7 - admins have avatar > LIMIT_ADMIN_AVATARS + user edits != 0' =>
			array($mockWikiId2, $mockWikiServiceParam7, $mockUserStatsServiceParam7, $mockUserParam5, $expAdminAvatars7),
		);
	}

	/**
	 * @dataProvider getWikiTopEditorAvatarsDataProvider
	 */
	public function testGetWikiTopEditorAvatars($mockWikiId, $mockWikiServiceParam, $mockUserParam, $mockAvatarServiceParam, $expTopEditorAvatars) {
		$this->mockGlobalVariable('wgServer', self::TEST_URL);
		$this->setUpMockObject('WikiService', $mockWikiServiceParam, true);
		$this->setUpMockObject('User', $mockUserParam, true);
		$this->setUpMockObject('AvatarService', $mockAvatarServiceParam, true);

		$this->mockClass( 'GlobalTitle', $this->getMockWithMethods( 'GlobalTitle', array(
			'getFullURL' => self::TEST_URL,
		)), array( null, 'newFromText', 'newFromTextCached' ));


		$this->setUpMockObject('WikiaHomePageHelper', array(
			'formatMemberSinceDate' => self::TEST_MEMBER_DATE
		), true);

		$this->setUpMock();

		// test
		$helper = new WikiaHomePageHelper();
		$topEditorAvatars = array_values($helper->getWikiTopEditorAvatars($mockWikiId));

		$this->assertEquals($expTopEditorAvatars, $topEditorAvatars);
	}

	public function getWikiTopEditorAvatarsDataProvider() {
		// 1 - wikiId = 0
		$mockWikiId1 = 0;
		$mockWikiServiceParam1 = null;
		$mockUserParam1 = null;
		$mockAvatarServiceParam1 = null;
		$expTopEditorAvatars1 = array();

		// 2 - no editors
		$mockWikiId2 = self::TEST_CITY_ID;

		// 3 - user not found
		$mockWikiServiceParam2 = array(
			'getTopEditors' => array(
				123 => 0,
			),
		);
		$mockUserParam3 = false;

		// 4 - don't have avatar
		$mockUserParam4 = array(
			'newFromId' => null,
			'isBlocked' => false,
			'isBlockedGlobally' => false,
		);

		// 5 - editors have avatar < LIMIT_ADMIN_AVATARS + user edits = 0
		$mockWikiServiceParam5 = array(
			'getTopEditors' => array(
				123 => 0,
			),
		);
		$mockUserParam5 = array(
			'newFromId' => null,
			'getName' => 'TestName',
			'isBlocked' => false,
			'isBlockedGlobally' => false,
		);
		$expTopEditorAvatars5 = array(
			array(
				'avatarUrl' => null,
				'edits' => 0,
				'name' => 'TestName',
				'userPageUrl' => self::TEST_URL,
				'userContributionsUrl' => self::TEST_URL,
				'since' => self::TEST_MEMBER_DATE,
				'userId' => 123
			),
		);

		// 6 - editors have avatar == LIMIT_ADMIN_AVATARS + user edits != 0
		$mockWikiServiceParam6 = array(
			'getTopEditors' => array(
				11 => 5,
				12 => 5,
				13 => 5,
				14 => 5,
				15 => 5,
				16 => 5,
				17 => 5,
			),
		);
		$expTopEditorAvatars6 = array(
			array(
				'avatarUrl' => null,
				'edits' => 35,
				'name' => 'TestName',
				'userPageUrl' => self::TEST_URL,
				'userContributionsUrl' => self::TEST_URL,
				'since' => self::TEST_MEMBER_DATE,
				'userId' => 17
			)
		);

		return array(
			'1 - wikiId = 0' =>
			array($mockWikiId1, $mockWikiServiceParam1, $mockUserParam1, $mockAvatarServiceParam1, $expTopEditorAvatars1),
			'2 - no editors' =>
			array($mockWikiId2, $mockWikiServiceParam2, $mockUserParam1, $mockAvatarServiceParam1, $expTopEditorAvatars1),
			'3 - user not found' =>
			array($mockWikiId2, $mockWikiServiceParam2, $mockUserParam3, $mockAvatarServiceParam1, $expTopEditorAvatars1),
			'4 - don\'t have avatar' =>
			array($mockWikiId2, $mockWikiServiceParam2, $mockUserParam4, $mockAvatarServiceParam1, $expTopEditorAvatars1),
			'5 - editors have avatar < LIMIT_ADMIN_AVATARS + user edits = 0' =>
			array($mockWikiId2, $mockWikiServiceParam5, $mockUserParam5, $mockAvatarServiceParam1, $expTopEditorAvatars5),
			'6 - editors have avatar = LIMIT_ADMIN_AVATARS + user edits != 0' =>
			array($mockWikiId2, $mockWikiServiceParam6, $mockUserParam5, $mockAvatarServiceParam1, $expTopEditorAvatars6),
		);
	}

	/**
	 * @dataProvider getProcessedWikisImgSizesDataProvider
	 */
	public function testGetProcessedWikisImgSizes($limit, $width, $height) {
		$whh = new WikiaHomePageHelper();
		$size = $whh->getProcessedWikisImgSizes($limit);

		$this->assertEquals($width, $size->width);
		$this->assertEquals($height, $size->height);
	}

	public function getProcessedWikisImgSizesDataProvider() {
		$whh = new WikiaHomePageHelper();
		return array(
			array(WikiaHomePageHelper::SLOTS_BIG, $whh->getRemixBigImgWidth(), $whh->getRemixBigImgHeight()),
			array(WikiaHomePageHelper::SLOTS_MEDIUM, $whh->getRemixMediumImgWidth(), $whh->getRemixMediumImgHeight()),
			array(WikiaHomePageHelper::SLOTS_SMALL, $whh->getRemixSmallImgWidth(), $whh->getRemixSmallImgHeight()),
			array(666, $whh->getRemixBigImgWidth(), $whh->getRemixBigImgHeight()),
		);
	}

}
