<?php

/**
 * Class WallNotificationsEveryone that implements wall notifications queue.
 * It's called by WallMessage::setNotifyEveryone method - triggered by notifyEveryoneSave AJAX request (used by Forum only).
 *
 * ## How to call it
 *
 * $notif = WallNotificationEntity::createFromRev( $rev );
 * $wne = new WallNotificationsEveryone();
 * $wne->addNotificationToQueue( $notif );
 *
 * ## Database queries
 *
 * This class uses wall_notification_queue and wall_notification_queue_processed tables on dataware database.
 *
 * entity_id column is composed of "<revision ID>_<wiki ID>"
 *
 * ## DB schema
 *
 *  - wall_notification_queue table stores the date of the last edit (event_date column) of Message Walls (page_id + entity_key columns) across all wikis
 *  - wall_notification_queue_processed stores per-user notifications that were added to wall_notifications
 *
 * When WallNotificationsExternalController::getUpdateCounts is handled processQueue() method moves entries from wall_notification_queue to wall_notification_queue_processed table (using processEntities method).
 * All entity_key values for a given wiki (taken from wall_notification_queue) are insrted into wall_notification_queue_processed table (with a specific user_id set) and wall_notification entry is created.
 * Hence wall_notification_queue_processed table is used to mark entities which user was already notified about.
 *
  */
class WallNotificationsEveryone extends WallNotifications {

	const DELETE_IDS_BATCH_SIZE = 100;

	const WALL_NOTIFICATIONS_QUEUE_TABLE = 'wall_notification_queue';
	const WALL_NOTIFICATIONS_QUEUE_PROCESSED_TABLE = 'wall_notification_queue_processed';

	public function __construct() {
		parent::__construct();

		global $wgCityId;
		$this->cityId = $wgCityId;
	}

	/**
	 * Adds notification to the notification queue. Called by WallMessage::setNotifyEveryone
	 *
	 * @param WallNotificationEntity $entity
	 */
	public function addNotificationToQueue( WallNotificationEntity $entity ) {
		wfProfileIn( __METHOD__ );

		$key = $entity->id;
		$pageId = $entity->data->title_id; // ID of MessageWall title, each Wall has a unique entry in this table

		$this->getDB( true )->replace( self::WALL_NOTIFICATIONS_QUEUE_TABLE, '',
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
	 * notifications cache. Called by WallMessage::setNotifyEveryone
	 *
	 * @param integer $pageId Page id
	 */
	public function removeNotificationForPageId( $pageId ) {
		wfProfileIn( __METHOD__ );

		// remove notifications for this page for all users
		$this->remNotificationsForUniqueID( false, $this->cityId, $pageId );

		// remove notification from notification queue
		$this->getDB( true )->delete( self::WALL_NOTIFICATIONS_QUEUE_TABLE,
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
	 * Called by WallNotificationsExternalController::getUpdateCounts for handling AJAX requests
	 *
	 * Checks wall_notification_queue for all Wall message marked as "notify everyone" that has not yet been added
	 * to wall_notification table for a given user.
	 *
	 * @param int $userId
	 */
	public function processQueue( $userId ) {
		if ( $this->getQueueProcessed( $userId ) ) {
			return;
		}

		$preparedDbExpireTime = $this->getDbExpireDate();
		$res = $this->getDB( false )->select( self::WALL_NOTIFICATIONS_QUEUE_TABLE,
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

	private function processEntities( $userId, $entityKey ) {
		if ( !$this->hasEntryInProcessedQueue( $userId, $entityKey ) ) {
			$notification = WallNotificationEntity::createFromId( $entityKey );
			if ( !empty( $notification ) ) {
				$wn = new WallNotifications();
				$wn->addNotificationLinks( [ $userId ], $notification );
			}

			// mark given entity as processed for a given user
			$this->markEntityAsProcessed( $userId, $entityKey );
		}
	}

	private function setGlobalCacheBuster() {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$cacheKey = $this->getGlobalCacheBusterKey();
		$val = time();
		$wgMemc->set( $cacheKey, $val );
		wfProfileOut( __METHOD__ );
		return $val;
	}

	private function getGlobalCacheBuster() {
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

	/**
	 * Inserts a row to wall_notification_queue_processed table
	 *
	 * We then use count(*) to check if there are entries in this table (hasEntryInProcessedQueue method)
	 * and that there's no need to push a row to wall_notifications.
	 *
	 * @param int $userId
	 * @param string $entityKey in a form of "<revision ID>_<wiki ID>"
	 */
	private function markEntityAsProcessed($userId, $entityKey ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$cacheKey = $this->getEntityProcessedCacheKey( $userId, $entityKey );
		$wgMemc->set( $cacheKey, true );

		$this->getDB( true )->insert( self::WALL_NOTIFICATIONS_QUEUE_PROCESSED_TABLE,
			[
				'user_id' => $userId,
				'entity_key' => $entityKey
			],
			__METHOD__
		);

		$this->getDB( true )->commit();
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Does given user has an entry in notifications queue for a given entity (i.e. wall message)?
	 *
	 * Per-user and per-wiki memcache flag is used to rate-limit DB checks
	 *
	 * @param int $userId
	 * @param string $entityKey
	 * @return bool
	 */
	private function hasEntryInProcessedQueue($userId, $entityKey ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$cacheKey = $this->getEntityProcessedCacheKey( $userId, $entityKey );
		$val = $wgMemc->get( $cacheKey );

		if ( $val == true ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$cnt = $this->getDB( false )->selectField( self::WALL_NOTIFICATIONS_QUEUE_PROCESSED_TABLE,
			'count(*)',
			[
				'user_id' => $userId,
				'entity_key' => $entityKey
			],
			__METHOD__
		);

		wfProfileOut( __METHOD__ );

		// there's at least a single matching row - entity has already been proccessed
		// .e. there's an entry in wall_notification table
		return ( $cnt > 0 );
	}

	private function setQueueProcessed( $userId ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$cacheKey = $this->getQueueProcessedCacheKey( $userId );
		$wgMemc->set( $cacheKey, true ); // cache for infite time - memcache key contains a cache buster value

		wfProfileOut( __METHOD__ );
	}

	private function getQueueProcessed( $userId ) {
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

	private function getEntityProcessedCacheKey( $userId, $entityKey ) {
		return wfMemcKey( __CLASS__, 'EntityProcessed', $userId, $entityKey, $this->getGlobalCacheBuster() );
	}

	private function getQueueProcessedCacheKey( $userId ) {
		return wfMemcKey( __CLASS__, 'QueueProcessed', $userId, $this->getGlobalCacheBuster() );
	}

	private function getGlobalCacheBusterKey() {
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
				'wnq' => self::WALL_NOTIFICATIONS_QUEUE_TABLE
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
	 * Called by the maintenance.php script
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
			$db->query( 'DELETE FROM ' . self::WALL_NOTIFICATIONS_QUEUE_TABLE . ' WHERE event_date < ' . $preparedDbExpireTime );
			$db->query( 'DELETE FROM ' . self::WALL_NOTIFICATIONS_QUEUE_PROCESSED_TABLE . ' WHERE event_date < ' . $preparedDbExpireTime );
			$db->commit();
		}
		wfProfileOut( __METHOD__ );
	}
}
