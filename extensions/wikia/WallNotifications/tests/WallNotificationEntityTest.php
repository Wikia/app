<?php

/**
 * Class WallNotificationEntityTest
 */
class WallNotificationEntityTest extends WikiaBaseTest {

	/**
	 * @param $params
	 *
	 * @dataProvider loadDataFromRevDataProvider
	 */
	public function testLoadDataFromRev( $params ) {
		F::app()->wg->Sitename = $params['wgSitename'];
		F::app()->wg->CityId = $params['wgCityId'];

		$rev = $this->getRevisionMock( $params );
		$entity = $this->getEntityMock( $rev, $params );

		$entity->loadDataFromRev( $rev );

		$this->assertEquals( $entity->id, $params['id'], 'Testing "id" matches' );
		$this->assertEquals( $entity->data, $params['data'], 'Member "data" matches' );
		$this->assertEquals( $entity->parentTitleDbKey, $params['parentTitleDbKey'], 'Testing "parentTitleDbKey" matches' );
		$this->assertEquals( $entity->msgText, $params['msgText'], 'Testing "msgText" matches' );
		$this->assertEquals( $entity->threadTitleFull, $params['threadTitleFull'], 'Testing "threadTitleFull" matches' );
	}

	/**
	 * @param Revision $rev
	 * @param array $params
	 *
	 * @return PHPUnit_Framework_MockObject_MockObject|WallNotificationEntity
	 */
	private function getEntityMock( Revision $rev, array $params ) {
		$wm = $this->getWallMessageMock( $params );

		$entity = $this->getMockBuilder( 'WallNotificationEntity' )
			->setMethods( [
				'getUserName',
				'getWallMessageFromRev',
			] )
			->disableOriginalConstructor()
			->getMock();

		$entity->expects( $this->once() )
			->method( 'getUserName' )
			->willReturn( $params['entity']['userName'] );
		$entity->expects( $this->once() )
			->method( 'getWallMessageFromRev' )
			->with( $this->equalTo( $rev ) )
			->willReturn( $wm );

		return $entity;
	}

	private function getWallMessageMock( array $params ) {
		$wallOwner = $this->getWallOwnerMock( $params );
		$articleTitle = $this->getArticleTitleMock( $params );
		$title = $this->getTitleMock( $params );
		$parentWm = $this->getParentWallMessageMock( $params );

		$wm = $this->getMockBuilder( 'WallMessage' )
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
			] )
			->disableOriginalConstructor()
			->getMock();

		$wm->expects( $this->once() )
			->method( 'getWallOwner' )
			->willReturn( $wallOwner );
		$wm->expects( $this->once() )
			->method( 'getArticleTitle' )
			->willReturn( $articleTitle );
		$wm->expects( $this->once() )
			->method( 'getTitle' )
			->willReturn( $title );
		$wm->expects( $this->once() )
			->method( 'getTopParentObj' )
			->willReturn( $parentWm );
		$wm->expects( $this->once() )
			->method( 'getText' )
			->willReturn( $params['wallMessage']['text'] );
		$wm->expects( $this->once() )
			->method( 'getMessagePageUrl' )
			->willReturn( $params['wallMessage']['messagePageUrl'] );
		$wm->expects( $this->once() )
			->method( 'getNotifyeveryone' )
			->willReturn( $params['wallMessage']['notifyeveryone'] );
		$wm->expects( $this->once() )
			->method( 'isEdited' )
			->willReturn( $params['wallMessage']['isEdited'] );
		$wm->expects( $this->any() )
			->method( 'getLastEditSummary' )
			->willReturn( $params['wallMessage']['lastEditSummary'] );
		$wm->expects( $this->any() )
			->method( 'getMetaTitle' )
			->willReturn( $params['wallMessage']['metaTitle'] );

		return $wm;
	}

	/**
	 * @param array $params
	 *
	 * @return PHPUnit_Framework_MockObject_MockObject|Revision
	 */
	private function getRevisionMock( array $params ) {
		$rev = $this->getMockBuilder( 'Revision' )
			->setMethods( [
				'getId',
				'getUser',
				'getTimestamp',
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

		return $rev;
	}

	private function getWallOwnerMock( array $params ) {
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

	private function getArticleTitleMock( array $params ) {
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

	private function getTitleMock( array $params ) {
		$title = $this->getMockBuilder( 'Title' )
			->setMethods( [
				'getArticleId',
			] )
			->disableOriginalConstructor()
			->getMock();

		$title->expects( $this->once() )
			->method( 'getArticleId' )
			->willReturn( $params['title']['articleId'] );

		return $title;
	}

	private function getParentWallMessageMock( array $params ) {
		if ( empty( $params['parentWallMessage']['id'] ) ) {
			return null;
		}

		$parentTitle = $this->getParentTitleMock( $params );
		$parentUser = $this->getParentUserMock( $params );

		$parentWm = $this->getMockBuilder( 'WallMessage' )
			->setMethods( [
				'load', // should do nothing
				'getTitle',
				'getMetaTitle',
				'getId',
				'getUser',
			] )
			->disableOriginalConstructor()
			->getMock();

		$parentWm->expects( $this->once() )
			->method( 'load' );
		$parentWm->expects( $this->once() )
			->method( 'getTitle' )
			->willReturn( $parentTitle );
		$parentWm->expects( $this->any() )
			->method( 'getMetaTitle' )
			->willReturn( $params['parentWallMessage']['metaTitle'] );
		$parentWm->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $params['parentWallMessage']['id'] );
		$parentWm->expects( $this->once() )
			->method( 'getUser' )
			->willReturn( $parentUser );

		return $parentWm;
	}

	private function getParentTitleMock( array $params ) {
		$parentTitle = $this->getMockBuilder( 'Title' )
			->setMethods( [
				'getDBkey',
			] )
			->disableOriginalConstructor()
			->getMock();

		$parentTitle->expects( $this->once() )
			->method( 'getDBkey' )
			->willReturn( $params['parentTitle']['dbKey'] );

		return $parentTitle;
	}

	private function getParentUserMock( array $params ) {
		$parentTitle = $this->getMockBuilder( 'User' )
			->setMethods( [
				'getId',
				'getName',
			] )
			->disableOriginalConstructor()
			->getMock();

		$parentTitle->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $params['parentUser']['id'] );
		$parentTitle->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $params['parentUser']['name'] );

		return $parentTitle;
	}

	public function loadDataFromRevDataProvider() {
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
			'entity' => [
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
				'msg_author_displayname' => 'A Wikia contributor',
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
			'entity' => [
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
				'msg_author_displayname' => 'A Wikia contributor',
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
			'entity' => [
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
			'entity' => [
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
				'parent_displayname' => 'A Wikia contributor',
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
