<?php

	/**
	 * @group Broken
	 */
	class GamestarApiWrapperTest extends WikiaBaseTest {
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

			$this->mockApp();
		}

		/**
		 * get data with valid response - check html response
		 *
		 * @group Infrastructure
		 */
		public function testgetDataFromValidHtmlResponse() {
			// setup
			$this->setUpMock();

			// test
			$url = 'http://www.gamestar.de/index.cfm?pid=1589&pk=66620';

			$apiWrapper = F::build( 'GamestarApiWrapper', array($url), 'newFromUrl' );
			$metaData = $apiWrapper->getMetadata();

			// Video Id
			$response_data = $apiWrapper->getVideoId();

			$exp_data = 66620;
			$this->assertEquals( $exp_data, $response_data );
			$this->assertEquals( $exp_data, $metaData['videoId'] );

			if ( preg_match('/pk\=(\d+)/', $url, $parsed) ) {
				$exp_data = $parsed[1];
			} else {
				$exp_data = '';
			}
			$this->assertNotEmpty( $response_data );	// check if id exists in the url
			$this->assertEquals( $exp_data, $response_data );
			$this->assertEquals( $exp_data, $metaData['videoId'] );

			// Video Title
			$response_data = $apiWrapper->getTitle();

			$exp_data = 'ARMA 3 - Walkthrough-Interview mit Jay Crowe - Teil 1: Camp Maxwell';
			$this->assertEquals( $exp_data, $response_data );
			$this->assertEquals( $exp_data, $metaData['title'] );

			if ( preg_match('/\<title\>(.*)\<\/title>/', $apiWrapper->response, $matches) ) {
				$exp_data = trim( $matches[1] );
				$exp_data = preg_replace( '/[vV]ideo [bB]ei [gG]ame[sS]tar.de$|[vV]ideo [oO]n [gG]ame[sS]tar.de$/', '', $exp_data );
				$exp_data = trim( $exp_data, " -" );
			} else {
				$exp_data = '';
			}
			$this->assertNotEmpty( $response_data );	// check if title exists in the html page
			$this->assertEquals( $exp_data, $response_data );
			$this->assertEquals( $exp_data, $metaData['title'] );

			// Description
			$response_data = $apiWrapper->getDescription();

			$exp_data = 'Wir waren bei Bohemia Interactive und haben eine Alpha-Version von ARMA 3 gespielt. '.
				'Im Video sprechen wir w&auml;hrend des Spiels mit Creative Director Jay Crowe. '.
				'Die Videoreihe besteht aus 7 Einzelvideos mit unterschiedlichen Themenschwerpunkten, '.
				'den Start macht die Einf&uuml;hrung in Camp Maxwell.';
			$this->assertEquals( $exp_data, $response_data );
			$this->assertEquals( $exp_data, $metaData['description'] );
			
			if ( preg_match('/<meta name=[\'\"]description[\'\"] content=(.*)\/\>/', $apiWrapper->response, $matches) ) {
				$exp_data = trim( $matches[1], ' \'\"' );
			} else {
				$exp_data = '';
			}
			$this->assertEquals( $exp_data, $response_data );
			$this->assertEquals( $exp_data, $metaData['description'] );


			// Thumbnail Url
			$response_data = $apiWrapper->getThumbnailUrl();

			$exp_data = $apiWrapper->getThumbnail();
			$this->assertNotEmpty( $response_data );
			$this->assertEquals( $exp_data, $response_data );

			// Mime Type
			$response_data = $apiWrapper->getMimeType();

			$exp_data = 'video/gamestar';
			$this->assertEquals( $exp_data, $response_data );

			// Provider
			$response_data = $apiWrapper->getProvider();

			$exp_data = 'gamestar';
			$this->assertEquals( $exp_data, $response_data );
		}

	}
