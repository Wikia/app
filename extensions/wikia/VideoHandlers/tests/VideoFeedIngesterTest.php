<?php
/**
 * @group MediaFeatures
 */
class VideoFeedIngesterTest extends WikiaBaseTest {

	/**
	 * Ooyala has to be loaded before providers which load their content onto Ooyala (aka, remote assets),
	 * otherwise videos can be uploaded more than once.
	 * See VID-1871 for more information.
	 */
	public function testOoyalaLoadedBeforeRemoteAssets() {
		$providers = FeedIngesterFactory::getActiveProviders();
		$ooyalaIndex = array_search( FeedIngesterFactory::PROVIDER_OOYALA, $providers );
		$screenplayIndex = array_search( FeedIngesterFactory::PROVIDER_SCREENPLAY, $providers );

		$this->assertTrue( $ooyalaIndex < $screenplayIndex, 'Ooyala should be loaded before screenplay' );
	}

	/**
	 * @dataProvider baseFeedIngesterDataProvider
	 * @expectedException FeedIngesterWarningException
	 */
	public function testExceptionIfNoVideoId( $videoData ) {
		$feedIngester = new TestVideoFeedIngester();
		$videoData['videoId'] = null;
		$feedIngester->setVideoData( $videoData );
		$feedIngester->setMetaData();
	}

	/**
	 * @dataProvider baseFeedIngesterDataProvider
	 * @expectedException FeedIngesterSkippedException
	 */
	public function testExceptionIfVideoBlacklisted( $videoData ) {
		$feedIngester = new TestVideoFeedIngester();
		$feedIngester->setVideoData( $videoData );

		// Test if blacklist checks against title
		$this->mockGlobalVariable( 'wgVideoBlacklist', 'Infinite' );
		$feedIngester->checkIsBlacklistedVideo();

		// Test if blacklist checks against keywords
		$this->mockGlobalVariable( 'wgVideoBlacklist', 'trailer' );
		$feedIngester->checkIsBlacklistedVideo();
	}

	/**
	 * @dataProvider baseFeedIngesterDataProvider
	 */
	public function testBodyStringPreparedProperly( $videoData ) {
		$feedIngester = new IgnFeedIngester();
		$feedIngester->setVideoData( $videoData );
		$feedIngester->setMetaData();
		$feedIngester->setPageCategories();
		$body = $feedIngester->prepareBodyString();
		$expected = "[[Category:IGN]][[Category:IGN entertainment]][[Category:Entertainment]][[Category:Videos]]\n";
		$expected .= "==Description==\n";
		$expected .= "First trailer for the evolving sandbox of SkySaga, where players explore and shape the world around them.";
		$this->assertEquals( $body, $expected );
	}

	/**
	 * Data provider which can be used with either the TestVideoFeedIngester or IgnFeedIngester class.
	 * @return array
	 */
	public function baseFeedIngesterDataProvider() {
		return [
			[
				[

					'titleName' => 'SkySaga: Infinite Isles - Animated Announcement Trailer',
					'published' => 1415800800,
					'videoId' => 'a9c8c537267c1f9b6d18ee11dacb1f17',
					'description' => 'First trailer for the evolving sandbox of SkySaga, where players explore and shape the world around them.',
					'duration' => 135,
					'thumbnail' => 'http://assets1.ignimgs.com/thumbs/2014/11/12/a9c8c537267c1f9b6d18ee11dacb1f17-1415804613/frame_0004.jpg',
					'videoUrl' => 'http://www.ign.com/videos/2014/11/12/skysaga-infinite-isles-animated-announcement-trailer',
					'type' => 'Trailer',
					'gameContent' => null,
					'category' => 'Entertainment',
					'hd' => 1,
					'provider' => 'ign',
					'ageRequired' => 0,
					'ageGate' => 0,
					'name' => null,
					'keywords' => 'none, trailer'
				]
			]
		];
	}
}
