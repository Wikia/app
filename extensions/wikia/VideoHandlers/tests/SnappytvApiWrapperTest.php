<?php

	class SnappytvApiWrapperTest extends WikiaBaseTest {
		const TEST_CITY_ID = 79860;

		public function setUp() {
			$this->setupFile = dirname(__FILE__) . '/../VideoHandlers.setup.php';
			parent::setUp();
		}

		protected function setUpMock( $cache_value = false ) {
			$mock_cache = $this->getMock( 'stdClass', array('set', 'delete', 'get') );
			$mock_cache->expects( $this->any() )
						->method( 'set' );
			$mock_cache->expects( $this->any() )
						->method( 'delete' );
			$mock_cache->expects( $this->any() )
						->method( 'get' )
						->will( $this->returnValue($cache_value) );

			$this->mockGlobalVariable( 'wgMemc', $mock_cache );
			$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );
		}

		/**
		 * get data with valid response - check html response
		 * please contact video team if test is failed
		 *
		 * @group Infrastructure
		 */
		public function testgetDataFromValidHtmlResponse() {
			// setup
			$this->setUpMock();

			// test
			$url = 'http://snpy.tv/WRzJ4X';

			$exp_data = 'http://www.snappytv.com/snaps/about-education-file-on-nasa-tv--60';
			$response_data = SnappytvApiWrapper::getRedirectUrl( $url );
			$this->assertEquals( $exp_data, $response_data );

			$exp_data = array(
				'videoId' => 85080,
				'eventId' => 16729006,
			);
			$response_data = SnappytvApiWrapper::getInfoFromHtml( $url );
			$this->assertEquals( $exp_data, $response_data );
		}

	}
