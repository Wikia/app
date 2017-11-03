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
				'time' => '0:01',
				'title' => 'some title',
				'videoId' => 'alsdkflkasjdkfjaslkdfjl',
				'thumbnailUrl' => 'http://img.com/test.jpg'
			] ],  [], 'Featured video set when data is correct but wrong title' ],
			[ true, true, [ 'test' => [
				'time' => '0:01',
				'title' => 'some title',
				'videoId' => 'alsdkflkasjdkfjaslkdfjl',
				'thumbnailUrl' => 'http://img.com/test.jpg'
			] ], [], 'Featured video not set when data is correct' ],
		];
	}

	/**
	 * @param $expected
	 * @param $wgArticleVideoFeaturedVideos
	 * @param $wgArticleVideoFeaturedVideos2
	 * @param $message
	 *
	 * @dataProvider featuredVideoSetsProvider
	 */
	public function testGetFeaturedVideos(
		$expected,
		$wgArticleVideoFeaturedVideos,
		$wgArticleVideoFeaturedVideos2,
		$message
	) {
		$this->mockGlobalVariable( 'wgArticleVideoFeaturedVideos', $wgArticleVideoFeaturedVideos );
		$this->mockGlobalVariable( 'wgArticleVideoFeaturedVideos2', $wgArticleVideoFeaturedVideos2 );

		$result = ArticleVideoContext::getFeaturedVideos();


		$this->assertEquals( $expected, $result, $message );
	}

	// expected,
	// wgEnableArticleFeaturedVideo,
	// wgArticleVideoFeaturedVideos,
	// wgArticleVideoFeaturedVideos2,
	// message
	public function featuredVideoSetsProvider() {
		return [
			[
				[],
				[],
				[],
				'Two empty featured video sets should result in one empty set'
			],
			[
				[ 'test' => [ 'wrong' => 'data' ] ],
				[ 'test' => [ 'wrong' => 'data' ] ],
				[],
				'Will properly merge non-empty array to empty array'
			],
			[
				[ 'test' => [ 'wrong' => 'data' ] ],
				[],
				[ 'test' => [ 'wrong' => 'data' ] ],
				'Will properly merge empty array to non-empty array'
			],
			[
				['test_wrong_title' => [
					'time' => '0:02',
					'title' => 'some title2',
					'videoId' => 'alsdkflkasjdkfjaslkdfjl',
					'thumbnailUrl' => 'http://img.com/test.jpg'
				]],
				['test_wrong_title' => [
					'time' => '0:01',
					'title' => 'some title1',
					'videoId' => 'alsdkflkasjdkfjaslkdfjl',
					'thumbnailUrl' => 'http://img.com/test.jpg'
				]],
				['test_wrong_title' => [
					'time' => '0:02',
					'title' => 'some title2',
					'videoId' => 'alsdkflkasjdkfjaslkdfjl',
					'thumbnailUrl' => 'http://img.com/test.jpg'
				]],
				'Will leave only unique items in the set'
			]
		];
	}
}
