<?php

/**
 * Class GamestarApiWrapperTest
 *
 * @group MediaFeatures
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
	}

	/**
	 * get data with valid response - check html response
	 * please contact video team if test is failed
	 *
	 * @group Infrastructure
	 */
	public function testgetDataFromValidHtmlResponse() {

		$this->markTestSkipped( "This test is broken. The flag will be removed automatically once https://github.com/Wikia/app/pull/6156 is merged." );

		// setup
		$this->setUpMock();

		// test
		$url = 'http://www.gamestar.de/videos/previews,18/arma-3,66620.html';

		$apiWrapper = GamestarApiWrapper::newFromUrl($url);
		$metaData = $apiWrapper->getMetadata();

		// Video Id
		$response_data = $apiWrapper->getVideoId();

		$exp_data = 66620;
		$this->assertEquals( $exp_data, $response_data );
		$this->assertEquals( $exp_data, $metaData['videoId'] );

		$url = trim( $url, ".html" );
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$last = explode( ",", array_pop( $parsed ), 2 );
			$exp_data = array_pop( $last );
		} else {
			$exp_data = '';
		}
		$this->assertNotEmpty( $response_data );	// check if id exists in the url
		$this->assertEquals( $exp_data, $response_data );
		$this->assertEquals( $exp_data, $metaData['videoId'] );

		// Video Title
		$response_data = $apiWrapper->getTitle();

		$exp_data = 'ARMA 3 - Walkthrough-Interview mit Jay Crowe - Teil 1: Camp Maxwell - Video - GameStar.de';
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
