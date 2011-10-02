<?php

/*
 * Wall notifications allows us to manage notifications about new messages
 * and replies on users Walls
 * 
 * Interface
 *  single instance of WallNotifications to interact with
 *  WallNotificationEntity - single notification data, 
 *    only one exists for every notification event, but is linked from
 *    every user who is interested in specific notification
 * 
 */


class WallNotifications {
	public function __construct() {
		$this->app = F::App();
		$db = $this->getDB(true);
	}
	
	/*
	 * Public Interface
	 */
	
	public function getNotifications($userId, $wikiId, $readSlice = 5) {
		/* if since == null, get all notifications */	
		/* possibly ignore $wiki at one point and fetch notifications from all wikis */
		
		$memcSync = $this->getCache($userId, $wikiId);
		$list = $this->getData($memcSync, $userId, $wikiId);
		$fh = fopen('/var/tmp/wall.log', 'a'); fwrite($fh, "xxx\n".print_r($list,1)); fclose($fh);
		
		if(empty($list)) {
			return array();
		}
		
		$read = array();
		$unread = array();
		foreach(array_reverse($list['notification']) as $listval) {	
			if(!empty($listval)) {
				if($list['relation'][ $listval ]['read']){
					if(count($read) < $readSlice){
						$read[] = array(
							"grouped" => $this->groupEntity($list['relation'][ $listval ]['list'])
						);	
					}
				} else {
					$unread[] = array(
						"grouped" => $this->groupEntity($list['relation'][ $listval ]['list'])
					);
				}
			}
		}
		
		$out = array(
			'unread'=> $unread,
			'unread_count' => count($unread),
			'read' => $read,
			'read_count' => count($read)
		);
		return $out; 
	}
	
	protected function groupEntity($list){
		$grouped = array();
		foreach(array_reverse($list) as $obj ) {
			$notif = F::build('WallNotificationEntity', array($obj['entityKey']), 'getById');
			//TODO: by user name
			$grouped[] = $notif;
					//if(count($grouped) == 3) break;
		}
		return $grouped;
	}

	public function addNotification(RecentChange $RC) {
		$notif = F::build('WallNotificationEntity', array($RC, $this->app->wg->CityId), 'createFromRC');
		$notif->save();
		$this->notifyEveryone($notif);
	}

	/*
	 * Helper functions
	 */
	
	public function notifyEveryone($notification) {
		$users = array();
		if(!$notification->isMain()){
			$users = $this->getWatchlist($notification->data_noncached->parent_title_dbkey);
		}
	
		//FB:#11089
		$users[$notification->data->wall_userid] = $notification->data->wall_userid;
		
		if(!empty($users[$notification->data->msg_author_id])){
			unset($users[$notification->data->msg_author_id]);	
		} 

		$title = Title::newFromText($notification->data->wall_username. '/' . $notification->data->title_id, NS_USER_WALL );
		
		$this->sendEmails($title, $notification->data->msg_author_id, array_keys($users), $notification->isMain(), $notification->data->wall_userid );
		$this->addNotificationLinks($users, $notification);
	}
	
	protected function sendEmails($title, $msg_author_id, $watchers, $isMain, $wallOwnerId) {
		$enotif = new EmailNotification();
		
		$watchersOut = array();
		foreach($watchers as $val){
			$watcher = User::newFromId($val);
			if( $watcher->getId() != 0 && ($watcher->getOption('enotifwallthread') )
				|| ($watcher->getOption('enotifmywall') && $wallOwnerId == $watcher->getId())
			) {		
				$watchersOut[] = $val; 	
			}
		}

		//$article = Article::newFromId( $title_id );
		$editor = User::newFromId( $msg_author_id );
		if(empty($title) || empty($editor)) {
			return false;
		}
		
		$enotif->notifyOnPageChange( $editor, $title,
			wfTimestampNow(),
			'',
			false,
			false,
			'wallmessage',
			array(
				'watchers' => $watchersOut
		));		
		return true;
	}

	protected function getWatchlist($titleDbkey) {
		//TODO: add some caching
		$dbw = $this->getLocalDB(true);
		$res = $dbw->select( array( 'watchlist' ),
			array( 'wl_user' ),
			array(
				'wl_title' => $titleDbkey,
				'wl_namespace' => NS_USER_WALL_MESSAGE
			), __METHOD__
		);
		
		$users = array();
		while ($row = $dbw->fetchObject( $res ) ) {
			$userId = intval( $row->wl_user );
			$users[$userId] = $userId;
		}
		return $users;
	}	
		
