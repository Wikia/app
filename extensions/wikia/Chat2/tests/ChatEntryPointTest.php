<?php

class ChatEntryPointTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../Chat_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testGetChatTemplateNameDataProvider
	 */
	public function testGetChatTemplateName( $isOasis, $expected ) {
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', $isOasis );

		$templateName = ChatEntryPoint::getChatTemplateName();

		$this->assertEquals( $expected, $templateName );
	}

	public function testGetChatTemplateNameDataProvider() {
		return [
			[
				'isOasis' => true,
				'expected' => 'entryPointTag.mustache'
			],
			[
				'isOasis' => false,
				'expected' => 'entryPointTagMonobook.mustache'
			]
		];
	}

	/**
	 * @dataProvider testGetEntryPointTemplateVarsDataProvider
	 */
	public function testGetEntryPointTemplateVars( $fromParserTag, $wgEnableWallExt, $isAnon, $chatUsersInfo, $expected ) {
		// User class mock
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( [ 'getName', 'isAnon' ] )
			->getMock();
		$userMock->expects(
			$this->any() )
			->method( 'getName' )
			->will( $this->returnValue( 'testUsername' ) );
		$userMock->expects(
			$this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );
		$userMock->mFrom = 'session';

		// Message class mock
		$messageMock = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->setMethods( [ 'exists', 'text' ] )
			->getMock();
		$messageMock->expects(
			$this->any() )
			->method( 'exists' )
			->will( $this->returnValue( true ) );
		$messageMock->expects(
			$this->any() )
			->method( 'text' )
			->will( $this->returnValue( 'message' ) );

		// Title class mock
		$titleMock = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'escapeLocalUrl' ] )
			->getMock();
		$titleMock->expects(
			$this->any() )
			->method( 'escapeLocalUrl' )
			->will( $this->returnValue( 'Chat' ) );

		$mockMsg = $this->getGlobalFunctionMock( 'wfMessage' );
		$mockMsg->expects( $this->any() )
			->method( 'wfMessage' )
			->will( $this->returnValue( $messageMock ) );

		// classes mocks
		$this->mockClass( 'Title', $titleMock );

		// global variables mocks
		$this->mockGlobalVariable( 'wgEnableWallExt', $wgEnableWallExt );
		$this->mockGlobalVariable( 'wgBlankImgUrl', 'www.url.com' );
		$this->mockGlobalVariable( 'wgSitename', 'Test wikia' );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		// static method mocks
		$this->mockStaticMethod( 'ChatEntryPoint', 'getChatUsersInfo', $chatUsersInfo );
		$this->mockStaticMethod( 'AvatarService', 'getAvatarUrl', 'www.image.com' );

		$vars = ChatEntryPoint::getEntryPointTemplateVars( $fromParserTag );

		$this->assertEquals( $expected, $vars );
	}

	public function testGetEntryPointTemplateVarsDataProvider() {
		return [
			[
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isAnon' => false,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'chatUsers' => [ 'User1', 'User2' ],
					'chatUsersCount' => 2,
					'entryPointGuidelinesMessage' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatEntryPoint',
					'joinTheChatMessage' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => 'testUsername',
				]
			],
			[
				'fromParserTag' => false,
				'wgEnableWallExt' => null,
				'isAnon' => false,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'chatUsers' => [ 'User1', 'User2' ],
					'chatUsersCount' => 2,
					'entryPointGuidelinesMessage' => 'message',
					'fromParserTag' => false,
					'sectionClassName' => 'module',
					'joinTheChatMessage' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'talk-page',
					'userName' => 'testUsername',
				]
			],
			[
				'fromParserTag' => false,
				'wgEnableWallExt' => false,
				'isAnon' => false,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'chatUsers' => [ 'User1', 'User2' ],
					'chatUsersCount' => 2,
					'entryPointGuidelinesMessage' => 'message',
					'fromParserTag' => false,
					'sectionClassName' => 'module',
					'joinTheChatMessage' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'talk-page',
					'userName' => 'testUsername',
				]
			],
			[
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isAnon' => true,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'chatUsers' => [ 'User1', 'User2' ],
					'chatUsersCount' => 2,
					'entryPointGuidelinesMessage' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatEntryPoint',
					'joinTheChatMessage' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => null,
				]
			],
			[
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isAnon' => true,
				'chatUsersInfo' => [ ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'chatUsers' => [ ],
					'chatUsersCount' => 0,
					'entryPointGuidelinesMessage' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatEntryPoint',
					'joinTheChatMessage' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => null,
					'chatProfileAvatarUrl' => 'www.image.com'
				]
			]
		];
	}
}
