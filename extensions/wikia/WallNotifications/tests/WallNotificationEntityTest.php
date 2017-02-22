<?php

class WallNotificationEntityTest extends WikiaBaseTest {
	const A_FANDOM_USER = 'A Fandom user';

	public function setUp() {
		$this->setupFile = __DIR__ . '/../WallNotifications.setup.php';
		parent::setUp();
	}

	/**
	 * Given a revision, verify that wall notification data is properly populated
	 *
	 * @see WallNotificationEntity::createFromRev()
	 * @group Slow
	 * @slowExecutionTime 0.01071 ms
	 * @dataProvider loadDataFromRevDataProvider
	 * @param array $params
	 */
	public function testCreateFromRev( array $params ) {
		$this->setupEnvironmentMocks( $params );
		$this->setupWallMessageMocks( $params );
		$revisionMock = $this->getRevisionMock( $params );

		$entity = WallNotificationEntity::createFromRev( $revisionMock );

		$this->assertInstanceOf( WallNotificationEntity::class, $entity, 'WallNotificationEntity::createFromRev must return instance of WallNotificationEntity if given valid revision' );
		$this->assertEquals( $entity->id, $params['id'], 'Testing "id" matches' );
		$this->assertEquals( $entity->data, $params['data'], 'Member "data" matches' );
		$this->assertEquals( $entity->parentTitleDbKey, $params['parentTitleDbKey'], 'Testing "parentTitleDbKey" matches' );
		$this->assertEquals( $entity->msgText, $params['msgText'], 'Testing "msgText" matches' );
		$this->assertEquals( $entity->threadTitleFull, $params['threadTitleFull'], 'Testing "threadTitleFull" matches' );
	}

	/**
	 * @param array $params
	 */
	private function setupEnvironmentMocks( array $params ) {
		$userMock = $this->getMock( User::class, [ 'getName' ] );
		$userMock->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $params['user']['userName'] );

		$cacheMock = $this->getMockForAbstractClass( BagOStuff::class );
		$cacheMock->expects( $this->once() )
			->method( 'set' )
			->with( WallNotificationEntity::getMemcKey( $params['id'] ), $params['data'] );

		$messageMock = $this->getMockBuilder( Message::class )
			->disableOriginalConstructor()
			->setMethods( [ 'escaped' ] )
			->getMock();
		$messageMock->expects( $this->any() )
			->method( 'escaped' )
			->willReturn( static::A_FANDOM_USER );

