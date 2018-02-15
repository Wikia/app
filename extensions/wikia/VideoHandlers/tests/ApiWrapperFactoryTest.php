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
	 * @param string $expectedProvider
	 * @param string $url
	 * @dataProvider getApiWrapperDataProvider
	 */
	function testGetApiWrapper($expectedProvider, $url) {
		$this->assertInstanceOf(
			$expectedProvider,
			ApiWrapperFactory::getInstance()->getApiWrapper( $url )
		);
	}

	function getApiWrapperDataProvider() {
		yield [ DailymotionApiWrapper::class, 'https://www.dailymotion.com/video/x6bwti4?collectionXid=x55ml1' ];
		yield [ VimeoApiWrapper::class, 'https://vimeo.com/240716505' ];
		yield [ YoutubeApiWrapper::class, 'https://www.youtube.com/watch?v=iRvI4c9VsW8' ];
		yield [ YoutubeApiWrapper::class, 'https://youtu.be/iRvI4c9VsW8' ]; # short URL
		yield [ YoukuApiWrapper::class, 'http://v.youku.com/v_show/id_XMzQwNDg0NTE5Ng==.html' ];
	}
}
