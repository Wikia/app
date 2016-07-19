<?php


class WallNotificationsControllerTest extends WikiaBaseTest {
	private $wgOutmScriptsCached = '';

	public function setUp() {
		parent::setUp();
		$this->wgOutmScriptsCached = $this->app->wg->Out->mScripts;
		$this->app->wg->Out->mScripts = '';
	}

	/**
	 * @param $isUserLoggedIn
	 * @param $isUserAllowed
	 * @param $wgAtCreateNewWikiPageValue
	 * @param $hasPrehide
	 *
	 * @dataProvider indexDataProvider
	 */
	public function testIndex( $isUserLoggedIn, $isUserAllowed, $wgAtCreateNewWikiPageValue, $hasPrehide, $desc ) {
		$userMock = $this->getMock( 'User', [ 'isLoggedIn', 'isAllowed' ], [ ], '', false );
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->will( $this->returnValue( $isUserLoggedIn ) );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->will( $this->returnValue( $isUserAllowed ) );

		$this->mockGlobalVariable( 'wgAtCreateNewWikiPage', $wgAtCreateNewWikiPageValue );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$resp = $this->app->sendRequest( 'WallNotificationsController', 'Index', [ 'format' => 'json' ] );
		$this->assertEquals( $hasPrehide, is_bool( $resp->getVal( 'prehide' ) ) );
	}


	/**
	 * @param $expectedMessageId
	 * @param $expectedMessageTemplate
	 * @param $expectedMessage
	 * @param $username
	 * @param $notifyGrouped
	 * @dataProvider notificationDataProvider
	 */
	public function testNotify( $expectedMessageId, $expectedMessageTemplate, $expectedMessage, $username, $notifyGrouped ) {
		//given
		$userMock = $this->getMock( 'User', [ 'getName' ], [ ], '', false );

		$userMock->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( $username ) );
		$userMock->mFrom = 'session';
		$this->mockGlobalVariable( 'wgUser', $userMock );
		$params =
			[
				'parent_id' => 1245,
				'notify' => [ 'grouped' => self::getNotifyGroupMock( $notifyGrouped ) ]
			];

		$this->mockMessage( $expectedMessageId, $expectedMessageTemplate );

		//when
		$resp = $this->app->sendRequest( 'WallNotificationsController', 'Notification', $params );

		//then
		$this->assertEquals( $expectedMessage, $resp->getVal( 'msg' ) );
	}

	/**
	 * @param $notifyGrouped
	 * @return array
	 */
	private function getNotifyGroupMock( $notifyGrouped ) {

		$result = [ ];
		foreach ( $notifyGrouped as $notifyEntity ) {
			$wallNotification = $this->getMock( 'WallNotificationEntity' );
			$wallNotification->expects( $this->any() )
				->method( 'isMain' )
				->will( $this->returnValue( false ) );
			$wallNotification->data = (object)$notifyEntity;
			$result[] = $wallNotification;
		}
		return $result;
	}

	public function indexDataProvider() {
		return [
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => true,
				'1) undefined $wgAtCreateNewWikiPage and user IS logged-in and IS allowed to read -- assets ARE added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => false,
				'2) undefined $wgAtCreateNewWikiPage and user IS NOT logged-in and IS allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => null,
				'hasPrehide' => false,
				'3) undefined $wgAtCreateNewWikiPage and user IS NOT logged-in and IS NOT allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => true,
				'hasPrehide' => false,
				'4) A create new wiki page and user IS NOT logged-in and IS NOT allowed to read -- assets assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => true,
				'hasPrehide' => false,
				'5) A create new wiki page and user IS logged-in and IS allowed to read -- assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => false,
				'isUserAllowed' => false,
				'wgAtCreateNewWikiPageValue' => false,
				'hasPrehide' => false,
				'6) NOT a create new wiki page and user IS NOT logged-in and IS NOT allowed to read -- assets ARE NOT added'
			],
			[
				'isUserLoggedIn' => true,
				'isUserAllowed' => true,
				'wgAtCreateNewWikiPageValue' => false,
				'hasPrehide' => true,
				'7) NOT a create new wiki page and user IS logged-in and IS allowed to read -- assets ARE added'
			],
		];
	}

	public function notificationDataProvider() {
		return [
			[
				'expectedMessageId' => 'wn-user3-reply-you-other-wall',
				'expectedMessageTemplate' => '$1 and others replied to your message on $2\'s wall',
				'expectedMessage' => "Ann and others replied to your message on Crazy frog's wall",
				'username' => 'Tom',
				'notifyGroup' => [
					[ 'msg_author_displayname' => 'Ann',
						'msg_author_username' => 'Ann',
						'wall_username' => 'Crazy frog',
						'wall_displayname' => 'Crazy frog',
						'parent_username' => 'Tom',
						'thread_title' => 'hello message' ],
					[ 'msg_author_displayname' => 'Bob',
						'msg_author_username' => 'Bob',
						'wall_username' => 'Crazy frog',
						'wall_displayname' => 'Crazy frog',
						'parent_username' => 'Tom',
						'thread_title' => 'hello message' ],
					[ 'msg_author_displayname' => 'Crazy frog',
						'msg_author_username' => 'Crazy frog',
						'wall_username' => 'Crazy frog',
						'wall_displayname' => 'Crazy frog',
						'parent_username' => 'Tom',
						'thread_title' => 'hello message' ]
				]
			]
		];
	}

	public function tearDown() {
		parent::tearDown();
		$this->app->wg->Out->mScripts = $this->wgOutmScriptsCached;
		$this->wgOutmScriptsCached = '';
	}

}