		$this->mockClass( User::class, $userMock, 'newFromID' );
		$this->mockGlobalVariable( 'wgMemc', $cacheMock );
		$this->mockGlobalVariable( 'wgCityId', $params['wgCityId'] );
		$this->mockGlobalVariable( 'wgSitename', $params['wgSitename'] );
		$this->mockGlobalFunction( 'wfMessage', $messageMock );
	}

	private function setupWallMessageMocks( array $params ) {
		$wallOwnerMock = $this->getWallOwnerMock( $params );
		$articleTitleMock = $this->getArticleTitleMock( $params );
		$titleMock = $this->getTitleMock( $params );

		$wallMessageMock = $this->getMockBuilder( WallMessage::class )
			->setMethods( [
				'getWallOwner',
				'getArticleTitle',
				'getTitle',
				'getTopParentObj',
				'getText',
				'getMessagePageUrl',
				'getNotifyeveryone',
				'isEdited',
				'getLastEditSummary',
				'getMetaTitle',
				'load'
			] )
			->disableOriginalConstructor()
			->getMock();
		$wallMessageCounter = 0;

		$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
			->method( 'load' );
		$wallMessageCounter++;

		$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
			->method( 'getWallOwner' )
			->willReturn( $wallOwnerMock );
		$wallMessageCounter++;

		$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
			->method( 'getArticleTitle' )
			->willReturn( $articleTitleMock );
		$wallMessageCounter++;

		$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
			->method( 'getText' )
			->willReturn( $params['wallMessage']['text'] );
		$wallMessageCounter++;

		$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
			->method( 'getTitle' )
			->willReturn( $titleMock );
		$wallMessageCounter++;

		$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
			->method( 'getMessagePageUrl' )
			->willReturn( $params['wallMessage']['messagePageUrl'] );
		$wallMessageCounter++;

		$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
			->method( 'getNotifyeveryone' )
			->willReturn( $params['wallMessage']['notifyeveryone'] );
		$wallMessageCounter++;

		$isEdited = $params['wallMessage']['isEdited'];
		$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
			->method( 'isEdited' )
			->willReturn( $isEdited );
		$wallMessageCounter++;

		if ( $isEdited ) {
			$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
				->method( 'getLastEditSummary' )
				->willReturn( $params['wallMessage']['lastEditSummary'] );
			$wallMessageCounter++;
		}

		if ( !empty( $params['parentWallMessage']['id'] ) ) {
			$parentWallMessageMock = $this->getParentWallMessageMock( $params );

			$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
				->method( 'getTopParentObj' )
				->willReturn( $parentWallMessageMock );
		} else {
			$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
				->method( 'getTopParentObj' )
				->willReturn( null );
			$wallMessageCounter++;

			$wallMessageMock->expects( $this->at( $wallMessageCounter ) )
				->method( 'getMetaTitle' )
				->willReturn( $params['wallMessage']['metaTitle'] );
		}

		$this->mockClass( WallMessage::class, $wallMessageMock, 'newFromTitle' );
	}

	/**
	 * @param array $params
	 *
	 * @return PHPUnit_Framework_MockObject_MockObject|Revision
	 */
	private function getRevisionMock( array $params ): PHPUnit_Framework_MockObject_MockObject {
		$rev = $this->getMockBuilder( 'Revision' )
			->setMethods( [
				'getId',
				'getUser',
				'getTimestamp',
				'getTitle'
			] )
			->disableOriginalConstructor()
			->getMock();

		$rev->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $params['revision']['id'] );
		$rev->expects( $this->once() )
			->method( 'getUser' )
			->willReturn( $params['revision']['userId'] );
		$rev->expects( $this->once() )
			->method( 'getTimestamp' )
			->willReturn( $params['revision']['timestamp'] );
		$rev->expects( $this->once() )
			->method( 'getTitle' )
			->willReturn( new Title() );

		return $rev;
	}

	private function getWallOwnerMock( array $params ): PHPUnit_Framework_MockObject_MockObject {
		$wallOwner = $this->getMockBuilder( 'User' )
			->setMethods( [
				'getId',
				'getName',
			])
			->disableOriginalConstructor()
			->getMock();

		$wallOwner->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $params['wallOwner']['id'] );
		$wallOwner->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $params['wallOwner']['name'] );

		return $wallOwner;
	}

	private function getArticleTitleMock( array $params ): PHPUnit_Framework_MockObject_MockObject {
		$articleTitle = $this->getMockBuilder( 'Title' )
			->setMethods( [
				'exists',
				'getNamespace',
				'getText',
				'getDBkey',
				'getArticleId',
			] )
			->disableOriginalConstructor()
			->getMock();

		$articleTitle->expects( $this->once() )
			->method( 'exists' )
			->willReturn( $params['articleTitle']['exists'] );
		$articleTitle->expects( $this->once() )
			->method( 'getNamespace' )
			->willReturn( $params['articleTitle']['namespace'] );
		$articleTitle->expects( $this->once() )
			->method( 'getText' )
			->willReturn( $params['articleTitle']['text'] );
		$articleTitle->expects( $this->once() )
			->method( 'getDBkey' )
			->willReturn( $params['articleTitle']['dbKey'] );
		$articleTitle->expects( $this->once() )
			->method( 'getArticleId' )
			->willReturn( $params['articleTitle']['articleId'] );

		return $articleTitle;
	}

	private function getTitleMock( array $params ): PHPUnit_Framework_MockObject_MockObject {
		$title = $this->getMock( Title::class, [ 'getArticleId' ] );

		$title->expects( $this->once() )
			->method( 'getArticleId' )
			->willReturn( $params['title']['articleId'] );

		return $title;
	}

	private function getParentWallMessageMock( array $params ): PHPUnit_Framework_MockObject_MockObject {
		$parentTitleMock = $this->getParentTitleMock( $params );
		$parentUserMock = $this->getParentUserMock( $params );

		$parentWallMessageMock = $this->getMockBuilder( 'WallMessage' )
			->setMethods( [
				'load', // should do nothing
				'getTitle',
				'getMetaTitle',
				'getId',
				'getUser',
			] )
			->disableOriginalConstructor()
			->getMock();
		$parentWallMessageCounter = 0;


		$parentWallMessageMock->expects( $this->at( $parentWallMessageCounter ) )
			->method( 'load' );
		$parentWallMessageCounter++;

		$parentWallMessageMock->expects( $this->at( $parentWallMessageCounter ) )
			->method( 'getTitle' )
			->willReturn( $parentTitleMock );
		$parentWallMessageCounter++;

		$parentWallMessageMock->expects( $this->at( $parentWallMessageCounter ) )
			->method( 'getMetaTitle' )
			->willReturn( $params['parentWallMessage']['metaTitle'] );
		$parentWallMessageCounter++;

		$parentWallMessageMock->expects( $this->at( $parentWallMessageCounter ) )
			->method( 'getUser' )
			->willReturn( $parentUserMock );
		$parentWallMessageCounter++;

		$parentWallMessageMock->expects( $this->at( $parentWallMessageCounter ) )
			->method( 'getId' )
			->willReturn( $params['parentWallMessage']['id'] );

		return $parentWallMessageMock;
	}

	private function getParentTitleMock( array $params ): PHPUnit_Framework_MockObject_MockObject {
		$parentTitleMock = $this->getMock( Title::class, [ 'getDBkey' ] );

		$parentTitleMock->expects( $this->once() )
			->method( 'getDBkey' )
			->willReturn( $params['parentTitle']['dbKey'] );

		return $parentTitleMock;
	}

	private function getParentUserMock( array $params ): PHPUnit_Framework_MockObject_MockObject {
		$parentUserMock = $this->getMockBuilder( User::class )
			->setMethods( [ 'getId', 'getName' ] )
			->disableOriginalConstructor()
			->getMock();

		$parentUserMock->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $params['parentUser']['name'] );

		$parentUserMock->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $params['parentUser']['id'] );

		return $parentUserMock;
	}

	public function loadDataFromRevDataProvider(): array {
		$anonTopic = [
			'revision' => [
				'id' => '5330',
				'userId' => '0',
				'timestamp' => '20150601200409',
			],
			'wallOwner' => [
				'id' => '2035791',
				'name' => 'Garthwebb',
			],
			'articleTitle' => [
				'exists' => true,
				'namespace' => '1200',
				'text' => 'Garthwebb',
				'dbKey' => 'Garthwebb',
				'articleId' => '2147',
			],
			'title' => [
				'articleId' => '2751',
			],
			'wallMessage' => [
				'text' => '<p>This is an anon topic to a message wall.
</p>',
				'messagePageUrl' => 'http://garth.garth.wikia-dev.com/wiki/Thread:2751',
				'notifyeveryone' => false,
				'isEdited' => false,
				'lastEditSummary' => 'Created page with "This is an anon topic to a message wall.<ac_metadata title="Anon Topic"> </ac_metadata>',
				'metaTitle' => 'Anon Topic',
			],
			'parentWallMessage' => [
				'id' => 0,
			],
			'parentTitle' => [
				'dbKey' => ''
			],
			'parentUser' => [
			],
			'user' => [
				'userName' => '65.19.148.1',
			],
			'data' => (object) [
				'wiki' => '125951',
				'wikiname' => 'Garth Wiki',
				'rev_id' => '5330',
				'article_title_ns' => '1200',
				'article_title_text' => 'Garthwebb',
				'article_title_dbkey' => 'Garthwebb',
				'article_title_id' => '2147',
				'timestamp' => '20150601200409',
				'parent_id' => null,
				'parent_page_id' => '2147',
				'msg_author_id' => 0,
				'msg_author_username' => '65.19.148.1',
				'msg_author_displayname' => static::A_FANDOM_USER,
				'wall_username' => 'Garthwebb',
				'wall_userid' => '2035791',
				'wall_displayname' => 'Garthwebb',
				'title_id' => '2751',
				'parent_username' => 'Garthwebb',
				'thread_title' => 'Anon Topic',
				'notifyeveryone' => false,
				'reason' => '',
				'url' => 'http://garth.garth.wikia-dev.com/wiki/Thread:2751',
			],
			'id' => '5330_125951',
			'parentTitleDbKey' => '',
			'msgText' => '<p>This is an anon topic to a message wall.
</p>',
			'threadTitleFull' => 'Anon Topic',
			'wgSitename' => 'Garth Wiki',
			'wgCityId' => '125951',
		];

		$anonReply = [
			'revision' => [
				'id' => '5331',
				'userId' => '0',
				'timestamp' => '20150601200611',
			],
			'wallOwner' => [
				'id' => '2035791',
				'name' => 'Garthwebb',
			],
			'articleTitle' => [
				'exists' => true,
				'namespace' => '1200',
				'text' => 'Garthwebb',
				'dbKey' => 'Garthwebb',
				'articleId' => '2147',
			],
			'title' => [
				'articleId' => '2752',
			],
			'wallMessage' => [
				'text' => '<p>This is an anonymous reply.  W00t!
</p>',
				'messagePageUrl' => 'http://garth.garth.wikia-dev.com/wiki/Thread:2735#2',
				'notifyeveryone' => false,
				'isEdited' => false,
				'lastEditSummary' => 'Created page with "This is an anonymous reply.  W00t!"',
				'metaTitle' => '',
			],
			'parentWallMessage' => [
				'id' => '2735',
				'metaTitle' => 'bleep de bloop',
			],
			'parentTitle' => [
				'dbKey' => 'Garthwebb/@comment-GarthTest800-20150527211624',
			],
			'parentUser' => [
				'id' => '23911114',
				'name' => 'GarthTest800',
			],
			'user' => [
				'userName' => '65.19.148.1',
			],
			'data' => (object) [
				'wiki' => '125951',
				'wikiname' => 'Garth Wiki',
				'rev_id' => '5331',
				'article_title_ns' => '1200',
				'article_title_text' => 'Garthwebb',
				'article_title_dbkey' => 'Garthwebb',
				'article_title_id' => '2147',
				'timestamp' => '20150601200611',
				'parent_id' => '2735',
				'parent_page_id' => '2147',
				'msg_author_id' => '0',
				'msg_author_username' => '65.19.148.1',
				'msg_author_displayname' => static::A_FANDOM_USER,
				'wall_username' => 'Garthwebb',
				'wall_userid' => '2035791',
				'wall_displayname' => 'Garthwebb',
				'title_id' => '2752',
				'parent_username' => 'GarthTest800',
				'thread_title' => 'bleep de bloop',
				'notifyeveryone' => false,
				'reason' => '',
				'parent_displayname' => 'GarthTest800',
				'parent_user_id' => '23911114',
				'url' => 'http://garth.garth.wikia-dev.com/wiki/Thread:2735#2',
			],
			'id' => '5331_125951',
			'parentTitleDbKey' => 'Garthwebb/@comment-GarthTest800-20150527211624',
			'msgText' => '<p>This is an anonymous reply.  W00t!
</p>',
			'threadTitleFull' => 'bleep de bloop',
			'wgSitename' => 'Garth Wiki',
			'wgCityId' => '125951',
		];

		$userTopic = [
			'revision' => [
				'id' => '5332',
				'userId' => '23910831',
				'timestamp' => '20150601200858',
			],
			'wallOwner' => [
				'id' => '2035791',
				'name' => 'Garthwebb',
			],
			'articleTitle' => [
				'exists' => true,
				'namespace' => '1200',
				'text' => 'Garthwebb',
				'dbKey' => 'Garthwebb',
				'articleId' => '2147',
			],
			'title' => [
				'articleId' => '2753',
			],
			'wallMessage' => [
				'text' => '<p>This topic is from a logged in user.  Sweet.
</p>',
				'messagePageUrl' => 'http://garth.garth.wikia-dev.com/wiki/Thread:2753',
				'notifyeveryone' => false,
				'isEdited' => false,
				'lastEditSummary' => 'Created page with "This topic is from a logged in user.  Sweet.<ac_metadata title="Logged in topic"> </ac_metadata>',
				'metaTitle' => 'Logged in topic',
			],
			'parentWallMessage' => [
				'id' => 0,
			],
			'parentTitle' => [
				'dbKey' => '',
			],
			'parentUser' => [
			],
			'user' => [
				'userName' => 'GarthTest400',
			],
			'data' => (object) [
				'wiki' => '125951',
				'wikiname' => 'Garth Wiki',
				'rev_id' => '5332',
				'article_title_ns' => '1200',
				'article_title_text' => 'Garthwebb',
				'article_title_dbkey' => 'Garthwebb',
				'article_title_id' => '2147',
				'timestamp' => '20150601200858',
				'parent_id' => '',
				'parent_page_id' => '2147',
				'msg_author_id' => '23910831',
				'msg_author_username' => 'GarthTest400',
				'msg_author_displayname' => 'GarthTest400',
				'wall_username' => 'Garthwebb',
				'wall_userid' => '2035791',
				'wall_displayname' => 'Garthwebb',
				'title_id' => '2753',
				'parent_username' => 'Garthwebb',
				'thread_title' => 'Logged in topic',
				'notifyeveryone' => '',
				'reason' => '',
				'url' => 'http://garth.garth.wikia-dev.com/wiki/Thread:2753',
			],
			'id' => '5332_125951',
			'parentTitleDbKey' => '',
			'msgText' => '<p>This topic is from a logged in user.  Sweet.
</p>',
			'threadTitleFull' => 'Logged in topic',
			'wgSitename' => 'Garth Wiki',
			'wgCityId' => '125951',
		];

		$userReply = [
			'revision' => [
				'id' => '5333',
				'userId' => '23910831',
				'timestamp' => '20150601201011',
			],
			'wallOwner' => [
				'id' => '2035791',
				'name' => 'Garthwebb',
			],
			'articleTitle' => [
				'exists' => true,
				'namespace' => '1200',
				'text' => 'Garthwebb',
				'dbKey' => 'Garthwebb',
				'articleId' => '2147',
			],
			'title' => [
				'articleId' => '2754',
			],
			'wallMessage' => [
				'text' => '<p>Loggedin user replying to a anon topic.
</p>',
				'messagePageUrl' => 'http://garth.garth.wikia-dev.com/wiki/Thread:2726#2',
				'notifyeveryone' => false,
				'isEdited' => false,
				'lastEditSummary' => 'Created page with "Loggedin user replying to a anon topic."',
				'metaTitle' => '',
			],
			'parentWallMessage' => [
				'id' => '2726',
				'metaTitle' => "Hey hey I'm anon",
			],
			'parentTitle' => [
				'dbKey' => 'Garthwebb/@comment-65.19.148.1-20150522005011',
			],
			'parentUser' => [
				'id' => '0',
				'name' => '65.19.148.1',
			],
			'user' => [
				'userName' => 'GarthTest400',
			],
			'data' => (object) [
				'wiki' => '125951',
				'wikiname' => 'Garth Wiki',
				'rev_id' => '5333',
				'article_title_ns' => '1200',
				'article_title_text' => 'Garthwebb',
				'article_title_dbkey' => 'Garthwebb',
				'article_title_id' => '2147',
				'timestamp' => '20150601201011',
				'parent_id' => '2726',
				'parent_page_id' => '2147',
				'msg_author_id' => '23910831',
				'msg_author_username' => 'GarthTest400',
				'msg_author_displayname' => 'GarthTest400',
				'wall_username' => 'Garthwebb',
				'wall_userid' => '2035791',
				'wall_displayname' => 'Garthwebb',
				'title_id' => '2754',
				'parent_username' => '65.19.148.1',
				'thread_title' => "Hey hey I'm anon",
				'notifyeveryone' => '',
				'reason' => '',
				'parent_displayname' => static::A_FANDOM_USER,
				'parent_user_id' => '0',
				'url' => 'http://garth.garth.wikia-dev.com/wiki/Thread:2726#2',
			],
			'id' => '5333_125951',
			'parentTitleDbKey' => 'Garthwebb/@comment-65.19.148.1-20150522005011',
			'msgText' => '<p>Loggedin user replying to a anon topic.
</p>',
			'threadTitleFull' => "Hey hey I'm anon",
			'wgSitename' => 'Garth Wiki',
			'wgCityId' => '125951',
		];

		return [
			[ $anonTopic ],
			[ $anonReply ],
			[ $userTopic ],
			[ $userReply ],
		];
	}
}
