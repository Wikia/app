<?php

// TODO: Comments!
class WallNotificationsEveryone extends WallNotifications {

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

		$res = $this->getDB( false )->select( 'wall_notification_queue',
			array( 'entity_key' ),
			array(
				'wiki_id  = ' . $this->cityId,
				'datediff(NOW(), event_date) < ' . WallHelper::NOTIFICATION_EXPIRE_DAYS,
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

	public function getEntityProcessedCacheKey($userId, $entityKey) {
		return wfMemcKey( __CLASS__, 'EntityProcessed', $userId, $entityKey, $this->getGlobalCacheBuster());
	}

	public function getQueueProcessedCacheKey($userId) {
		return wfMemcKey( __CLASS__, 'QueueProcessed', $userId, $this->getGlobalCacheBuster());
	}

	public function getGlobalCacheBusterKey() {
		return wfMemcKey( __CLASS__, 'GlobalCacheKey');
	}

	public function clearQueue() {
		//TODO: it causes db deadlocks - bugid 97359
		//this should be called at most once a day in a background task
		wfProfileIn(__METHOD__);

		//TODO: performace of this queris
		$this->getDB(true)->query('delete from wall_notification_queue where datediff(NOW(), event_date) > ' . WallHelper::NOTIFICATION_EXPIRE_DAYS);
		$this->getDB(true)->query('delete from wall_notification_queue_processed where datediff(NOW(), event_date) > ' . WallHelper::NOTIFICATION_EXPIRE_DAYS);
		wfProfileOut(__METHOD__);
	}
}
