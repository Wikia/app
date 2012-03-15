<?php

	require_once dirname(__FILE__) . '/../WikiaHomePage.setup.php';

	class WikiaHomePageTest extends WikiaBaseTest {
		const TEST_CITY_ID = 79860;

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
		public function testGetHubImages( $mockRawText, $mockFileParams, $mockReplaceImageServerTime, $expHubImages ) {
			$this->markTestSkipped(__METHOD__ . ' throws fatal error');

			// setup
			$this->setUpMockObject( 'Title', array( 'newFromText' => null ), true );
			$this->setUpMockObject( 'Article', array( 'getRawText' => $mockRawText ), true, null, false );

			$mockFindFileTime = empty($mockFileParams) ? 0 : count($expHubImages);
			$this->setUpMockObject( 'File', $mockFileParams, true, null, false, array( 'name' => 'FindFile', 'time' => $mockFindFileTime ) );

			$this->mockGlobalFunction( 'ReplaceImageServer', '', $mockReplaceImageServerTime );

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
			$mockReplaceImageServerTime1 = 0;

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
Gears.png|Cool beans|link=dragonage.wikia.com|linktext=Coolest thing ever
Slider-hub-entourage.jpg|This is a very very long title that should be cut off at some point|link=dragonage.wikia.com|linktext=This is a very very long title that should be cut off at some point cause it is very very long.
Slider-hub-dragonball.jpg|DBZ|link=dragonage.wikia.com|linktext=OVER 9000!
Slider-hub-dragonage.jpg|don\'t play this game|link=dragonage.wikia.com|linktext=cause it sucks
Slider-hub-catherine.jpg|Catherine|link=dragonage.wikia.com|linktext=is hard
</gallery><html></section>
</div>
TXT;

			// 4 - not empty html + gallery tag exists with orientation="mosaic" + file NOT exist
			$mockRawText4 = <<<TXT
<div class="grid-3 alpha">

<section style="margin-bottom:20px" class="grid-3 alpha"></html><gallery type="slider" orientation="mosaic">
Gears.png|Cool beans|link=dragonage.wikia.com|linktext=Coolest thing ever
Slider-hub-entourage.jpg|This is a very very long title that should be cut off at some point|link=dragonage.wikia.com|linktext=This is a very very long title that should be cut off at some point cause it is very very long.
Slider-hub-dragonball.jpg|DBZ|link=dragonage.wikia.com|linktext=OVER 9000!
Slider-hub-dragonage.jpg|don\'t play this game|link=dragonage.wikia.com|linktext=cause it sucks
Slider-hub-catherine.jpg|Catherine|link=dragonage.wikia.com|linktext=is hard
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
			);
			$mockReplaceImageServerTime5 = 3;

			return array (
				// 1 - empty html
				array( $mockRawText1, $mockFileParams1, $mockReplaceImageServerTime1, $expHubImages1 ),
				// 2 - not empty html + gallery tag not exists
				array( $mockRawText2, $mockFileParams1, $mockReplaceImageServerTime1, $expHubImages1 ),
				// 3 - not empty html + gallery tag exists with orientation="right"
				array( $mockRawText3, $mockFileParams1, $mockReplaceImageServerTime1, $expHubImages1 ),
				// 4 - not empty html + gallery tag exists with orientation="mosaic" + file NOT exist
				array( $mockRawText4, $mockFileParams4, $mockReplaceImageServerTime1, $expHubImages1 ),
				// 5 - not empty html + gallery tag exists with orientation="mosaic" + file exists
				array( $mockRawText4, $mockFileParams5, $mockReplaceImageServerTime5, $expHubImages1 ),
			);
		}

	}