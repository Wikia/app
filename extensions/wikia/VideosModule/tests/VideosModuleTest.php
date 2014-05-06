<?php

	/**
	 * Videos Module test
	 *
	 * @category Wikia
	 */
	class VideosModuleTest extends WikiaBaseTest {

		const TEST_CITY_ID = 79860;
		protected static $videoBlacklist = [ 'Video_10' ];

		public function setUp() {
			$this->setupFile = dirname(__FILE__) . '/../VideosModule.setup.php';
			parent::setUp();
		}

		protected function setUpMock( $missingArticleIdMessage ) {
			// mock cache
			$mock_cache = $this->getMock( 'stdClass', [ 'get', 'set', 'delete' ] );
			$mock_cache->expects( $this->any() )
						->method('get')
						->will( $this->returnValue( null ) );
			$mock_cache->expects( $this->any() )
						->method( 'set' );
			$mock_cache->expects( $this->any())
						->method( 'delete' );

			$this->mockGlobalVariable( 'wgMemc', $mock_cache );

			$this->mockGlobalVariable( 'wgVideosModuleBlackList', self::$videoBlacklist );
			$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );

			$this->mockMessage( 'videosmodule-error-no-articleId', $missingArticleIdMessage );
			$this->mockMessage( 'videosmodule-title-default', 'title' );
		}


		/**
		 * Test Video Module Controller
		 * @dataProvider videosModuleDataProvider
		 */
		public function testVideosModule( $requestParams, $expectedData ) {
			$this->setUpMock( $expectedData['msg'] );

			$response = $this->app->sendRequest( 'VideosModule', 'index', $requestParams );

			$responseData = $response->getData();
			$this->assertEquals( $expectedData['result'], $responseData['result'] );
			$this->assertEquals( $expectedData['msg'], $responseData['msg'] );
			$this->assertEquals( $expectedData['videos'], $responseData['videos'] );
		}

		public function videosModuleDataProvider() {
			$requestParams1 = [
				'articleId' => null,
				'limit' => null,
				'local' => null,
				'sort' => null,
			];

			$expectedData1 = [
				'result' => 'error',
				'msg' => 'Article no Id message',
				'videos' => [],
			];

			return [
				// Related videos + no article id
				[ $requestParams1, $expectedData1 ],
			];
		}

	}

