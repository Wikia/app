<?php

// TODO: Comments!
class WallNotificationsEveryone extends WallNotifications {

	const DELETE_IDS_BATCH_SIZE = 100;

	public function __construct() {
		parent::__construct();

		global $wgCityId, $wgWikiaEnvironment;

		$this->app = F::app();
		$this->cityId = $wgCityId;
	}

	/**
	 * Adds notification to the notification queue
	 *
	 * @param WallNotificationEntity $entity
	 */
	public function addNotificationToQueue( WallNotificationEntity $entity ) {
		wfProfileIn( __METHOD__ );

		$key = $entity->id;
		$pageId = $entity->data->title_id;

		$this->getDB( true )->replace( 'wall_notification_queue', '',
			[
				'wiki_id' => $this->cityId,
				'entity_key' => $key,
				'page_id' => $pageId
			],
			__METHOD__
		);

		$this->setGlobalCacheBuster();

		$this->getDB( true )->commit();
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Removes notifications for page from the notification queue and notifications list for all users and updates the
	 * notifications cache
	 *
	 * @param integer $pageId Page id
	 */
	public function removeNotificationForPageId( $pageId ) {
		wfProfileIn( __METHOD__ );

		// remove notifications for this page for all users
		$this->remNotificationsForUniqueID( false, $this->cityId, $pageId );

		// remove notification from notification queue
		$this->getDB( true )->delete( 'wall_notification_queue',
			[
				'wiki_id' => $this->cityId,
				'page_id' => $pageId
			],
			__METHOD__
		);

		$this->getDB( true )->commit();
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Processes the notification queue for user
	 *
	 * @param int $userId
	 */
	public function processQueue( $userId ) {
		if ( $this->getQueueProcessed( $userId ) ) {
			return;
		}

		$preparedDbExpireTime = $this->getDbExpireDate();
		$res = $this->getDB( false )->select( 'wall_notification_queue',
			[ 'entity_key' ],
			[
				'wiki_id = ' . $this->cityId,
				'event_date > ' . $preparedDbExpireTime
			],
			__METHOD__
		);

		if ( $res ) {
			while ( $val = $res->fetchRow() ) {
				$this->processEntities( $userId, $val['entity_key'] );
			}
			$this->setQueueProcessed( $userId );
		}
	}

	public function processEntities( $userId, $entityKey ) {
		if ( !$this->getEntityProcessed( $userId, $entityKey ) ) {
			$notification = WallNotificationEntity::createFromId( $entityKey );
			if ( !empty( $notification ) ) {
				$wn = new WallNotifications();
				$wn->addNotificationLinks( [ $userId ], $notification );
			}

			$this->setEntityProcessed( $userId, $entityKey );
		}
	}

	public function setGlobalCacheBuster() {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$cacheKey = $this->getGlobalCacheBusterKey();
		$val = time();
		$wgMemc->set( $cacheKey, $val );
		wfProfileOut( __METHOD__ );
		return $val;
	}

	public function getGlobalCacheBuster() {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$cacheKey = $this->getGlobalCacheBusterKey();
		$val = $wgMemc->get( $cacheKey );
		if ( empty( $val ) ) {
			wfProfileOut( __METHOD__ );
			return $this->setGlobalCacheBuster();
		}
		wfProfileOut( __METHOD__ );
		return $val;
	}

	public function setEntityProcessed( $userId, $entityKey ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$cacheKey = $this->getEntityProcessedCacheKey( $userId, $entityKey );
		$wgMemc->set( $cacheKey, true );

		$this->getDB( true )->insert( 'wall_notification_queue_processed', [
			'user_id' => $userId,
			'entity_key' => $entityKey
		], __METHOD__ );

		wfProfileOut( __METHOD__ );
	}

	public function getEntityProcessed( $userId, $entityKey ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$cacheKey = $this->getEntityProcessedCacheKey( $userId, $entityKey );
		$val = $wgMemc->get( $cacheKey );

		if ( $val == true ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$row = $this->getDB( false )->selectRow( 'wall_notification_queue_processed',
			[ 'count(*) as cnt' ],
			[
				'user_id' => $userId,
				'entity_key' => $entityKey
			],
			__METHOD__
		);

		if ( $row->cnt == 0 ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$this->setEntityProcessed( $userId, $entityKey );
		wfProfileOut( __METHOD__ );
		return true;
	}

	public function setQueueProcessed( $userId ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$cacheKey = $this->getQueueProcessedCacheKey( $userId );
		$wgMemc->set( $cacheKey, true );

		wfProfileOut( __METHOD__ );
	}

	public function getQueueProcessed( $userId ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$cacheKey = $this->getQueueProcessedCacheKey( $userId );
		$out = $wgMemc->get( $cacheKey );

		if ( $out == true ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	public function getEntityProcessedCacheKey( $userId, $entityKey ) {
		return wfMemcKey( __CLASS__, 'EntityProcessed', $userId, $entityKey, $this->getGlobalCacheBuster() );
	}

	public function getQueueProcessedCacheKey( $userId ) {
		return wfMemcKey( __CLASS__, 'QueueProcessed', $userId, $this->getGlobalCacheBuster() );
	}

	public function getGlobalCacheBusterKey() {
		return wfMemcKey( __CLASS__, 'GlobalCacheKey' );
	}


	/**
	 * Get notifications that must expire
	 * @param string $preparedDbExpireTime quoted string date after which the notifications expire
	 * @return array Result contains two arrays:
	 * 		- the first one contains notification pages grouped by user_id and wiki_id
	 *		- the second one contains id's to all notifications
	 */
	private function getExpiredNotifications( $preparedDbExpireTime ) {
		/*
		 * SELECT wn.id, wn.user_id, wn.wiki_id, wn.unique_id
		 * FROM wall_notification wn
		 * JOIN wall_notification_queue wnq ON wnq.wiki_id = wn.wiki_id AND wnq.page_id = wn.unique_id
		 * WHERE event_date < '20140113121200';
		 */
		$db = $this->getDB( true );
		$res = $db->select(
			[
				'wn' => 'wall_notification',
				'wnq' => 'wall_notification_queue'
			],
			[
				'wn.id',
				'wn.user_id',
				'wn.wiki_id',
				'wn.unique_id'
			],
			[
				'event_date < ' . $preparedDbExpireTime
			],
			__METHOD__,
			[],
			[
				'wnq' => [
					'JOIN',
					[
						'wnq.wiki_id = wn.wiki_id',
						'wnq.page_id = wn.unique_id'
					]
				]
			]
		);
		$notifications = [];
		$notificationToDeleteIds = [];

		// Group notifications by user_id / wiki_id as the cache is per (user_id, wiki_id) pairs
		while ( $row = $db->fetchRow( $res ) ) {
			$user_id = $row['user_id'];
			$wiki_id = $row['wiki_id'];
			if ( !isset( $notifications[$user_id] ) ) {
				$notifications[$user_id] = [];
			}
			if ( !isset( $notifications[$user_id][$wiki_id] ) ) {
				$notifications[$user_id][$wiki_id] = [];
			}
			$notifications[$user_id][$wiki_id][] = $row['unique_id'];
			$notificationToDeleteIds[] = (int)$row['id'];
		}
		return [ $notifications, $notificationToDeleteIds ];
	}

	/**
	 * Remove expired notifications from cache
	 *
	 * @param array $notifications grouped list of notifications
	 */
	private function removeExpiredNotificationsFromCache( $notifications ) {
		foreach ( $notifications as $userId => $wikis ) {
			foreach ( $wikis as $wikiId => $uniqueIds ) {
				if ( $this->isCachedData( $userId, $wikiId ) ) {
					$memCacheSync = $this->getCache( $userId, $wikiId );
					$memCacheSync->lockAndSetData(
						function() use( $memCacheSync, $userId, $wikiId, $uniqueIds ) {
							$data = $this->getData( $memCacheSync, $userId, $wikiId );
							foreach ( $uniqueIds as $uniqueId ) {
								$this->remNotificationFromData( $data, $uniqueId );
							}
							return $data;
						},
						function() use( $memCacheSync ) {
							// Delete the cache if we were unable to update to force a rebuild
							$memCacheSync->delete();
						}
					);
				}
			}
		}
	}

	/**
	 * Remove expired notifications from database
	 * @param array $notificationToDeleteIds - array containing notification ids
	 */
	private function deleteNotificationsFromDB( $notificationToDeleteIds ) {
		// delete ids by chunks as they can be many
		while ( $chunk = array_splice( $notificationToDeleteIds, 0, self::DELETE_IDS_BATCH_SIZE ) ) {
			$deleteIds = '(' . implode( ',', $chunk ) . ')';

			$this->getDB( true )->delete( 'wall_notification',
				[ 'id IN ' . $deleteIds ],
				__METHOD__
			);
		};
	}

	/**
	 * Return the db quoted notifications expiration date
	 * @return string
	 */
	private function getDbExpireDate() {
		$db = $this->getDB( true );
		return $db->addQuotes(
			$db->timestamp( strtotime( -WallHelper::NOTIFICATION_EXPIRE_DAYS . ' days' ) )
		);
	}

	/**
	 * Clears notification queues and expired notifications
	 *
	 * @param bool $onlyCache - clears only users' cache
	 */
	public function clearQueue( $onlyCache = false ) {
		// TODO: it causes db deadlocks - bugid 97359
		// this should be called at most once a day in a background task
		wfProfileIn( __METHOD__ );

		$preparedDbExpireTime = $this->getDbExpireDate();

		// Remove expired notifications
		list( $notificationsToDelete, $notificationToDeleteIds ) =
			$this->getExpiredNotifications( $preparedDbExpireTime );

		if ( !empty( $notificationToDeleteIds ) ) {
			$this->removeExpiredNotificationsFromCache( $notificationsToDelete );
			if ( !$onlyCache ) {
				$this->deleteNotificationsFromDB( $notificationToDeleteIds );
			}
		}

		// TODO: performance of this queries
		if ( !$onlyCache ) {
			$db = $this->getDB( true );
			$db->query( 'DELETE FROM wall_notification_queue WHERE event_date < ' . $preparedDbExpireTime );
			$db->query( 'DELETE FROM wall_notification_queue_processed WHERE event_date < ' . $preparedDbExpireTime );
			$db->commit();
		}
		wfProfileOut( __METHOD__ );
	}
}
