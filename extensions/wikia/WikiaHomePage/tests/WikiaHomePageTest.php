<?php

	class WikiaHomePageTest extends WikiaBaseTest {
		const TEST_CITY_ID = 79860;

		public function setUp() {
			$this->setupFile = dirname(__FILE__) . '/../WikiaHomePage.setup.php';
			parent::setUp();
		}

		protected function setUpMock( $cacheParams=null ) {
			// mock cache
			$memcParams = array(
				'set' => null,
				'get' => null,
			);
			if ( is_array($cacheParams) ) {
				$memcParams = $memcParams + $cacheParams;
			}
			$this->setUpMockObject( 'stdClass', $memcParams, false, 'wgMemc' );

			$this->mockGlobalVariable('wgCityId', self::TEST_CITY_ID);

			$this->mockApp();
		}

		protected function setUpMockObject( $objectName, $objectParams=null, $needSetInstance=false, $globalVarName=null, $callOriginalConstructor=true, $globalFunc=array() ) {
			$mockObject = $objectParams;
			if ( is_array($objectParams) ) {
				// extract params from methods
				$objectValues = array();	// $objectValues is stored in $objectParams[params]
				$methodParams = array();
				foreach ( $objectParams as $key => $value ) {
					if ( $key == 'params' && !empty($value) ) {
						$objectValues = array($value);
					} else {
						$methodParams[$key] = $value;
					}
				}
				$methods = array_keys( $methodParams );

				// call original contructor or not
				if ( $callOriginalConstructor ) {
					$mockObject = $this->getMock( $objectName, $methods, $objectValues );
				} else {
					$mockObject = $this->getMock( $objectName, $methods, $objectValues, '', false );
				}

				foreach( $methodParams as $method => $value ) {
					if ( $value === null ) {
						$mockObject->expects( $this->any() )
									->method( $method );
					} else if ( is_array($value) && array_key_exists('mockExpTimes', $value) && array_key_exists('mockExpValues', $value) ) {
						if ( $value['mockExpValues'] == null ) {
							$mockObject->expects( $this->exactly($value['mockExpTimes']) )
										->method( $method );
						} else {
							$mockObject->expects( $this->exactly($value['mockExpTimes']) )
										->method( $method )
										->will( $this->returnValue($value['mockExpValues']) );

						}
					} else {
						$mockObject->expects( $this->any() )
									->method( $method )
									->will( $this->returnValue($value) );
					}
				}
			}

			// mock global variable
			if ( !empty($globalVarName) ) {
				$this->mockGlobalVariable( $globalVarName, $mockObject );
			}

			// mock global function
			if ( !empty($globalFunc) ) {
				$this->mockGlobalFunction( $globalFunc['name'], $mockObject, $globalFunc['time'] );
			}

			// set instance
			if ( $needSetInstance ) {
				$this->mockClass( $objectName, $mockObject );
			}
		}

		/**
		 * @dataProvider getHubImagesDataProvider
		 */
		public function testGetHubImages( $mockRawText, $mockFileParams, $mockImageServingParams, $expHubImages ) {
			// setup
			//$this->markTestSkipped();
			$this->setUpMockObject( 'Title', array( 'newFromText' => null ), true );
			$this->setUpMockObject( 'Article', array( 'getRawText' => $mockRawText ), true, null, false );
			$this->setUpMockObject( 'ImageServing', $mockImageServingParams, true, null, false );

			$mockFindFileTime = empty($mockFileParams) ? 0 : count($expHubImages);
			$this->setUpMockObject( 'File', $mockFileParams, true, null, false, array( 'name' => 'FindFile', 'time' => $mockFindFileTime ) );

			$this->setUpMock();

			// test
			$response = $this->app->sendRequest( 'WikiaHomePage', 'getHubImages' );

			$responseData = $response->getVal( 'hubImages' );
			$this->assertEquals( $expHubImages, $responseData );
		}

		public function getHubImagesDataProvider() {
			// 1 - empty html
			$mockRawText1 = '';
			$expHubImages1 = array(
				'Entertainment' => '',
				'Video_Games' => '',
				'Lifestyle' => '',
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

			// 5 - not empty html + gallery tag exists with orientation="mosaic" + file exists
			$mockFileParams5 = array(
				'exists' => true,
				'getURL' => '',
				'getTimestamp' => '',
				'getName' => null,
				'getZoneUrl' => null,
				'getThumbUrl' => null,
			);
			$mockImageServingParams5 = array(
				'getUrl' => array(
					'mockExpTimes' => 3,
					'mockExpValues' => null,
				),
			);

			return array (
				// 1 - empty html
				array( $mockRawText1, $mockFileParams1, $mockImageServingParams1, $expHubImages1 ),
				// 2 - not empty html + gallery tag not exists
				array( $mockRawText2, $mockFileParams1, $mockImageServingParams1, $expHubImages1 ),
				// 3 - not empty html + gallery tag exists with orientation="right"
				array( $mockRawText3, $mockFileParams1, $mockImageServingParams1, $expHubImages1 ),
				// 4 - not empty html + gallery tag exists with orientation="mosaic" + file NOT exist
				array( $mockRawText4, $mockFileParams4, $mockImageServingParams1, $expHubImages1 ),
				// 5 - not empty html + gallery tag exists with orientation="mosaic" + file exists
				array( $mockRawText4, $mockFileParams5, $mockImageServingParams5, $expHubImages1 ),
			);
		}

		/**
		 * @dataProvider getListDataProvider
		 */
		public function testGetList($mediaWikiMsg, $expectedStatus, $expectedResult, $expectedExceptionMsg) {
			$this->setUpMockObject( 'WikiaHomePageController', array( 'getMediaWikiMessage' => $mediaWikiMsg ), true );

			$this->setUpMock();

			$response = $this->app->sendRequest('WikiaHomePageController', 'getList', array());

			$responseData = $response->getVal('data');
			$this->assertEquals($expectedResult, $responseData);

			$responseData = $response->getVal('exception');
			$this->assertEquals($expectedExceptionMsg, $responseData);

			$responseData = $response->getVal('status');
			$this->assertEquals($expectedStatus, $responseData);
		}

		public function getListDataProvider() {
			return array(
				array(																			//mediawiki msg is empty
					'', 
					0, 
					null, 
					wfMsg('wikia-home-parse-source-empty-exception')
				),
				array(																			//percentage in verticals' lines as a sum < 100%
					"*Gaming|50
	**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
	*Entertainment|25
	**Muppet Wiki|http://muppet.wikia.com|image|description", 
					0, 
					null, 
					wfMsg('wikia-home-parse-source-invalid-percentage')
				),
				array(																			//percentage in verticals' lines as a sum > 100%
					"*Gaming|60
	**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
	*Entertainment|60
	**Muppet Wiki|http://muppet.wikia.com|image|description", 
					0, 
					null, 
					wfMsg('wikia-home-parse-source-invalid-percentage')
				),
				array(																			//two parameters have to be set (seperated with a |) for a vertical (vertical name and percentage)
					"*Gaming
	**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
	*Entertainment
	**Muppet Wiki|http://muppet.wikia.com|image|description", 
					0, 
					null, 
					wfMsg('wikia-home-parse-vertical-invalid-data')
				),
				array(																			//at least three parameters have to be set (seperated with a |) for a wiki (wiki name, wiki url, wiki image)
					"*Gaming|50
	**The Call of Duty Wiki
	*Entertainment|50
	**Muppet Wiki|http://muppet.wikia.com", 
					0, 
					null, 
					wfMsg('wikia-home-parse-wiki-too-few-parameters')
				),
				array(																			//percentage in verticals' lines as a sum incorrect after overriding a vertical
					"*Gaming|50
	**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
	*Entertainment|50
	**Muppet Wiki|http://muppet.wikia.com|image|description
	*Gaming|250
	**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description", 
					0, 
					null, 
					wfMsg('wikia-home-parse-source-invalid-percentage')
				),
				array(																			//everything's OK
					"*Gaming|50
	**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
	*Entertainment|50
	**Muppet Wiki|http://muppet.wikia.com|image|description", 
					1, 
					'[{"vertical":"gaming","percentage":50,"wikilist":[{"wikiname":"The Call of Duty Wiki","wikiurl":"http:\/\/callofduty.wikia.com\/","wikidesc":"description","wikinew":false,"wikihot":false,"imagesmall":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D","imagemedium":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D","imagebig":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"vertical":"entertainment","percentage":50,"wikilist":[{"wikiname":"Muppet Wiki","wikiurl":"http:\/\/muppet.wikia.com","wikidesc":"description","wikinew":false,"wikihot":false,"imagesmall":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D","imagemedium":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D","imagebig":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]}]', 
					null
				),
				array(																			//everything's OK but data has spacebars here and there
					"    *Gaming|    50
				**The Call of Duty Wiki|   http://callofduty.wikia.com/   |    image    |     description     
							   *          Entertainment       |    50
						  **          Muppet Wiki       |    http://muppet.wikia.com       |    image        |      description      ", 
					1, 
					'[{"vertical":"gaming","percentage":50,"wikilist":[{"wikiname":"The Call of Duty Wiki","wikiurl":"http:\/\/callofduty.wikia.com\/","wikidesc":"description","wikinew":false,"wikihot":false,"imagesmall":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D","imagemedium":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D","imagebig":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]},{"vertical":"entertainment","percentage":50,"wikilist":[{"wikiname":"Muppet Wiki","wikiurl":"http:\/\/muppet.wikia.com","wikidesc":"description","wikinew":false,"wikihot":false,"imagesmall":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D","imagemedium":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D","imagebig":"data:image\/gif;base64,R0lGODlhAQABAIABAAAAAP\/\/\/yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"}]}]', 
					null
				),
			);
		}

	}