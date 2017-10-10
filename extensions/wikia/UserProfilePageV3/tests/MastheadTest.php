<?php

/**
 * @group Avatar
 */
class MastheadTest extends WikiaBaseTest {

	/**
	 * @param string $avatarOption
	 * @return Masthead
	 */
	private function getMastheadWithAvatar( $avatarOption ) {
		/** @var User $user */
		$user = $this->createConfiguredMock( User::class, [
			'getGlobalAttribute' => $avatarOption,
		] );

		return Masthead::newFromUser( $user );
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
		$this->mockGlobalVariable( 'wgVignetteUrl', 'https://vignette.wikia.nocookie.net' );
		$this->assertEquals($expectedUrl, $masthead->getPurgeUrl(), 'Avatar URL should match the expected value');
	}

	function getPurgeUrlDataProvider() {
		return [
			// default avatar
			[
				'avatarOption' => false,
				'expectedUrl'  => 'https://vignette.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg/revision/latest',
			],
			// custom avatar
			[
				'avatarOption' => '/f/fc/119245.png',
				'expectedUrl'  => 'https://vignette.wikia.nocookie.net/common/avatars/f/fc/119245.png/revision/latest',
			],
			// predefined avatar selected by the user ("sample")
			[
				'avatarOption' => 'https://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
				'expectedUrl'  => 'https://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
			],
			// one of the default avatars
			[
				'avatarOption' => 'Avatar2.jpg',
				'expectedUrl'  => 'https://vignette.wikia.nocookie.net/messaging/images/e/e8/Avatar2.jpg/revision/latest',
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
			],
			# PLATFORM-1617: full URLs
			[
				'http://images.wikia.com/messaging/images//1/19/Avatar.jpg',
				true
			],
			[
				'http://images.wikia.com/messaging/images/e/e5/Avatar4.jpg',
				true
			],
			[
				'http://images.wikia.com/common/avatars/3/3b/27078273.png',
				false
			],
			[
				'http://static.wikia.nocookie.net/ba2cd689-8297-4fba-b739-0b6e08efc794',
				false
			],
			[
				'https://images.wikia.nocookie.net/messaging/images//1/19/Avatar.jpg',
				true
			],
			[
				'https://images.wikia.nocookie.net/messaging/images/e/e5/Avatar4.jpg',
				true
			],
			[
				'https://images.wikia.nocookie.net/common/avatars/3/3b/27078273.png',
				false
			],
			[
				'https://vignette.wikia.nocookie.net/messaging/images//1/19/Avatar.jpg',
				true
			],
			[
				'https://vignette.wikia.nocookie.net/messaging/images/e/e5/Avatar4.jpg',
				true
			],
			[
				'https://vignette.wikia.nocookie.net/common/avatars/3/3b/27078273.png',
				false
			],
			[
				'https://static.wikia.nocookie.net/ba2cd689-8297-4fba-b739-0b6e08efc794',
				false
			],
		];
	}
}
