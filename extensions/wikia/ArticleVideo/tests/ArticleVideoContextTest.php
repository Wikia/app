<?php

class ArticleVideoContextTest extends WikiaBaseTest {

	/**
	 * @param $expected
	 * @param $wgEnableArticleFeaturedVideo
	 * @param $wgArticleVideoFeaturedVideos
	 * @param $message
	 *
	 * @dataProvider featuredVideoProvider
	 */
	public function testIsFeaturedVideoEnabled(
		$expected,
		$wgEnableArticleFeaturedVideo,
		$wgArticleVideoFeaturedVideos,
		$message
	) {
		$this->mockGlobalVariable( 'wgEnableArticleFeaturedVideo', $wgEnableArticleFeaturedVideo );
		$this->mockGlobalVariable( 'wgArticleVideoFeaturedVideos', $wgArticleVideoFeaturedVideos );

		$result = ArticleVideoContext::isFeaturedVideoEmbedded( 'test' );

		$this->assertEquals( $expected, $result, $message );
	}

	//expected, wgEnableArticleFeaturedVideo, wgArticleVideoFeaturedVideos, message
	public function featuredVideoProvider() {
		return [
			[ false, false, null, 'Featured video set when extension is disabled' ],
			[ false, true, null, 'Featured video set when data is missing' ],
			[ false, true, [], 'Featured video set when data is empty' ],
			[ false, true, [ 'test' => [ 'wrong' => 'data' ] ], 'Featured video set when data is wrong' ],
			[ false, true, [ 'test_wrong_title' => [
				'time' => '0:01',
				'title' => 'some title',
				'videoId' => 'alsdkflkasjdkfjaslkdfjl',
				'thumbnailUrl' => 'http://img.com/test.jpg'
			] ], 'Featured video set when data is correct but wrong title' ],
			[ true, true, [ 'test' => [
				'time' => '0:01',
				'title' => 'some title',
				'videoId' => 'alsdkflkasjdkfjaslkdfjl',
				'thumbnailUrl' => 'http://img.com/test.jpg'
			] ], 'Featured video not set when data is correct' ],
		];
	}
}
