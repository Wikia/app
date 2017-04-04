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
		$expected, $wgEnableArticleFeaturedVideo, $wgArticleVideoFeaturedVideos, $message
	) {
		$this->mockGlobalVariable( 'wgEnableArticleFeaturedVideo', $wgEnableArticleFeaturedVideo );
		$this->mockGlobalVariable( 'wgArticleVideoFeaturedVideos', $wgArticleVideoFeaturedVideos );

		$result = ArticleVideoContext::isFeaturedVideoEmbedded( 'test' );

		$this->assertEquals( $expected, $result, $message );
	}

	// expected, wgEnableArticleFeaturedVideo, wgArticleVideoFeaturedVideos, message
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

	/**
	 * @dataProvider relatedVideoProvider
	 * @param $expected
	 * @param $wgEnableArticleRelatedVideo
	 * @param $wgArticleVideoRelatedVideos
	 * @param $message
	 */
	public function testGetRelatedVideo(
		$expected, $wgEnableArticleRelatedVideo, $wgArticleVideoRelatedVideos, $message
	) {
		$this->mockGlobalVariable( 'wgEnableArticleRelatedVideo', $wgEnableArticleRelatedVideo );
		$this->mockGlobalVariable( 'wgArticleVideoRelatedVideos', $wgArticleVideoRelatedVideos );

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
