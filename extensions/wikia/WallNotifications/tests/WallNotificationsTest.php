<?php

// update namespaces (only required for testing)
$wgCanonicalNamespaceNames = $wgCanonicalNamespaceNames + $wgExtraNamespaces;

class testWallNotifications extends WallNotifications {
	public function addNotificationToData(&$data, $userId, $wikiId, $notificationData) {
		parent::addNotificationToData($data, $userId, $wikiId, $notificationData);
	}
}

class WallNotificationsTest extends WikiaBaseTest {

	const ENTITY_KEY_102 = '404_102';
	const ENTITY_KEY_103 = '404_103';
	const ENTITY_KEY_104 = '404_104';
	const ENTITY_KEY_105 = '404_105';
	const ENTITY_KEY_106 = '404_106';
	const ENTITY_KEY_212 = '505_212';

	public function setUp() {
		parent::setUp();
	}

	/**
	 * @group UsingDB
	 */
	public function testNotifyEveryoneForMainThread() {
		/** @var PHPUnit_Framework_MockObject_MockObject|WallNotifications $wn */
		$wn = $this->getMock( 'WallNotifications', [ 'sendEmails', 'addNotificationLinks' ] );

		/** @var WallNotificationEntity $notification */
		$notification = $this->getMock( 'WallNotificationEntity', [ 'isMain' ] );

		$notification->data = new StdClass();

		$notification->data->wall_userid = '123';
		$notification->data->msg_author_id = '567';
		$notification->data->wall_username = 'LoremIpsum';
		$notification->data->title_id = 555;

		$wn->expects( $this->once() )
			->method( 'sendEmails' )
			->with( $this->anything(), $this->equalTo( $notification ) );

		$wn->expects( $this->once() )
			->method( 'addNotificationLinks' )
			->with( $this->equalTo( [ '123'=>'123' ] ), $this->equalTo( $notification ) );

		$wn->notifyEveryone( $notification );
	}

	public function testNotifyEveryoneForReply() {
		/** @var PHPUnit_Framework_MockObject_MockObject|WallNotifications $wn */
		$wn = $this->getMock('WallNotifications', [ 'sendEmails','addNotificationLinks','getWatchlist' ] );

		/** @var WallNotificationEntity $notification */
		$notification = $this->getMock('WallNotificationEntity', [ 'isMain' ] );

		$notification->data = new StdClass();

		$notification->data->wall_userid = '123';
		$notification->data->msg_author_id = '567';
		$notification->data->wall_username = 'LoremIpsum';
		$notification->data->title_id = 555;
		$notification->parentTitleDbKey = 'dbkey';

		$users = [
			'123' => '123',
			'234' => '234',
		];

		$wn->expects( $this->once() )
			->method( 'getWatchlist' )
			->will( $this->returnValue( $users ) );

		$wn->expects( $this->once() )
			->method( 'sendEmails' )
			->with( $this->anything(), $this->equalTo( $notification ) );

		$wn->expects( $this->once() )
			->method( 'addNotificationLinks' )
			->with( $this->equalTo( $users ), $this->equalTo( $notification ) );

		$wn->notifyEveryone( $notification );
	}

