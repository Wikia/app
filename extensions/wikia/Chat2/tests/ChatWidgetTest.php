<?php

class ChatWidgetTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../Chat_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getTemplateNameDataProvider
	 */
	public function testGetTemplateName( $isOasis, $expected ) {
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', $isOasis );

		$templateName = ChatWidget::getTemplateName();

		$this->assertEquals( $expected, $templateName );
	}

	public function getTemplateNameDataProvider() {
		return [
			[
				'isOasis' => true,
				'expected' => 'widget.mustache'
			],
			[
				'isOasis' => false,
				'expected' => 'widgetMonobook.mustache'
			]
		];
	}

	/**
	 * @dataProvider getTemplateVarsDataProvider
	 */
	public function testGetTemplateVars( $fromParserTag, $wgEnableWallExt, $isLoggedIn, $chatUsersInfo, $expected ) {
		// User class mock
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( [ 'getName', 'isAnon', 'isLoggedIn' ] )
			->getMock();
		$userMock->expects(
			$this->any() )
			->method( 'getName' )
			->will( $this->returnValue( 'testUsername' ) );
		$userMock->expects(
			$this->any() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue( $isLoggedIn ) );
		$userMock->mFrom = 'session';

		// Message class mock
		$messageMock = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->setMethods( [ 'exists', 'text', 'parse' ] )
			->getMock();
		$messageMock->expects(
			$this->any() )
			->method( 'exists' )
			->will( $this->returnValue( true ) );
		$messageMock->expects(
			$this->any() )
			->method( 'text' )
			->will( $this->returnValue( 'message' ) );
		$messageMock->expects(
			$this->any() )
			->method( 'parse' )
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
		$this->mockStaticMethod( 'ChatWidget', 'getUsersInfo', $chatUsersInfo );
		$this->mockStaticMethod( 'AvatarService', 'getAvatarUrl', 'www.image.com' );
		$this->mockStaticMethod( 'DesignSystemHelper', 'renderSvg', '<svg></svg>' );

		$vars = ChatWidget::getTemplateVars( $fromParserTag );

		$this->assertEquals( $expected, $vars );
	}

	public function getTemplateVarsDataProvider() {
		return [
			'user from parser tag with message wall' => [
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isLoggedIn' => true,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'buttonIcon' => '<svg></svg>',
					'guidelinesText' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatWidget',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => 'testUsername',
					'viewedUsersInfo' => [ 'User1', 'User2' ],
					'moreUsersCount' => null,
					'hasUsers' => true,
					'chatLiveText' => 'message',
				]
			],
			'user from rail without message wall (null)' => [
				'fromParserTag' => false,
				'wgEnableWallExt' => null,
				'isLoggedIn' => true,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'buttonIcon' => '<svg></svg>',
					'guidelinesText' => 'message',
					'fromParserTag' => false,
					'sectionClassName' => 'rail-module',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'talk-page',
					'userName' => 'testUsername',
					'viewedUsersInfo' => [ 'User1', 'User2' ],
					'moreUsersCount' => null,
					'hasUsers' => true,
					'chatLiveText' => 'message',
				]
			],
			'user from rail without message wall (false)' => [
				'fromParserTag' => false,
				'wgEnableWallExt' => false,
				'isLoggedIn' => true,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'buttonIcon' => '<svg></svg>',
					'guidelinesText' => 'message',
					'fromParserTag' => false,
					'sectionClassName' => 'rail-module',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'talk-page',
					'userName' => 'testUsername',
					'viewedUsersInfo' => [ 'User1', 'User2' ],
					'moreUsersCount' => null,
					'hasUsers' => true,
					'chatLiveText' => 'message',
				]
			],
			'anon from parser tag with message wall' => [
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isLoggedIn' => false,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'buttonIcon' => '<svg></svg>',
					'guidelinesText' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatWidget',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => null,
					'viewedUsersInfo' => [
						[
							'username' => 'testUsername',
							'profileUrl' => '/wiki/User:testUsername',
							'avatarUrl' => 'www.image.com',
						],
					],
					'moreUsersCount' => null,
					'hasUsers' => false,
					'chatLiveText' => 'message',
				]
			],
			'anon from parser tag with no users' => [
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isLoggedIn' => false,
				'chatUsersInfo' => [ ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'buttonIcon' => '<svg></svg>',
					'guidelinesText' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatWidget',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => null,
					'viewedUsersInfo' => [
						[
							'username' => 'testUsername',
							'profileUrl' => '/wiki/User:testUsername',
							'avatarUrl' => 'www.image.com',
						],
					],
					'moreUsersCount' => null,
					'hasUsers' => false,
					'chatLiveText' => 'message',
				]
			],
			'user from parser tag with no users' => [
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isLoggedIn' => true,
				'chatUsersInfo' => [ ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'buttonIcon' => '<svg></svg>',
					'guidelinesText' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatWidget',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => 'testUsername',
					'viewedUsersInfo' => [
						[
							'username' => 'testUsername',
							'profileUrl' => '/wiki/User:testUsername',
							'avatarUrl' => 'www.image.com',
						],
					],
					'moreUsersCount' => null,
					'hasUsers' => false,
					'chatLiveText' => 'message',
				]
			]
		];
	}
}
