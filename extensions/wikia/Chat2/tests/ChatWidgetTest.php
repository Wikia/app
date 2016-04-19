<?php

class ChatWidgetTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../Chat_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testGetTemplateNameDataProvider
	 */
	public function testGetTemplateName( $isOasis, $expected ) {
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', $isOasis );

		$templateName = ChatWidget::getTemplateName();

		$this->assertEquals( $expected, $templateName );
	}

	public function testGetTemplateNameDataProvider() {
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
	 * @dataProvider testGeTemplateVarsDataProvider
	 */
	public function testGetTemplateVars( $fromParserTag, $wgEnableWallExt, $isAnon, $chatUsersInfo, $expected ) {
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

		$vars = ChatWidget::getTemplateVars( $fromParserTag );

		$this->assertEquals( $expected, $vars );
	}

	public function testGeTemplateVarsDataProvider() {
		return [
			[
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isAnon' => false,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'guidelinesText' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatWidget',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => 'testUsername',
					'users' => [ 'User1', 'User2' ],
					'usersCount' => 2,
				]
			],
			[
				'fromParserTag' => false,
				'wgEnableWallExt' => null,
				'isAnon' => false,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'guidelinesText' => 'message',
					'fromParserTag' => false,
					'sectionClassName' => 'module',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'talk-page',
					'userName' => 'testUsername',
					'users' => [ 'User1', 'User2' ],
					'usersCount' => 2,
				]
			],
			[
				'fromParserTag' => false,
				'wgEnableWallExt' => false,
				'isAnon' => false,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'guidelinesText' => 'message',
					'fromParserTag' => false,
					'sectionClassName' => 'module',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'talk-page',
					'userName' => 'testUsername',
					'users' => [ 'User1', 'User2' ],
					'usersCount' => 2,
				]
			],
			[
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isAnon' => true,
				'chatUsersInfo' => [ 'User1', 'User2' ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'guidelinesText' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatWidget',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => null,
					'users' => [ 'User1', 'User2' ],
					'usersCount' => 2,
				]
			],
			[
				'fromParserTag' => true,
				'wgEnableWallExt' => true,
				'isAnon' => true,
				'chatUsersInfo' => [ ],
				'expected' => [
					'blankImgUrl' => 'www.url.com',
					'buttonText' => 'message',
					'guidelinesText' => 'message',
					'fromParserTag' => true,
					'sectionClassName' => 'ChatWidget',
					'joinChatText' => 'message',
					'linkToSpecialChat' => 'Chat',
					'siteName' => 'Test wikia',
					'profileType' => 'message-wall',
					'userName' => null,
					'myAvatarUrl' => 'www.image.com',
					'users' => [ ],
					'usersCount' => 0,
				]
			]
		];
	}
}
