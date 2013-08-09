<?php

// update namespaces (only required for testing)
$wgCanonicalNamespaceNames = $wgCanonicalNamespaceNames + $wgExtraNamespaces;

class testWallNotifications extends WallNotifications {
	public function addNotificationToData(&$data, $userId, $wikiId, $uniqueId, $entityKey, $authorId, $isReply, $read = false, $notifyeveryone = false) {
		return parent::addNotificationToData($data, $userId, $wikiId, $uniqueId, $entityKey, $authorId, $isReply, $read, $notifyeveryone);
	}
}

class WallNotificationsTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../WallNotifications.setup.php';
		parent::setUp();
	}

	public function testNotifyEveryoneForMainThread() {
		$wn = $this->getMock('WallNotifications', array('sendEmails','addNotificationLinks'), [], '', false);

		$notification = $this->getMock('WallNotificationEntity', array('isMain'), [], '', false );

		$notification->data = new StdClass();

		$notification->data->wall_userid = '123';
		$notification->data->msg_author_id = '567';
		$notification->data->wall_username = 'LoremIpsum';
		$notification->data->title_id = 555;

		$wn
			->expects($this->once())
			->method('sendEmails')
			->with($this->anything(), $this->equalTo($notification) );

		$wn
			->expects($this->once())
			->method('addNotificationLinks')
			->with($this->equalTo(array('123'=>'123')), $this->equalTo($notification));

		$wn->notifyEveryone($notification);
	}


	public function testNotifyEveryoneForReply() {
		$wn = $this->getMock('WallNotifications', array('sendEmails','addNotificationLinks','getWatchlist'), [], '', false);

		$notification = $this->getMock('WallNotificationEntity', array('isMain'), [], '', false );

		$notification->data = new StdClass();
		$notification->data_non_cached = new StdClass();

		$notification->data->wall_userid = '123';
		$notification->data->msg_author_id = '567';
		$notification->data->wall_username = 'LoremIpsum';
		$notification->data->title_id = 555;
		$notification->data_non_cached->parent_title_dbkey = 'dbkey';

		$users = array('123'=>'123','234'=>'234');

		$wn
			->expects($this->once())
			->method('getWatchlist')
			->will($this->returnValue( $users ) );

		$wn
			->expects($this->once())
			->method('sendEmails')
			->with($this->anything(), $this->equalTo($notification) );

		$wn
			->expects($this->once())
			->method('addNotificationLinks')
			->with($this->equalTo( $users ), $this->equalTo($notification));

		$wn->notifyEveryone($notification);
	}

	public function someDataProvider() {
		$tests = array();

		$uniqueId = 5555;
		$entityKey = '505_212';
		$authorId = 6666;
		$isReply = false;
		$read = false;
		$notifyeveryone = false;

		$dataS = array(
			'notification' => array(
				0 => 4444
			),
			'relation' => array(
				4444 => array(
					'read' => true,
					'list' => array( array('entityKey' => '404_101', 'authorId' => 6600, 'isReply' => false ) ),
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				)
			)
		);


		$dataF = array(
			'notification' => array(
				0 => 4444,
				1 => $uniqueId
			),
			'relation' => array(
				4444 => array(
					'read' => true,
					'list' => array( 0 => array('entityKey' => '404_101', 'authorId' => 6600, 'isReply' => false ) ),
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				),
				$uniqueId => array(
					'read' => $read,
					'list' => array( 0 => array('entityKey' => $entityKey, 'authorId' => $authorId, 'isReply' => $isReply ) ),
					'last' => 1,
					'count' => 1,
					'notifyeveryone' => $notifyeveryone
				)
			)
		);

		// Data Set #0
		$tests[] = array( null, null, $uniqueId, $entityKey, $authorId, $isReply, $read, $dataS, $dataF );

		$dataS = $dataF;

		$dataF = array(
			'notification' => array(
				0 => 4444,
				2 => $uniqueId
			),
			'relation' => array(
				4444 => array(
					'read' => true,
					'list' => array( 0 => array('entityKey' => '404_101', 'authorId' => 6600, 'isReply' => false ) ),
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				),
				$uniqueId => array(
					'read' => $read,
					'list' => array( 0 => array('entityKey' => $entityKey, 'authorId' => $authorId, 'isReply' => $isReply ) ),
					'last' => 2,
					'count' => 1,
					'notifyeveryone' => $notifyeveryone
				)
			)
		);

		$entityKey = '404_102';

		// Data Set #1
		$tests[] = array( null, null, $uniqueId, $entityKey, $authorId, $isReply, $read, $dataS, $dataF );

		$authorId2 = 7777;
		$entityKey  = '505_212';
		$entityKey2 = '404_103';

		$dataF = array(
			'notification' => array(
				0 => 4444,
				2 => $uniqueId
			),
			'relation' => array(
				4444 => array(
					'read' => true,
					'list' => array( 0 => array('entityKey' => '404_101', 'authorId' => 6600, 'isReply' => false ) ),
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				),
				$uniqueId => array(
					'read' => $read,
					'list' => array(
						0 => array('entityKey' => $entityKey,  'authorId' => $authorId,  'isReply' => $isReply ),
						1 => array('entityKey' => $entityKey2, 'authorId' => $authorId2, 'isReply' => $isReply )
					),
					'last' => 2,
					'count' => 2,
					'notifyeveryone' => $notifyeveryone
				)
			)
		);

		// Data Set #2
		$tests[] = array( null, null, $uniqueId, $entityKey2, $authorId2, $isReply, $read, $dataS, $dataF );

		$dataS = $dataF;

		$authorId3 = 7778;
		$entityKey3 = '404_104';

		$dataF = array(
			'notification' => array(
				0 => 4444,
				3 => $uniqueId
			),
			'relation' => array(
				4444 => array(
					'read' => true,
					'list' => array( 0 => array('entityKey' => '404_101', 'authorId' => 6600, 'isReply' => false ) ),
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				),
				$uniqueId => array(
					'read' => $read,
					'list' => array(
						0 => array('entityKey' => $entityKey,  'authorId' => $authorId,  'isReply' => $isReply ),
						1 => array('entityKey' => $entityKey2, 'authorId' => $authorId2, 'isReply' => $isReply ),
						2 => array('entityKey' => $entityKey3, 'authorId' => $authorId3, 'isReply' => $isReply )
					),
					'last' => 3,
					'count' => 3,
					'notifyeveryone' => $notifyeveryone
				)
			)
		);

		// Data Set #3
		$tests[] = array( null, null, $uniqueId, $entityKey3, $authorId3, $isReply, $read, $dataS, $dataF );

		$dataS = $dataF;

		$authorId4 = 7779;
		$entityKey4 = '404_105';

		$dataF = array(
			'notification' => array(
				0 => 4444,
				4 => $uniqueId
			),
			'relation' => array(
				4444 => array(
					'read' => true,
					'list' => array( 0 => array('entityKey' => '404_101', 'authorId' => 6600, 'isReply' => false ) ),
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				),
				$uniqueId => array(
					'read' => $read,
					'list' => array(
						0 => array('entityKey' => $entityKey2, 'authorId' => $authorId2, 'isReply' => $isReply ),
						1 => array('entityKey' => $entityKey3, 'authorId' => $authorId3, 'isReply' => $isReply ),
						2 => array('entityKey' => $entityKey4, 'authorId' => $authorId4, 'isReply' => $isReply )
					),
					'last' => 4,
					'count' => 4,
					'notifyeveryone' => $notifyeveryone
				)
			)
		);

		// Data Set #4
		$tests[] = array( null, null, $uniqueId, $entityKey4, $authorId4, $isReply, $read, $dataS, $dataF );

		$dataS = $dataF;

		$dataF = array(
			'notification' => array(
				0 => 4444,
				5 => $uniqueId
			),
			'relation' => array(
				4444 => array(
					'read' => true,
					'list' => array( 0 => array('entityKey' => '404_101', 'authorId' => 6600, 'isReply' => false ) ),
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				),
				$uniqueId => array(
					'read' => $read,
					'list' => array(
						0 => array('entityKey' => $entityKey2, 'authorId' => $authorId2, 'isReply' => $isReply ),
						1 => array('entityKey' => $entityKey3, 'authorId' => $authorId3, 'isReply' => $isReply ),
						2 => array('entityKey' => $entityKey4, 'authorId' => $authorId4, 'isReply' => $isReply )
					),
					'last' => 5,
					'count' => 4,
					'notifyeveryone' => $notifyeveryone
				)
			)
		);

		$entityKey5 = '404_106';

		// Data Set #5
		$tests[] = array( null, null, $uniqueId, $entityKey5, $authorId4, $isReply, $read, $dataS, $dataF );

		return $tests;
	}
	/**
	 * @dataProvider someDataProvider
	 */
	public function testAddNotificationToData($userId, $wikiId, $uniqueId, $entityKey, $authorId, $isReply, $read, $dataS, $dataF) {
		$wn = new testWallNotifications();

		$wn->addNotificationToData($dataS, $userId, $wikiId, $uniqueId, $entityKey, $authorId, $isReply, $read);

		$this->assertEquals($dataS, $dataF);
	}



}

