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
		$ivaIndex = array_search( FeedIngesterFactory::PROVIDER_IVA, $providers );

		$this->assertTrue( $ooyalaIndex < $screenplayIndex, 'Ooyala should be loaded before screenplay' );
		$this->assertTrue( $ooyalaIndex < $ivaIndex, 'Ooyala should be loaded before iva' );
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
		$this->mockMessage( 'videohandler-description', 'Description' );
		$this->mockMessage( 'videohandler-category', 'Videos' );

		var_dump( __METHOD__, wfMessage('foo-bar'), wfMessage('videohandler-description'), wfMessage( 'videohandler-category'));

		$feedIngester = new IgnFeedIngester();
		$feedIngester->setVideoData( $videoData );
		$feedIngester->setMetaData();
		$feedIngester->setPageCategories();
		$body = $feedIngester->prepareBodyString();
		$expected = "[[Category:IGN]][[Category:IGN entertainment]][[Category:Entertainment]][[Category:Videos]]\n";
		$expected .= "==Description==\n";
		$expected .= "First trailer for the evolving sandbox of SkySaga, where players explore and shape the world around them.";
		$this->assertEquals( $expected, $body );
	}

	/**
	 * Test that if a duplicate video is found on Wikia, we reuse the old name.
	 * @dataProvider baseFeedIngesterDataProvider
	 */
	public function testIfDuplicateFoundOnWikiaUseOldName( $videoData ) {

		$mockFeedIngester = $this->getMock( 'IgnFeedIngester', ['checkVideoExistsOnWikia'] );

		$oldName = "Old Name Please Reuse";
		$mockFeedIngester->expects( $this->any() )
			->method( 'checkVideoExistsOnWikia' )
			->will( $this->returnCallback( function ( $mockFeedIngester, $oldName ) use ( $mockFeedIngester, $oldName ) {
				// checkVideoExistsOnWikia will set the member variable $oldName on the feed ingester if a
				// duplciate is found and reupload is on.
				$mockFeedIngester->oldName = $oldName;
			} ) );

		$mockFeedIngester->setVideoData( $videoData );
		$mockFeedIngester->checkIsDuplicateVideo( $videoData );
		$mockFeedIngester->setMetaData( $videoData );

		$this->assertEquals( $oldName, $mockFeedIngester->metaData['destinationTitle'] );
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