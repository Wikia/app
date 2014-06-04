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

		protected function setUpMock() {
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
		}

		/**
		 * Test that both duplicate videos and videos found in the wgVideosModuleBlackList are filtered out when
		 * creating the list of videos to be shown in the videos module
		 * @dataProvider testAddToListDataProvider
		 */
		public function testAddToList( $videoData ) {
			$this->setUpMock();

			$module = new VideosModule();
			$videos = [];
			foreach ( $videoData as $video ) {
				$module->addToList( $videos, $video );
			}
			// Test if blacklisted videos are filtered out
			$this->assertArrayNotHasKey(self::$videoBlacklist[0], $videos);
			// Test if duplicate videos are filtered out
			$this->assertEquals(1, array_count_values($videos)["Video_2"]);
		}

		public function testAddToListDataProvider() {
			return [
				[
					[
						"Video_1",
						"Video_2",
						self::$videoBlacklist[0]
					],
					[
						"Video_1",
						"Video_2",
						"Video_2",
						"Video_3"
					]
				]
			];
		}
	}

