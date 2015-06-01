<?php

/**
 * Class WallNotificationEntityTest
 */
class WallNotificationEntityTest extends WikiaBaseTest {

	public function testLoadDataFromRev( $params ) {
		$rev = $this->getRevisionMock( $params );
		$entity = $this->getEntityMock( $rev, $params );

		$entity->loadDataFromRev( $rev );

		$this->assertEquals( $entity->id, $params['id'] );
		$this->assertEquals( $entity->data, $params['data'] );
		$this->assertEquals( $entity->parentTitleDbKey, $params['parentTitleDbKey'] );
		$this->assertEquals( $entity->msgText, $params['msgText'] );
		$this->assertEquals( $entity->threadTitleFull, $params['threadTitleFull'] );
	}

	/**
	 * @param Revision $rev
	 * @param array $params
	 *
	 * @return PHPUnit_Framework_MockObject_MockObject|WallNotificationEntity
	 */
	private function getEntityMock( Revision $rev, array $params ) {
		$wm = $this->getWallMessageMock( $params );

		$entity = $this->getMock( 'WallNotificationEntity', [
			'getUserName',
			'getWallMessageFromRev'
		] );

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

		$wm = $this->getMock( 'WallMessage', [
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
		] );
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
		$wm->expects( $this->once() )
			->method( 'getLastEditSummary' )
			->willReturn( $params['wallMessage']['lastEditSummary'] );
		$wm->expects( $this->once() )
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
		$rev = $this->getMock( 'Revision', [
			'getId',
			'getUser',
			'getTimestamp',
		] );
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
		$wallOwner = $this->getMock( 'User', [
			'getId',
			'getName',
		]);
		$wallOwner->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $params['wallOwner']['id'] );
		$wallOwner->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $params['wallOwner']['name'] );

		return $wallOwner;
	}

	private function getArticleTitleMock( array $params ) {
		$articleTitle = $this->getMock( 'Title', [
			'exists',
			'getNamespace',
			'getText',
			'getDBkey',
			'getArticleId',
		] );
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
		$title = $this->getMock( 'Title', [
			'getArticleId',
		] );
		$title->expects( $this->once() )
			->method( 'getArticleId' )
			->willReturn( $params['title']['articleId'] );

		return $title;
	}

	private function getParentWallMessageMock( array $params ) {
		$parentTitle = $this->getParentTitleMock( $params );

		$parentWm = $this->getMock( 'WallMessage', [
			'load', // should do nothing
			'getTitle',
			'getMetaTitle',
			'getId',
			'getUser',
		] );
		$parentWm->expects( $this->once() )
			->method( 'load' );
		$parentWm->expects( $this->once() )
			->method( 'getTitle' )
			->willReturn( $parentTitle );
		$parentWm->expects( $this->once() )
			->method( 'getMetaTitle' )
			->willReturn( $params['parentWallMessage']['metaTitle'] );
		$parentWm->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $params['parentWallMessage']['id'] );
		$parentWm->expects( $this->once() )
			->method( 'getUser' )
			->willReturn( $params['parentWallMessage']['user'] );

		return $parentWm;
	}

	private function getParentTitleMock( array $params ) {
		$parentTitle = $this->getMock( 'Title', [
			'getDBkey',
		] );
		$parentTitle->expects( $this->once() )
			->method( 'getDBkey' )
			->willReturn( $params['parentTitle']['dbKey'] );

		return $parentTitle;
	}

	public function loadDataFromRevDataProvider() {
		return [
			[
				'revision' => [
					'id' => '',
					'userId' => '',
					'timestamp' => '',
				],
				'wallOwner' => [
					'id' => '',
					'name' => '',
				],
				'articleTitle' => [
					'exists' => '',
					'namespace' => '',
					'text' => '',
					'dbKey' => '',
					'articleId' => '',
				],
				'title' => [
					'articleId' => '',
				],
				'wallMessage' => [
					'text' => '',
					'messagePageUrl' => '',
					'notifyeveryone' => '',
					'isEdited' => '',
					'lastEditSummary' => '',
					'metaTitle' => '',
				],
				'data' => [

				],
				'id' => '',
				'parentTitleDbKey' => '',
				'msgText' => '',
				'threadTitleFull' => '',
			],
			[ // Anonymous topic
				'revision' => [
					'id' => '5329',
					'userId' => '0',
					'timestamp' => '20150601192816',
				],
				'wallOwner' => [
					'id' => '2035791',
					'name' => 'Garthwebb',
				],
				'articleTitle' => [
					'exists' => '',
					'namespace' => '',
					'text' => '',
					'dbKey' => '',
					'articleId' => '',
				],
				'title' => [
					'articleId' => '',
				],
				'wallMessage' => [
					'text' => '',
					'messagePageUrl' => '',
					'notifyeveryone' => '',
					'isEdited' => '',
					'lastEditSummary' => '',
					'metaTitle' => '',
				],
				'data' => [

				],
				'id' => '',
				'parentTitleDbKey' => '',
				'msgText' => '',
				'threadTitleFull' => '',
			]
		];
	}
}

/*

			$acParent->load();
			$title = $acParent->getTitle();
			$this->parentTitleDbKey = $title->getDBkey();
			$this->threadTitleFull = $acParent->getMetaTitle();

			$this->setMessageParentUserData( $data, $acParent );
			$data->parent_id = $acParent->getId();
			$data->thread_title = $acParent->getMetaTitle();

		$this->msgText = $wm->getText();
		$data->parent_page_id = $wm->getArticleTitle()->getArticleId();
		$data->title_id = $wm->getTitle()->getArticleId();
		$data->url = $wm->getMessagePageUrl();

		$data->notifyeveryone = $wm->getNotifyeveryone();
		$data->reason = $wm->isEdited() ? $wm->getLastEditSummary() : '';

exists() ) {
			$data->article_title_ns = $wallTitle->getNamespace();
			$data->article_title_text = $wallTitle->getText();
			$data->article_title_dbkey = $wallTitle->getDBkey();
			$data->article_title_id = $wallTitle->getArticleId();


		$this->setMessageAuthorData( $data, $rev->getUser() );
		$this->id = $rev->getId() . '_' .  $data->wiki;
		$data->rev_id = $rev->getId();
		$data->timestamp = $rev->getTimestamp();

		// Set all data related to the WallMessage
		$wm = WallMessage::newFromTitle( $rev->getTitle() );
*/