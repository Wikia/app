<?php
class AvatarServiceTest extends WikiaBaseTest {

	/**
	 * @dataProvider getDefaultAvatarDataProvider
	 */
	public function testGetDefaultAvatar($url, $width) {
			$this->assertStringEndsWith($url, AvatarService::getDefaultAvatar($width));
	}

	public function getDefaultAvatarDataProvider() {
		return [
			[
				'url' => '/images/thumb/1/19/Avatar.jpg/20px-Avatar.jpg',
				'width' =>  AvatarService::AVATAR_SIZE_SMALL,
			],
			[
				'url' => '/images/thumb/1/19/Avatar.jpg/50px-Avatar.jpg',
				'width' =>  AvatarService::AVATAR_SIZE_MEDIUM,
			],
			[
				'url' => '/images/thumb/1/19/Avatar.jpg/35px-Avatar.jpg',
				'width' =>  35,
			],
		];
	}

	/**
	 * @dataProvider getUrlDataProvider
	 */
	public function testGetUrl($url, $userName) {
		$this->assertStringEndsWith($url, AvatarService::getUrl($userName));
	}

	public function getUrlDataProvider() {
		return [
			// anon
			[
				'url' => '/Special:Contributions/80.2.3.4',
				'userName' => '80.2.3.4'
			],
			// logged-in
			[
				'url' => '/User:WikiaStaff',
				'userName' => 'WikiaStaff'
			],
		];
	}

	/**
	 * @dataProvider getAvatarUrlDataProvider
	 */
	public function testGetAvatarUrl($url, $userName, $userId, $avatarSize) {
		$user = new User();
		$user->setId($userId);
		$user->setName($userName);

		if ($userId > 0) {
			$user->setOption(AVATAR_USER_OPTION_NAME, $userId);
		}

		$this->assertStringEndsWith($url, AvatarService::getAvatarUrl($user, $avatarSize));
	}

	public function getAvatarUrlDataProvider() {
		return [
			// anon
			[
				'url' => '/images/thumb/1/19/Avatar.jpg/20px-Avatar.jpg',
				'userName' => '80.2.3.4',
				'userId' => 0,
				'avatarSize' => 20,
			],
			// logged-in
			[
				'url' => '/images/thumb/e/e1/123456/20px-123456',
				'userName' => 'TestUser123',
				'userId' => 123456,
				'avatarSize' => 20,
			],
		];
	}
}
