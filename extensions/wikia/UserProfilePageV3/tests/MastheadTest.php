<?php

class MastheadTest extends WikiaBaseTest {

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
		$user = $this->mockClassWithMethods('User', [
			'getOption' => $avatarOption
		]);

		$masthead = Masthead::newFromUser($user);
		$this->assertEquals($expectedUrl, $masthead->getPurgeUrl(), 'Avatar URL should match the expected value');
	}

	function getPurgeUrlDataProvider() {
		return [
			// default avatar
			[
				'avatarOption' => false,
				'expectedUrl' => 'http://images.wikia.com/messaging/images//1/19/Avatar.jpg',
			],
			// custom avatar
			[
				'avatarOption' => '/f/fc/119245.png',
				'expectedUrl' => 'http://images.wikia.com/common/avatars/f/fc/119245.png',
			],
			// predefined avatar selected by the user ("sample")
			[
				'avatarOption' => 'http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
				'expectedUrl' => 'http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg',
			],
		];
	}
}