	protected function addNotificationLinks(Array $userIds, $notification) {
		foreach($userIds as $userId) {
			$this->addNotificationLink($userId, $notification);
		}
	}

	protected function addNotificationLink($userId, $notification) {
		$this->addNotificationLinkInternal(
			$userId,
			$notification->data->wiki,
			$notification->getUniqueId(),
			$notification->getId(), 
			$notification->data->msg_author_id,
			!$notification->isMain()
		);
	}
	
	public function markRead($userId, $wikiId, $id = 0, $ts = 0) {
		//TODO: transaction !!!
		
		$updateDBlist = array(); // we will update database AFTER unlocking

		$memcSync = $this->getCache($userId, $wikiId);
		do {
			$count = 0; //use to set priority of process 
			if($memcSync->lock()) {
				$data = $this->getData($memcSync, $userId, $wikiId);
			
				if($id == 0 && !empty( $data['relation'] ) ) {
					$ids = array_keys( $data['relation'] );	
				} else {
					$ids = array( $id ); 
				}
				
				foreach($ids as $value) {
					if(!empty($data['relation'][ $value])) {
						$data['relation'][ $value ]['read'] = true;	
						foreach($data['relation'][ $value ]['list'] as $val) {
							$entityKey = $val['entityKey'];
							$updateDBlist[] = array(
										'user_id' => $userId,
										'wiki_id' => $wikiId,
										'entity_key' => $entityKey
							);
						}
					}			
				}
			} else {
				$this->sleep($count);
			}
			$count++;
		} while(!isset($data) || !$this->setData($memcSync, $data));
		
		$memcSync->unlock();
		
		foreach($updateDBlist as $value) {
			$this->getDB(true)->update('wall_notification' , array('is_read' =>  1 ), $value, __METHOD__ );
		}
	}

	protected function addNotificationLinkInternal($userId, $wikiId, $uniqueId, $entityKey, $authorId, $isReply ) {
		$fh = fopen('/var/tmp/wall.log', 'a'); fwrite($fh, "link internal\n"); fclose($fh);
		if($userId < 1) {
			return true;
		}
		$fh = fopen('/var/tmp/wall.log', 'a'); fwrite($fh, "store db\n"); fclose($fh);
		$this->storeInDB($userId, $wikiId, $uniqueId, $entityKey, $authorId, $isReply); 
		//id use to prevent having of extra entry after memc fail.   
		$fh = fopen('/var/tmp/wall.log', 'a'); fwrite($fh, "get cache\n"); fclose($fh);
		$memcSync = $this->getCache($userId, $wikiId);
		do {
			$count = 0; //use to set priority of process 
			if($memcSync->lock()) {
				$data = $this->getData($memcSync, $userId, $wikiId);
				$this->addNotificationToData($data, $uniqueId, $entityKey, $authorId, $isReply );
			} else {
				$this->sleep($count);
			}
			$count++;
		} while(!isset($data) || !$this->setData($memcSync, $data));
		
		$memcSync->unlock();
		$fh = fopen('/var/tmp/wall.log', 'a'); fwrite($fh, "internal done\n"); fclose($fh);
	}
	
	protected function sleep($userId, $wikiId){
		$time = 100000 - $count*1000; //change priority of process with access to resorce
		if($time < 0) {
			$time = 0;
		}
		usleep(100000 + $time);		
	}
	
