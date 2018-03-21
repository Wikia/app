<?php

/**
 * @group Avatar
 */
class AvatarServiceTest extends WikiaBaseTest {

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
				'url' => '/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/20',
				'width' =>  AvatarService::AVATAR_SIZE_SMALL,
			],
			[
				'url' => '/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/50',
				'width' =>  AvatarService::AVATAR_SIZE_MEDIUM,
			],
			[
				'url' => '/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/35',
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
		$this->mockGlobalVariable( 'wgVignetteUrl', 'https://vignette.wikia-dev.com' );
		$user = $this->getMock( 'User' );
		$user
			->expects( $this->any() )
			->method( 'getGlobalAttribute' )
			->will( $this->returnValue( '/a/ab/12345.png' ) );

		$masthead = $this->getMock( 'Masthead', [], [$user] );

		$this->assertEquals(
			'https://vignette.wikia-dev.com/common/avatars/a/ab/12345.png/revision/latest/scale-to-width-down/150?cb=789&format=jpg',
			AvatarService::getVignetteUrl( $masthead, 150, 789 )
		);
	}

	function testWikiaAvatar() {
		$this->mockGlobalVariable( 'wgVignetteUrl', 'https://vignette.wikia-dev.com' );
		$user = $this->getMock( 'User' );
		$user
			->expects( $this->any() )
			->method( 'getGlobalAttribute' )
			->will( $this->returnValue( 'Fish.jpg' ) );

		$masthead = $this->getMock( 'Masthead', [], [$user] );

		$this->assertEquals(
			'https://vignette.wikia-dev.com/messaging/images/f/fe/Fish.jpg/revision/latest/scale-to-width-down/150?cb=789&format=jpg',
			AvatarService::getVignetteUrl( $masthead, 150, 789 )
		);
	}

	function testDefaultAvatar() {
		$this->mockGlobalVariable( 'wgVignetteUrl', 'https://vignette.wikia-dev.com' );
		$user = $this->getMock( 'User' );
		$user
			->expects( $this->any() )
			->method( 'getGlobalPreference' )
			->will( $this->returnValue( null ) );

		$masthead = $this->getMock( 'Masthead', [], [$user] );
		$masthead
			->expects( $this->any() )
			->method( 'getDefaultAvatars' )
			->will( $this->returnValue( ['https://vignette.wikia-dev.com/messaging/images/1/19/Avatar.jpg/revision/latest'] ) );

		$this->assertEquals(
			'https://vignette.wikia-dev.com/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/150',
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
	 * SUS-1507: Verify that default avatar for anon users has "A Fandom User" message as alt text
	 */
	public function testAltTextForAnonAvatarsUsesMediaWikiMessage() {
		$messageMock = $this->getMockBuilder( Message::class )
			->setMethods( [ 'text' ] )
			->disableOriginalConstructor()
			->getMock();

		$messageMock->expects( $this->once() )
			->method( 'text' )
			->willReturn( 'A Fandom User' );

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->once() )
			->method( 'wfMessage' )
			->with( 'oasis-anon-user' )
			->willReturn( $messageMock );

		$this->mockGlobalFunction( 'getMessageForContentAsArray', [] );

		$avatarTag = AvatarService::renderAvatar( '8.8.8.8', 20 );

		$this->assertEquals(
			'<img src="' . AvatarService::getDefaultAvatar( 20 ) . '" width="20" height="20" class="avatar" alt="A Fandom User" />',
			$avatarTag
		);
	}

	/**
	 * @dataProvider getVignetteUrlDataProvider
	 */
	function testGetVignetteUrl( $userAttr, $width, $expectedUrl ) {
		$this->mockGlobalVariable( 'wgVignetteUrl', 'http://vignette.wikia-dev.com' );

		/** @var User $user */
		$user = $this->createConfiguredMock( User::class, [
			'getGlobalAttribute' => $userAttr,
		] );

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
			# SUS-4181 | URLs with width provided
			[
				'http://vignette.wikia-dev.com/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/150',
				150,
				'http://vignette.wikia-dev.com/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/150?format=jpg'
			],
			[
				'http://vignette.wikia-dev.com/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/150',
				16,
				'http://vignette.wikia-dev.com/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/16'
			],
			[
				'http://vignette.wikia-dev.com/a05b75cd-a3de-41f3-8c1c-064e366c086b/scale-to-width-down/150',
				150,
				'http://vignette.wikia-dev.com/a05b75cd-a3de-41f3-8c1c-064e366c086b/scale-to-width-down/150'
			],
		];
	}
}
