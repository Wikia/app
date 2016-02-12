<?php

/**
 * @group Avatar
 */
class AvatarServiceTest extends WikiaBaseTest {

	public function setUp() {
		parent::setUp();
		$this->mockGlobalVariable( 'wgEnableVignette', true );
	}

	/**
	 * @dataProvider getDefaultAvatarDataProvider
	 * @group UsingDB
	 */
	public function testGetDefaultAvatar( $url, $width ) {
			$this->assertStringEndsWith( $url, AvatarService::getDefaultAvatar( $width ) );
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
	 * @group UsingDB
	 */
	public function testGetUrl( $url, $userName ) {
		$this->assertStringEndsWith( $url, AvatarService::getUrl( $userName ) );
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
	 * @group UsingDB
	 * @dataProvider getAvatarUrlDataProvider
	 */
	public function testGetAvatarUrl( $url, $userName, $userId, $avatarSize ) {
		$user = new User();
		$user->setId( $userId );
		$user->setName( $userName );

		if ( $userId > 0 ) {
			$user->setGlobalAttribute( AVATAR_USER_OPTION_NAME, $userId );
		}

		$this->assertStringEndsWith( $url, AvatarService::getAvatarUrl( $user, $avatarSize ) );
	}

	public function getAvatarUrlDataProvider() {
		return [
			// anon
			[
				'url' => '/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/20',
				'userName' => '80.2.3.4',
				'userId' => 0,
				'avatarSize' => 20,
			],
			// logged-in
			[
				'url' => '/images/e/e1/123456/revision/latest/scale-to-width-down/20',
				'userName' => 'TestUser123',
				'userId' => 123456,
				'avatarSize' => 20,
			],
		];
	}

	function testCustomUploadedAvatar() {
		$this->mockGlobalVariable( 'wgVignetteUrl', 'http://vignette.wikia-dev.com' );
		$user = $this->getMock( 'User' );
		$user
			->expects( $this->any() )
			->method( 'getGlobalAttribute' )
			->will( $this->returnValue( '/a/ab/12345.png' ) );

		$masthead = $this->getMock( 'Masthead', [], [$user] );

		$this->assertEquals(
			'http://vignette.wikia-dev.com/common/avatars/a/ab/12345.png/revision/latest/scale-to-width-down/150?cb=789&format=jpg',
			AvatarService::getVignetteUrl( $masthead, 150, 789 )
		);
	}

	function testWikiaAvatar() {
		$this->mockGlobalVariable( 'wgVignetteUrl', 'http://vignette.wikia-dev.com' );
		$user = $this->getMock( 'User' );
		$user
			->expects( $this->any() )
			->method( 'getGlobalAttribute' )
			->will( $this->returnValue( 'Fish.jpg' ) );

		$masthead = $this->getMock( 'Masthead', [], [$user] );

		$this->assertEquals(
			'http://vignette.wikia-dev.com/messaging/images/f/fe/Fish.jpg/revision/latest/scale-to-width-down/150?cb=789&format=jpg',
			AvatarService::getVignetteUrl( $masthead, 150, 789 )
		);
	}

	function testDefaultAvatar() {
		$this->mockGlobalVariable( 'wgVignetteUrl', 'http://vignette.wikia-dev.com' );
		$user = $this->getMock( 'User' );
		$user
			->expects( $this->any() )
			->method( 'getGlobalPreference' )
			->will( $this->returnValue( null ) );

		$masthead = $this->getMock( 'Masthead', [], [$user] );
		$masthead
			->expects( $this->any() )
			->method( 'getDefaultAvatars' )
			->will( $this->returnValue( ['http://images.wikia.com/messaging/images/1/19/Avatar.jpg'] ) );

		$this->assertEquals(
			'http://vignette.wikia-dev.com/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/150?cb=789&format=jpg',
			AvatarService::getVignetteUrl( $masthead, 150, 789 )
		);
	}

	function testRenderLink() {
		$anonName = '10.10.10.10';
		$userName = 'WikiaBot';

		// users
		$this->assertContains('width="32"', AvatarService::render($userName, 32));
		$this->assertContains('User:WikiaBot', AvatarService::renderLink($userName));

		// anons
		$this->assertContains('Special:Contributions/', AvatarService::getUrl($anonName));
		$this->assertRegExp('/^<img src="/', AvatarService::renderAvatar($anonName));
		$this->assertContains('Special:Contributions', AvatarService::renderLink($anonName));
	}

	/**
	 * @dataProvider getVignetteUrlDataProvider
	 */
	function testGetVignetteUrl( $userAttr, $width, $expectedUrl ) {
		$this->mockGlobalVariable( 'wgVignetteUrl', 'http://vignette.wikia-dev.com' );

		$user = $this->mockClassWithMethods( 'User', [
			'getGlobalAttribute' => $userAttr,
		]);
		$masthead = Masthead::newFromUser( $user );
		$url = AvatarService::getVignetteUrl( $masthead, $width, false );

		$this->assertEquals( $expectedUrl, $url );
	}

	function getVignetteUrlDataProvider() {
		return [
			# custom avatars (before migration)
			[
				'e/ee/454959.png',
				16,
				'http://vignette.wikia-dev.com/common/avatars/e/ee/454959.png/revision/latest/scale-to-width-down/16'
			],
			# custom avatars (uploaded via avatars service)
			[
				'http://vignette.wikia-dev.com/3feccb7c-d544-4998-b127-3eba49eb59af',
				16,
				'http://vignette.wikia-dev.com/3feccb7c-d544-4998-b127-3eba49eb59af/scale-to-width-down/16'
			],
			# predefined avatars (before migration)
			[
				'Avatar4.jpg',
				16,
				'http://vignette.wikia-dev.com/messaging/images/e/e5/Avatar4.jpg/revision/latest/scale-to-width-down/16'
			],
			# predefined avatars (after migration)
			[
				'http://images.wikia.com/messaging/images//e/e5/Avatar4.jpg',
				16,
				'http://vignette.wikia-dev.com/messaging/images/e/e5/Avatar4.jpg/revision/latest/scale-to-width-down/16'
			],
		];
	}
}
