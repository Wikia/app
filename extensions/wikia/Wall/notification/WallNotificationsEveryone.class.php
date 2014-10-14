<?php

// TODO: Comments!
class WallNotificationsEveryone extends WallNotifications {

	const DELETE_IDS_BATCH_SIZE = 100;

	public function __construct() {
		$this->app = F::app();
		$this->cityId = $this->app->wg->CityId;
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
			array(
				'wiki_id' => $this->cityId,
				'entity_key' => $key,
				'page_id' => $pageId
			),
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
		$this->getDB(true)->delete( 'wall_notification_queue',
			array(
				'wiki_id' => $this->cityId,
				'page_id' => $pageId
			),
			__METHOD__
		);

		$this->getDB(true)->commit();
		wfProfileOut(__METHOD__);
	}

	/**
	 * Processes the notification queue for user
	 *
	 * @param integer $userId
	 * @return bool
	 */
	public function processQueue( $userId ) {
		wfProfileIn( __METHOD__ );
		if ( $this->getQueueProcessed( $userId ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$preparedDbExpireTime = $this->getDbExpireDate();
		$res = $this->getDB( false )->select( 'wall_notification_queue',
			array( 'entity_key' ),
			array(
				'wiki_id = ' . $this->cityId,
				'event_date > ' . $preparedDbExpireTime
			),
			__METHOD__
		);
		if ( $res ) {
			while ( $val = $res->fetchRow() ) {
				$this->processEntities( $userId, $val['entity_key'] );
			}
			$this->setQueueProcessed( $userId );
		}

		wfProfileOut( __METHOD__ );
	}

	public function processEntities( $userId, $entityKey ) {
		wfProfileIn( __METHOD__ );

		if ( !$this->getEntityProcessed( $userId, $entityKey ) ) {
			$entityKeyArray = explode( '_', $entityKey );

			$rev = Revision::newFromId( $entityKeyArray[0] );

			if ( !empty( $rev ) ) {
				$notifications = WallNotificationEntity::createFromRev( $rev, $this->cityId );
				if ( !empty( $notifications ) ) {
					$wn = new WallNotifications();
					$wn->addNotificationLinks( array( $userId ), $notifications );
				}
			}

			$this->setEntityProcessed( $userId, $entityKey );
		}

		wfProfileOut( __METHOD__ );
	}

	public function setGlobalCacheBuster() {
		wfProfileIn(__METHOD__);
		$cacheKey = $this->getGlobalCacheBusterKey();
		$val = time();
		$this->app->wg->memc->set($cacheKey, $val);
		wfProfileOut(__METHOD__);
		return $val;
	}

	public function getGlobalCacheBuster() {
		wfProfileIn(__METHOD__);
		$cacheKey = $this->getGlobalCacheBusterKey();
		$val = $this->app->wg->memc->get($cacheKey);
		if (empty($val)) {
			wfProfileOut(__METHOD__);
			return $this->setGlobalCacheBuster();
		}
		wfProfileOut(__METHOD__);
		return $val;
	}


	public function setEntityProcessed($userId, $entityKey) {
		wfProfileIn(__METHOD__);

		$cacheKey = $this->getEntityProcessedCacheKey($userId, $entityKey);
		$this->app->wg->memc->set($cacheKey, true);

		$this->getDB(true)->insert('wall_notification_queue_processed', array(
			'user_id' => $userId,
			'entity_key' => $entityKey
		), __METHOD__);

		wfProfileOut(__METHOD__);
	}

	public function getEntityProcessed($userId, $entityKey) {
		wfProfileIn(__METHOD__);
		$cacheKey = $this->getEntityProcessedCacheKey($userId, $entityKey);
		$val = $this->app->wg->memc->get($cacheKey);

		if ($val == true) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$row = $this->getDB(false)->selectRow('wall_notification_queue_processed',
			array('count(*) as cnt'),
			array(
				'user_id' => $userId,
				'entity_key' => $entityKey
			),
			__METHOD__
		);

		if ($row->cnt == 0) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$this->setEntityProcessed($userId, $entityKey);
		wfProfileOut(__METHOD__);
		return true;
	}

	public function setQueueProcessed($userId) {
		wfProfileIn(__METHOD__);

		$cacheKey = $this->getQueueProcessedCacheKey($userId);
		$this->app->wg->memc->set($cacheKey, true);

		wfProfileOut(__METHOD__);
	}

	public function getQueueProcessed($userId) {
		wfProfileIn(__METHOD__);

		$cacheKey = $this->getQueueProcessedCacheKey($userId);
		$out = $this->app->wg->memc->get($cacheKey);

		if ($out == true) {
			wfProfileOut(__METHOD__);
			return true;
		}

		wfProfileOut(__METHOD__);
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
		// SELECT wn.id, wn.user_id, wn.wiki_id, wn.unique_id
		// FROM wall_notification wn
		// JOIN wall_notification_queue wnq ON wnq.wiki_id = wn.wiki_id AND wnq.page_id = wn.unique_id
		// WHERE event_date < '20140113121200';
		$db = $this->getDB(true);
		$res = $db->select(
			array(
				'wn' => 'wall_notification',
				'wnq' => 'wall_notification_queue'
			),
			array(
				'wn.id',
				'wn.user_id',
				'wn.wiki_id',
				'wn.unique_id'
			),
			array(
				'event_date < ' . $preparedDbExpireTime
			),
			__METHOD__,
			array(),
			array(
				'wnq' => array(
					'JOIN',
					array(
						'wnq.wiki_id = wn.wiki_id',
						'wnq.page_id = wn.unique_id'
					)
				)
			)
		);
		$notifications = array();
		$notificationToDeleteIds = array();

		// Group notifications by user_id / wiki_id as the cache is per (user_id, wiki_id) pairs
		while( $row = $db->fetchRow( $res ) ) {
			$user_id = $row['user_id'];
			$wiki_id = $row['wiki_id'];
			if( !isset( $notifications[$user_id] ) ) {
				$notifications[$user_id] = array();
			}
			if( !isset( $notifications[$user_id][$wiki_id] ) ) {
				$notifications[$user_id][$wiki_id] = array();
			}
			$notifications[$user_id][$wiki_id][] = $row['unique_id'];
			$notificationToDeleteIds[] = (int)$row['id'];
		}
		return array( $notifications, $notificationToDeleteIds );
	}

	/**
	 * Remove expired notifications from cache
	 *
	 * @param array $notifications grouped list of notifications
	 */
	private function removeExpiredNotificationsFromCache( $notifications ) {
		foreach( $notifications as $userId => $wikis ) {
			foreach ( $wikis as $wikiId => $uniqueIds ) {
				if( $this->isCachedData( $userId, $wikiId ) ) {
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
		while ( $chunk = array_splice( $notificationToDeleteIds, 0, self::DELETE_IDS_BATCH_SIZE )) {
			$deleteIds = '(' . implode( ',', $chunk ) . ')';

			$this->getDB(true)->delete( 'wall_notification',
				array( 'id IN '. $deleteIds ),
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
			$db->timestamp( strtotime( -WallHelper::NOTIFICATION_EXPIRE_DAYS .' days' ) )
		);
	}

	/**
	 * Clears notification queues and expired notifications
	 *
	 * @param bool $onlyCache - clears only users' cache
	 */
	public function clearQueue( $onlyCache = false ) {
		//TODO: it causes db deadlocks - bugid 97359
		//this should be called at most once a day in a background task
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

		//TODO: performance of this queries
		if ( !$onlyCache ) {
			$db = $this->getDB( true );
			$db->query( 'DELETE FROM wall_notification_queue WHERE event_date < ' . $preparedDbExpireTime );
			$db->query( 'DELETE FROM wall_notification_queue_processed WHERE event_date < ' . $preparedDbExpireTime );
			$db->commit();
		}
		wfProfileOut( __METHOD__ );
	}
}
