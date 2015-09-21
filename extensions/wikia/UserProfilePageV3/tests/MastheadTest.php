<?php

/**
 * @group Avatar
 */
class MastheadTest extends WikiaBaseTest {

	/**
	 * @param string $avatarOption
	 * @return Masthead
	 */
	private function getMastheadWithAvatar($avatarOption) {
		$user = $this->mockClassWithMethods('User', [
			'getGlobalAttribute' => $avatarOption
		]);

		return Masthead::newFromUser($user);
	}

	/**
	 * Test Masthead::getPurgeUrl method
	 *
	 * @group UsingDB
	 * @dataProvider getPurgeUrlDataProvider
	 *
	 * @param $avatarOption string value of 'avatar' user option for mocked User object
	 * @param $expectedUrl string expected full avatar URL
	 */
	function testGetPurgeUrl($avatarOption, $expectedUrl) {
		$masthead = $this->getMastheadWithAvatar($avatarOption);
		$this->assertEquals($expectedUrl, $masthead->getPurgeUrl(), 'Avatar URL should match the expected value');
	}

	function getPurgeUrlDataProvider() {
		return [
			// default avatar
			[
				'avatarOption' => false,
				'expectedUrl'  => 'http://images.wikia.com/messaging/images//1/19/Avatar.jpg',
			],
			// custom avatar
			[
				'avatarOption' => '/f/fc/119245.png',
				'expectedUrl'  => 'http://images.wikia.com/common/avatars/f/fc/119245.png',
			],
			// predefined avatar selected by the user ("sample")
			[
				'avatarOption' => 'http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
				'expectedUrl'  => 'http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
			],
			// one of the default avatars
			[
				'avatarOption' => 'Avatar2.jpg',
				'expectedUrl'  => 'http://images.wikia.com/messaging/images/e/e8/Avatar2.jpg',
			],
		];
	}

	/**
	 * @param $avatarOption
	 * @param $isDefault
	 * @dataProvider isDefaultAvatarDataProvider
	 */
	function testIsDefaultAvatar($avatarOption, $isDefault) {
		$masthead = $this->getMastheadWithAvatar($avatarOption);
		$this->assertEquals( $isDefault, $masthead->isDefault() );
	}

	function isDefaultAvatarDataProvider() {
		return [
			[
				false,
				true,
			],
			[
				'Avatar2.jpg',
				true,
			],
			[
				'/f/fc/119245.png',
				false
			]
		];
	}
}
