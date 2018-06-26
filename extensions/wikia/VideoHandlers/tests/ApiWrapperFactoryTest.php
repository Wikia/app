<?php

/**
 * Class ApiWrapperFactoryTest
 *
 * @group MediaFeatures
 */
class ApiWrapperFactoryTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../VideoHandlers.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getApiWrapperDataProvider
	 * 
	 * @param string $expectedProvider
	 * @param string $url
	 *
	 * @throws WikiaException
	 */
	public function testGetApiWrapper( $expectedProvider, $url ) {
		$wrapper = ApiWrapperFactory::getInstance()->getApiWrapper( $url );

		if ( is_null( $expectedProvider ) ) {
			$this->assertNull( $wrapper );
		}
		else {
			$this->assertInstanceOf( $expectedProvider, $wrapper );
		}
	}

	public function getApiWrapperDataProvider() {
		yield [ DailymotionApiWrapper::class, 'https://www.dailymotion.com/video/x6bwti4?collectionXid=x55ml1' ];
		yield [ VimeoApiWrapper::class, 'https://vimeo.com/240716505' ];
		yield [ YoukuApiWrapper::class, 'http://v.youku.com/v_show/id_XMzQwNDg0NTE5Ng==.html' ];

		yield [ null, 'http://example.com' ];
		yield [ null, 'https://www.youtube.com' ];
	}

	/**
	 * @dataProvider provideLicensedWrappers
	 *
	 * @param $expectedProvider
	 * @param $url
	 *
	 * @throws WikiaException
	 */
	public function testGetLicensedApiWrappers( $expectedProvider, $url ) {
		if ( $this->isLicensedWrapperInfoNotAvailable() ) {
			$this->markTestSkipped( 'info not available for licensed API wrapper tests' );
		}

		$wrapper = ApiWrapperFactory::getInstance()->getApiWrapper( $url );
		$this->assertInstanceOf( $expectedProvider, $wrapper );
	}

	public function provideLicensedWrappers() {
		yield [ YoutubeApiWrapper::class, 'https://www.youtube.com/watch?v=iRvI4c9VsW8' ];
		yield [ YoutubeApiWrapper::class, 'https://youtu.be/iRvI4c9VsW8' ]; # short URL
	}

	private function isLicensedWrapperInfoNotAvailable(): bool {
		global $wgYoutubeConfig;

		return empty( $wgYoutubeConfig );
	}
}
