<?php

use Wikia\SwiftSync\Hooks;

/**
 * @group ImageSync
 */
class ImageSyncTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../SwiftSync.setup.php';
		parent::setUp();
	}

	/**
	 * @param string $path
	 * @param bool $expected
	 * @dataProvider isTempFileProvider
	 */
	public function testIsTempFile( string $path, bool $expected ) {
		$this->assertEquals( $expected, Hooks::isTempFile( $path ) );
	}

	public function isTempFileProvider() {
		return [
			[
				'mwstore://swift-backend/naruto/es/images/0/02/Temp_file_3245041_1516192972',
				true
			],
			[
				'mwstore://swift-backend/easternlight/zh-tw/images/3/35/Temp_file_1516192811',
				true
			],

			[
				'mwstore://swift-backend/mediawiki116/images/a/a6/1516027708668Image003.jpg',
				false
			],
			[
				'mwstore://swift-backend/sustainingtest/images/archive/7/7a/20180116084846!HeadShot.png',
				false
			],
			[
				'mwstore://swift-backend/sustainingtest/images/7/7a/WikiEvolution_-_Poznańska_Wiki-1502094455',
				false
			],
		];
	}
}
