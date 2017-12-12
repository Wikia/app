<?php

class ArticleVideoContextTest extends WikiaBaseTest {

	/**
	 * @param $expected
	 * @param $wgEnableArticleFeaturedVideo
	 * @param $wgArticleVideoFeaturedVideos
	 * @param $wgArticleVideoFeaturedVideos2
	 * @param $message
	 *
	 * @dataProvider featuredVideoProvider
	 */
	public function testIsFeaturedVideoEnabled(
		$expected,
		$wgEnableArticleFeaturedVideo,
		$wgArticleVideoFeaturedVideos,
		$wgArticleVideoFeaturedVideos2,
		$message
	) {
		$this->mockGlobalVariable( 'wgEnableArticleFeaturedVideo', $wgEnableArticleFeaturedVideo );
		$this->mockGlobalVariable( 'wgArticleVideoFeaturedVideos', $wgArticleVideoFeaturedVideos );
		$this->mockGlobalVariable( 'wgArticleVideoFeaturedVideos2', $wgArticleVideoFeaturedVideos2 );

		$result = ArticleVideoContext::isFeaturedVideoEmbedded( 'test' );

		$this->assertEquals( $expected, $result, $message );
	}

	// expected,
	// wgEnableArticleFeaturedVideo,
	// wgArticleVideoFeaturedVideos,
	// wgArticleVideoFeaturedVideos2
	// message
	public function featuredVideoProvider() {
		return [
			[ false, false, [], [], 'Featured video set when extension is disabled' ],
			[ false, true, [], [], 'Featured video set when data is missing' ],
			[ false, true, [], [], 'Featured video set when data is empty' ],
			[ false, true, [ 'test' => [ 'wrong' => 'data' ] ], [], 'Featured video set when data is wrong' ],
			[ false, true, [ 'test_wrong_title' => [
				'mediaId' => 'alsdkflkasjdkfjaslkdfjl',
				'player' => 'jwplayer'
			] ],  [], 'Featured video set when data is correct but wrong title' ],
			[ true, true, [ 'test' => [
				'mediaId' => 'alsdkflkasjdkfjaslkdfjl',
				'player' => 'jwplayer'
			] ], [], 'Featured video not set when data is correct' ],
		];
	}
}
