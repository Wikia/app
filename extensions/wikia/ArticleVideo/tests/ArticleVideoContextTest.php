<?php

class ArticleVideoContextTest extends WikiaBaseTest {

	/**
	 * @param $expected
	 * @param $wgEnableArticleFeaturedVideo
	 * @param $videoDetails
	 * @param $message
	 *
	 * @dataProvider featuredVideoProvider
	 */
	public function testIsFeaturedVideoEnabled(
		$expected,
		$wgEnableArticleFeaturedVideo,
		$videoDetails,
		$message
	) {
		$this->mockGlobalVariable( 'wgEnableArticleFeaturedVideo', $wgEnableArticleFeaturedVideo );
		$this->mockStaticMethod( 'ArticleVideoService', 'getFeatureVideoForArticle', $videoDetails );
		$this->mockStaticMethod( 'WikiaPageType', 'isArticlePage', true);

		$result = ArticleVideoContext::isFeaturedVideoAvailable( 123 );

		$this->assertEquals( $expected, $result, $message );
	}

	// expected,
	// wgEnableArticleFeaturedVideo,
	// videoDetails
	// message
	public function featuredVideoProvider() {
		return [
			[ false, false, [], 'Featured video set when extension is disabled' ],
			[ false, true, [], 'Featured video set when data is missing' ],
			[ false, true, [], 'Featured video set when data is empty' ],
			[
				true,
				true,
				[ 'mediaId' => 'alsdkflkasjdkfjaslkdfjl', 'impressionsPerSession' => 1 ],
				'Featured video not set when data is correct'
			],
		];
	}
}
