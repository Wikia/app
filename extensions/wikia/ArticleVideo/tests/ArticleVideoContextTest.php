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

	/**
	 * @dataProvider relatedVideoProvider
	 * @param $expected
	 * @param $wgEnableArticleRelatedVideo
	 * @param $wgArticleVideoRelatedVideos
	 * @param $wgArticleVideoRelatedVideos2
	 * @param $message
	 */
	public function testGetRelatedVideos(
		$expected,
		$wgEnableArticleRelatedVideo,
		$wgArticleVideoRelatedVideos,
		$wgArticleVideoRelatedVideos2,
		$message
	) {
		$this->mockGlobalVariable( 'wgEnableArticleRelatedVideo', $wgEnableArticleRelatedVideo );
		$this->mockGlobalVariable( 'wgArticleVideoRelatedVideos', $wgArticleVideoRelatedVideos );
		$this->mockGlobalVariable( 'wgArticleVideoRelatedVideos2', $wgArticleVideoRelatedVideos2 );

		$result = ArticleVideoContext::getRelatedVideoData( 'test' );

		$this->assertEquals( $expected, $result, $message );
	}

	// expected, wgEnableArticleRelatedVideo, wgArticleVideoRelatedVideos, message
	public function relatedVideoProvider() {
		return [
			[ [], false, null, 'Related video set when extension is disabled' ],
			[ [], true, null, 'Related video set when no data available' ],
			[ [], true, [ 'asdf' => [] ], 'Related video set when wrong data provided' ],
			[ [
				'articles' => [
					0 => 'Newton_Scamander',
					1 => 'test',
					2 => 'List_of_spells',
					3 => 'Harry_Potter_and_the_Chamber_of_Secrets_(film)',
					4 => 'Malfoy_Manor',
				],
				'videoId' => 'JsNTB4OTE6kFhAUbLF1CkYcA5SYDN5Vc',
			], true, [ 0 => [
				'articles' => [
					0 => 'Newton_Scamander',
					1 => 'test',
					2 => 'List_of_spells',
					3 => 'Harry_Potter_and_the_Chamber_of_Secrets_(film)',
					4 => 'Malfoy_Manor',
				],
				'videoId' => 'JsNTB4OTE6kFhAUbLF1CkYcA5SYDN5Vc',
			],
			], 'Related video not set when correct data provided' ],
			[ [], true, [ 0 => [
				'articles' => [
					0 => 'test',
				]
			],
			], 'Related video set when video data missing' ],
			[ [], true, [ 0 => [
				'articles' => [
					0 => 'different_article',
				]
			],
			], 'Related video set when article missing' ],
		];
	}
}
