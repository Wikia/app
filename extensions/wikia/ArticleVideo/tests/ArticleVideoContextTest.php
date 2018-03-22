<?php

class ArticleVideoContextTest extends WikiaBaseTest {

	/**
	 * @param $expected
	 * @param $wgEnableArticleFeaturedVideo
	 * @param $mediaId
	 * @param $message
	 *
	 * @dataProvider featuredVideoProvider
	 */
	public function testIsFeaturedVideoEnabled(
		$expected,
		$wgEnableArticleFeaturedVideo,
		$mediaId,
		$message
	) {
		$this->mockGlobalVariable( 'wgEnableArticleFeaturedVideo', $wgEnableArticleFeaturedVideo );
		$this->mockStaticMethod( 'ArticleVideoService', 'getFeatureVideoForArticle', $mediaId );

		$result = ArticleVideoContext::isFeaturedVideoEmbedded( 123 );

		$this->assertEquals( $expected, $result, $message );
	}

	// expected,
	// wgEnableArticleFeaturedVideo,
	// mediaId
	// message
	public function featuredVideoProvider() {
		return [
			[ false, false, '', 'Featured video set when extension is disabled' ],
			[ false, true, '', 'Featured video set when data is missing' ],
			[ false, true, '', 'Featured video set when data is empty' ],
			[ true, true, 'alsdkflkasjdkfjaslkdfjl', 'Featured video not set when data is correct' ],
		];
	}
}