	protected function addNotificationToData(&$data, $uniqueId, $entityKey, $authorId, $isReply, $read = false) {
		$data['notification'][] = $uniqueId;		
		
		if(isset($data['relation'][ $uniqueId ]['last']) && $data['relation'][ $uniqueId ]['last'] > -1) {
			$data['notification'][ $data['relation'][$uniqueId ]['last'] ] = null;
		}

		if(empty($data['relation'][ $uniqueId ]['list']) || $data['relation'][ $uniqueId ]['read'] ) {
			$data['relation'][ $uniqueId ]['list'] = array();
		}

		$data['relation'][ $uniqueId ]['last'] = count($data['notification']) - 1;

		
		// we are reply and currently stored information is not? ignore new notification
		// but only if we are still unread
		if($isReply == true) {
			if($data['relation'][ $uniqueId ]['read'] == false) {
				foreach( $data['relation'][ $uniqueId ]['list'] as $key=>$rel ) {
					if( $rel['isReply'] == false ) { return; }
				}
			} else {
				// we are reply but above wasn't true?
				// so we are adding unread notification to read notifications
				// get rid of all read elements
				$data['relation'][ $uniqueId ]['list'] = array();
			}
		}
		
		// scan relation list, remove element that has the same author
		$found = false;
		$first_key = null;
		foreach( $data['relation'][ $uniqueId ]['list'] as $key=>$rel ) {
			if( $first_key == null ) $first_key = $key;
			if( $rel['authorId'] == $authorId ) {
				unset($data['relation'][ $uniqueId ]['list'][$key]);
				$found = true;
			}
		}
		// if we didn't find same author in our list, we need to remove oldest element
		if($first_key != null && $found == false) unset($data['relation'][ $uniqueId ]['list'][$key]);
		
		$data['relation'][ $uniqueId ]['list'][] = array('entityKey' => $entityKey, 'authorId' => $authorId, 'isReply'=>$isReply);
	
		$data['relation'][ $uniqueId ]['read'] = $read;			
		
	}
	
	protected function getData($cache, $userId, $wiki) {
		$val = $cache->get();
		
		if(empty($val) && !is_array($val)) {
			$val = $this->rebuildData($userId, $wiki);
		}
		
		return $val;
	}
	
	protected function setData($cache, $data) {
		return $cache->set( $data );
	}

	public function rebuildData($userId, $wikiId) {
		$data = array(
			'notification' => array(),
			'relation' => array()
		);

		//return $data;
		
		//TODO: solve problem with master slave replication
		$dbData = $this->getBackupData($userId, $wikiId);
		
		foreach($dbData as $key => $value) {
			//$this->addNotificationToData($data, $value['unique_id'], $value['entity_key'], $value['author_id'], $value['read']);
			$this->addNotificationToData($data, $value['unique_id'], $value['entity_key'], $value['author_id'], $value['is_read'], $value['is_reply']);
		}
		
		return $data;
	}
	
	protected function getBackupData($userId, $wikiId, $master = false, $fromId = 0) {
		$uniqueIds = array();
		// select distinct Unique_id from wall_notification where user_id = 1 and wiki_id = 1 order by id
		$db = $this->getDB(true);
		$res = $db->select('wall_notification',
			array('distinct unique_id'),
			array(
				'user_id' => $userId,
				'wiki_id' => $wikiId
			),
			__METHOD__,
			array( 
				"ORDER BY" => "id desc" ,
				"LIMIT" => 50
			)
		);
		
		while($row = $db->fetchRow($res)) {
			$uniqueIds[] = $row['unique_id'];
		}
		
		$out = array();
		if(!empty($uniqueIds)) {
			$res = $db->select('wall_notification',
				array('id', 'is_read', 'is_reply', 'unique_id', 'entity_key', 'author_id'),
				//array('id', 'unique_id', 'entity_key', 'author_id'),
				array(
					'user_id' => $userId,
					'wiki_id' => $wikiId,
					'unique_id' => $uniqueIds
				),
				__METHOD__,
				array( "ORDER BY" => "id" )
			);

			while($row = $db->fetchRow($res)) {
				$out[] = $row;
			}
		}

		return $out;
	}
	
	public function storeInDB($userId, $wikiId,$uniqueId, $entityKey, $authorId, $isReply){
		$this->getDB(true)->insert( 'wall_notification', array(
			'user_id' => $userId, 
			'wiki_id' => $wikiId, 
			'unique_id' =>$uniqueId,
			'author_id' => $authorId,
			'entity_key' => $entityKey,
			'is_read' => 0,
			'is_reply' => $isReply
		), __METHOD__ );
		$this->getDB(true)->commit();
	}
	
	protected function getCache($userId, $wikiId) {
		return F::build('MemcacheSync', array($this->app->wg->Memc, $this->getKey($userId, $wikiId)));
	}
	
	public function getDB($master = false){
		return wfGetDB( $master ? DB_MASTER:DB_SLAVE, array(), $this->app->wg->ExternalDatawareDB );
	}
	
	public function getLocalDB($master = false){
		return wfGetDB( $master ? DB_MASTER:DB_SLAVE, array() );
	}
	
	public function getKey( $userId, $wikiId ){
		return $this->app->runFunction( 'wfSharedMemcKey', __CLASS__, $userId, $wikiId. '_29' );
	}
}