	public function someDataProvider() {
		$tests = [ ];
		$relationListItem = [ 'entityKey' => '404_101', 'authorId' => 6600, 'isReply' => false ];
		$firstUniqueId = 4444;
		$secondUniqueId = 5555;

		$entityKey0 = self::ENTITY_KEY_212;
		$authorId = 6666;
		$isReply = false;
		$read = false;
		$notifyeveryone = false;

		$notificationData = [
			'unique_id' => $secondUniqueId,
			'entity_key' => $entityKey0,
			'is_reply' => $isReply,
			'author_id' => $authorId,
			'is_read' => $read,
			'notifyeveryone' => $notifyeveryone
		];

		$dataS = [
			'notification' => [
				0 => $firstUniqueId
			],
			'relation' => [
				$firstUniqueId => [
					'read' => true,
					'list' => [ $relationListItem ],
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				]
			]
		];

		$dataF = [
			'notification' => [
				0 => $firstUniqueId,
				1 => $secondUniqueId
			],
			'relation' => [
				$firstUniqueId => [
					'read' => true,
					'list' => [ 0 => $relationListItem ],
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				],
				$secondUniqueId => [
					'read' => $read,
					'list' => [ 0 => [ 'entityKey' => $entityKey0, 'authorId' => $authorId, 'isReply' => $isReply ] ],
					'last' => 1,
					'count' => 1,
					'notifyeveryone' => $notifyeveryone
				]
			]
		];

		// Data Set #0
		$tests[] = [ null, null, $notificationData, $dataS, $dataF ];

		$entityKey10 = self::ENTITY_KEY_212;
		$entityKey11 = self::ENTITY_KEY_102;

		$dataS = $dataF;

		$dataF = [
			'notification' => [
				0 => $firstUniqueId,
				2 => $secondUniqueId
			],
			'relation' => [
				$firstUniqueId => [
					'read' => true,
					'list' => [ 0 => $relationListItem ],
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				],
				$secondUniqueId => [
					'read' => $read,
					'list' => [
						0 => [ 'entityKey' => $entityKey10, 'authorId' => $authorId, 'isReply' => $isReply ],
						1 => [ 'entityKey' => $entityKey11, 'authorId' => $authorId, 'isReply' => $isReply ],
					],
					'last' => 2,
					'count' => 2,
					'notifyeveryone' => $notifyeveryone
				]
			]
		];

		$notificationData['entity_key'] = $entityKey11;

		// Data Set #1
		$tests[] = [ null, null, $notificationData, $dataS, $dataF ];

		$authorId2 = 7777;
		$entityKey20 = self::ENTITY_KEY_212;
		$entityKey21 = self::ENTITY_KEY_103;

		$dataF = [
			'notification' => [
				0 => $firstUniqueId,
				2 => $secondUniqueId
			],
			'relation' => [
				$firstUniqueId => [
					'read' => true,
					'list' => [ 0 => $relationListItem ],
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				],
				$secondUniqueId => [
					'read' => $read,
					'list' => [
						0 => [ 'entityKey' => $entityKey20,  'authorId' => $authorId,  'isReply' => $isReply ],
						1 => [ 'entityKey' => $entityKey21, 'authorId' => $authorId2, 'isReply' => $isReply ],
					],
					'last' => 2,
					'count' => 2,
					'notifyeveryone' => $notifyeveryone
				]
			]
		];

		$notificationData['entity_key'] = $entityKey21;
		$notificationData['author_id'] = $authorId2;

		// Data Set #2
		$tests[] = [ null, null, $notificationData, $dataS, $dataF ];

		$dataS = $dataF;

		$authorId3 = 7778;
		$entityKey30 = self::ENTITY_KEY_212;
		$entityKey31 = self::ENTITY_KEY_103;
		$entityKey32 = self::ENTITY_KEY_104;

		$dataF = [
			'notification' => [
				0 => $firstUniqueId,
				3 => $secondUniqueId
			],
			'relation' => [
				$firstUniqueId => [
					'read' => true,
					'list' => [ 0 => $relationListItem ],
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				],
				$secondUniqueId => [
					'read' => $read,
					'list' => [
						0 => [ 'entityKey' => $entityKey30, 'authorId' => $authorId, 'isReply' => $isReply ],
						1 => [ 'entityKey' => $entityKey31, 'authorId' => $authorId2, 'isReply' => $isReply ],
						2 => [ 'entityKey' => $entityKey32, 'authorId' => $authorId3, 'isReply' => $isReply ],
					],
					'last' => 3,
					'count' => 3,
					'notifyeveryone' => $notifyeveryone
				]
			]
		];

		$notificationData['entity_key'] = $entityKey32;
		$notificationData['author_id'] = $authorId3;

		// Data Set #3
		$tests[] = [ null, null, $notificationData, $dataS, $dataF ];

		$dataS = $dataF;

		$authorId4 = 7779;
		$entityKey40 = self::ENTITY_KEY_103;
		$entityKey41 = self::ENTITY_KEY_104;
		$entityKey42 = self::ENTITY_KEY_105;

		$dataF = [
			'notification' => [
				0 => $firstUniqueId,
				4 => $secondUniqueId
			],
			'relation' => [
				$firstUniqueId => [
					'read' => true,
					'list' => [ 0 => $relationListItem ],
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				],
				$secondUniqueId => [
					'read' => $read,
					'list' => [
						0 => [ 'entityKey' => $entityKey40, 'authorId' => $authorId2, 'isReply' => $isReply ],
						1 => [ 'entityKey' => $entityKey41, 'authorId' => $authorId3, 'isReply' => $isReply ],
						2 => [ 'entityKey' => $entityKey42, 'authorId' => $authorId4, 'isReply' => $isReply ],
					],
					'last' => 4,
					'count' => 4,
					'notifyeveryone' => $notifyeveryone
				]
			]
		];

		$notificationData['entity_key'] = $entityKey42;
		$notificationData['author_id'] = $authorId4;

		// Data Set #4
		$tests[] = [ null, null, $notificationData, $dataS, $dataF ];

		$dataS = $dataF;

		$entityKey50 = self::ENTITY_KEY_104;
		$entityKey51 = self::ENTITY_KEY_105;
		$entityKey52 = self::ENTITY_KEY_106;

		$dataF = [
			'notification' => [
				0 => $firstUniqueId,
				5 => $secondUniqueId
			],
			'relation' => [
				$firstUniqueId => [
					'read' => true,
					'list' => [ 0 => $relationListItem ],
					'last' => 0,
					'count' => 1,
					'notifyeveryone' => 0
				],
				$secondUniqueId => [
					'read' => $read,
					'list' => [
						0 => [ 'entityKey' => $entityKey50, 'authorId' => $authorId3, 'isReply' => $isReply ],
						1 => [ 'entityKey' => $entityKey51, 'authorId' => $authorId4, 'isReply' => $isReply ],
						2 => [ 'entityKey' => $entityKey52, 'authorId' => $authorId4, 'isReply' => $isReply ],
					],
					'last' => 5,
					'count' => 5,
					'notifyeveryone' => $notifyeveryone
				]
			]
		];

		$notificationData['entity_key'] = $entityKey52;

		// Data Set #5
		$tests[] = [ null, null, $notificationData, $dataS, $dataF ];

		return $tests;
	}

	/**
	 * @dataProvider someDataProvider
	 * @param $userId
	 * @param $wikiId
	 * @param $notificationData
	 * @param $dataS
	 * @param $dataF
	 */
	public function testAddNotificationToData($userId, $wikiId, $notificationData, $dataS, $dataF) {
		$wn = new testWallNotifications();

		$wn->addNotificationToData($dataS, $userId, $wikiId, $notificationData);

		$this->assertEquals($dataS, $dataF);
	}



}

