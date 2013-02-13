<?php

// TODO: Comments!
class WallNotificationsEveryone extends WallNotifications {
	const queueTimeout = 30;
	public function __construct() {
		$this->app = F::App();
		$this->cityId = $this->app->wg->CityId;
	}

	public function addNotificationToQueue($entity) {
		wfProfileIn(__METHOD__);

		$key = $entity->id;
		$pageId = $entity->data->title_id;

		$this->getDB(true)->replace('wall_notification_queue', '', array(
			'wiki_id' => $this->cityId,
			'entity_key' => $key,
			'page_id' => $pageId
		), __METHOD__);

		$this->setGlobalCacheBuster();
		$this->clearQueue();

		$this->getDB(true)->commit();
		wfProfileOut(__METHOD__);
	}

	public function removeNotificationFromQueue($pageId) {
		wfProfileIn(__METHOD__);

		$this->getDB(true)->delete('wall_notification_queue', array(
			'wiki_id' => $this->cityId,
			'page_id' => $pageId
		), __METHOD__);

		//TODO: clear old one

		$this->getDB(true)->commit();
		wfProfileOut(__METHOD__);
	}

	public function processQueue($userId) {
		wfProfileIn(__METHOD__);
		if ($this->getQueueProcessed($userId)) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$res = $this->getDB(false)->select('wall_notification_queue',
			array('entity_key'),
			array(
				'wiki_id' => $this->cityId,
				'datediff(NOW(), event_date) < 30',
			),
			__METHOD__
		);
		$entites = array();
		if ($res) {
			while ($val = $res->fetchRow()) {
				$this->processEntites($userId, $val['entity_key']);
			}
			$this->setQueueProcessed($userId);
		}

		wfProfileOut(__METHOD__);
	}

	public function processEntites($userId, $entityKey) {
		wfProfileIn(__METHOD__);

		if (!$this->getEntityProcessed($userId, $entityKey)) {
			$entityKeyArray = explode('_', $entityKey);

			$rev = Revision::newFromId($entityKeyArray[0]);

			if(!empty($rev)) {
				$notif = F::build('WallNotificationEntity', array($rev, $this->app->wg->CityId), 'createFromRev');
				if(!empty($notif)) {
					$wn = F::build('WallNotifications', array());
					$wn->addNotificationLinks(array($userId), $notif);
				}
			}

			$this->setEntityProcessed($userId, $entityKey);
			$this->clearQueue();
		}

		wfProfileOut(__METHOD__);
	}

	public function setGlobalCacheBuster() {
		wfProfileIn(__METHOD__);
		$cacheKey = $this->getGlobalCacheBusterKey();
		$val = time();
		$this->app->getGlobal('wgMemc')->set($cacheKey, $val);
		wfProfileOut(__METHOD__);
		return $val;
	}

	public function getGlobalCacheBuster() {
		wfProfileIn(__METHOD__);
		$cacheKey = $this->getGlobalCacheBusterKey();
		$val = $this->app->getGlobal('wgMemc')->get($cacheKey);
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
		$this->app->getGlobal('wgMemc')->set($cacheKey, true);

		$this->getDB(true)->insert('wall_notification_queue_processed', array(
			'user_id' => $userId,
			'entity_key' => $entityKey
		), __METHOD__);

		wfProfileOut(__METHOD__);
	}

	public function getEntityProcessed($userId, $entityKey) {
		wfProfileIn(__METHOD__);
		$cacheKey = $this->getEntityProcessedCacheKey($userId, $entityKey);
		$val = $this->app->getGlobal('wgMemc')->get($cacheKey);

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
		$this->app->getGlobal('wgMemc')->set($cacheKey, true);

		wfProfileOut(__METHOD__);
	}

	public function getQueueProcessed($userId) {
		wfProfileIn(__METHOD__);

		$cacheKey = $this->getQueueProcessedCacheKey($userId);
		$out = $this->app->getGlobal('wgMemc')->get($cacheKey);

		if ($out == true) {
			wfProfileOut(__METHOD__);
			return true;
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	public function getEntityProcessedCacheKey($userId, $entityKey) {
		return $this->app->runFunction('wfMemcKey', __CLASS__, 'EntityProcessed', $userId, $entityKey, $this->getGlobalCacheBuster());
	}

	public function getQueueProcessedCacheKey($userId) {
		return $this->app->runFunction('wfMemcKey', __CLASS__, 'QueueProcessed', $userId, $this->getGlobalCacheBuster());
	}

	public function getGlobalCacheBusterKey() {
		return $this->app->runFunction('wfMemcKey', __CLASS__, 'GlobalCacheKey');
	}

	public function clearQueue() {
		wfProfileIn(__METHOD__);

		//TODO: performace of this queris
		$this->getDB(true)->query('delete from wall_notification_queue where datediff(NOW(), event_date) > ' . self::queueTimeout . ' LIMIT 10');
		$this->getDB(true)->query('delete from wall_notification_queue_processed where datediff(NOW(), event_date) > ' . self::queueTimeout . ' LIMIT 10');
		wfProfileOut(__METHOD__);
	}
}
