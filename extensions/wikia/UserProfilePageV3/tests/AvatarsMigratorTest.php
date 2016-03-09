<?php

class AvatarsMigratorTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../maintenance/migrateAvatarsViaService.php';
		parent::setUp();
	}

	/**
	 * @dataProvider isDefaultAvatarDataProvider
	 */
	function testIsDefaultAvatar( $url, $expected ) {
		$this->assertEquals( $expected, AvatarsMigrator::isDefaultAvatar( $url ) );
	}

	function isDefaultAvatarDataProvider() {
		return [
			[
				null,
				true
			],
			[
				'',
				true
			],
			[
				'http://images.wikia.com/messaging/images/1/19/Avatar.jpg',
				true
			],
			[
				'Avatar6.jpg',
				false
			],
			[
				'http://images.wikia.com/common/avatars/f/fc/119245.png',
				false
			],
			[
				'/f/fc/119245.png',
				false
			],
			[
				'http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
				true
			],
		];
	}

	/**
	 * @dataProvider isPredefinedAvatarDataProvider
	 */
	function testIsPredefinedAvatar( $url, $expected ) {
		$this->assertEquals( $expected, AvatarsMigrator::isPredefinedAvatar( $url ) );
	}

	function isPredefinedAvatarDataProvider() {
		return [
			[
				'',
				false
			],
			[
				'http://images.wikia.com/messaging/images/1/19/Avatar.jpg',
				false
			],
			[
				'/f/fc/119245.png',
				false
			],
			[
				'http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
				false
			],
			[
				'Avatar6.jpg',
				true
			],
			[
				'Avatar.jpg',
				true
			],
			[
				'Avatar1.jpg',
				true
			],
			[
				'http://vignette.wikia-dev.com/4a00aa45-a780-45ef-a8d6-f4bb4fa677b8',
				false
			],
		];
	}

	/**
	 * @dataProvider isNewAvatarDataProvider
	 */
	function testIsNewAvatar( $url, $expected ) {
		$this->assertEquals( $expected, AvatarsMigrator::isNewAvatar( $url ) );
	}

	function isNewAvatarDataProvider() {
		return [
			[
				'',
				false
			],
			[
				'http://images.wikia.com/messaging/images/1/19/Avatar.jpg',
				false
			],
			[
				'/f/fc/119245.png',
				false
			],
			[
				'http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
				false
			],
			[
				'http://vignette.wikia-dev.com/4a00aa45-a780-45ef-a8d6-f4bb4fa677b8',
				true
			],
		];
	}
}
