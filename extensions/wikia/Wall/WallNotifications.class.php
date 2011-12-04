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
	
	public function getWikiNotifications($userId, $wikiId, $readSlice = 5) {
		/* if since == null, get all notifications */	
		/* possibly ignore $wiki at one point and fetch notifications from all wikis */
		
		// ignore read notifications for other wikis than the current one
		if( $this->app->wg->CityId != $wikiId ) $readSlice = 0;
		
		$memcSync = $this->getCache($userId, $wikiId);
		$list = $this->getData($memcSync, $userId, $wikiId);
		
		if(empty($list)) {
			return array();
		}
		
		$read = array();
		$unread = array();
		foreach(array_reverse($list['notification']) as $listval) {	
			if(!empty($listval)) {
				$grouped = $this->groupEntity($list['relation'][ $listval ]['list']);
				if(!empty($grouped)) {
					if($list['relation'][ $listval ]['read']){
						if(count($read) < $readSlice){
							$read[] = array(
								"grouped" => $grouped,
								"count" => empty($list['relation'][ $listval ]['count']) ? count($list['relation'][ $listval ]['list']) : $list['relation'][ $listval ]['count'] 
							);	
						}
					} else {
						$unread[] = array(
							"grouped" => $grouped,
							"count" => empty($list['relation'][ $listval ]['count']) ? count($list['relation'][ $listval ]['list']) : $list['relation'][ $listval ]['count']
						);
					}
				}
			}
		}
		
		// we are only ever asked for notifications for Wikis that are on WikiList
		// so if there are no unread notifications for that Wiki it should not
		// be on that list (this will save us some work for checking & fetching
		// notifications that are in fact, empty, since current Wiki is
		// an exception and is always checked this works for read notification
		// as well)
		if( count($unread) == 0 ) {
			$this->remWikiFromList( $userId, $wikiId );
		}
		
		
		$out = array(
			'unread'=> $unread,
			'unread_count' => count($unread),
			'read' => $read,
			'read_count' => count($read)
		);
		return $out; 
	}

	public function getCounts($userId, $forceCurrentWiki = true) {
		$wikiList = $this->getWikiList($userId, $forceCurrentWiki);
		
		$output = array();
		
		foreach($wikiList as $wiki) {
			$wiki['unread'] = $this->getCount($userId, $wiki['id']);
			
			// show only Wikis with unread notifications
			// current Wiki is an exception (show always)
			if( $wiki['unread'] > 0 || $wiki['id'] == $this->app->wg->CityId )
				$output[] = $wiki;
		}
		return $output;
	}
	
	private function getCount($userId, $wikiId) {
		// fixme
		// should not to do the whole work of WikiNotifications
		$notifs = $this->getWikiNotifications($userId, $wikiId);
		return $notifs['unread_count'];
	}
	
	private function getWikiList($userId, $forceCurrentWiki = true) {
		// $forceCurrentWiki = true - always return current wiki as part of the list
		// $forceCurrentWiki = false - return only wikis that ever recived notifications
		
		$key = $this->getKey($userId, 'LIST');
		$val = $this->app->getGlobal('wgMemc')->get($key);
		
		if(empty($val)) {
			$val = $this->loadWikiListFromDB($userId);
			$this->app->getGlobal('wgMemc')->set($key, $val);
		}

		// make sure that current Wiki is on the list, as first entry, sort the rest
		asort($val);
		if($forceCurrentWiki === true) {
			unset($val[ $this->app->wg->CityId ]);
			$output = array( array( 
				'id' => $this->app->wg->CityId, 
				'wgServer' => $this->getWgServer($this->app->wg->CityId),
				'sitename' => $this->app->wg->sitename) );
		} else {
			$output = array();
		}
		foreach($val as $wikiId => $wikiSitename) {
			$output[] = array( 
				'id' => $wikiId, 
				'wgServer' => $this->getWgServer($wikiId),
				'sitename' => $wikiSitename
			);
		}
		return $output;
			
	}
	
	private function getWgServer($id) {
		$url = WikiFactory::getVarValueByName("wgServer", $id );
		if (!empty($this->app->wg->DevelEnvironment)) {
			$url = str_replace('wikia.com', $this->app->wg->DevelEnvironmentName.'.wikia-dev.com',$url);
		}
		return $url;
	}
	
	private function addWikiToList($userId, $wikiId, $wikiSitename) {
		$key = $this->getKey($userId, 'LIST');
		$val = $this->app->getGlobal('wgMemc')->get($key);
		
		if(empty($val)) {
			$val = $this->loadWikiListFromDB($userId);
		}
		
		$val[$wikiId] = $wikiSitename;
		
		$this->app->getGlobal('wgMemc')->set($key, $val);
		
	}

	private function remWikiFromList($userId, $wikiId) {
		// TODO / FIXME
		// Currently there is a race condition in WikiList.
		// Access to memcache key is not synchronized,
		// waiting for new memcache implementation code
		// that supports update-if-key-did-not-change
		
		$key = $this->getKey($userId, 'LIST');
		$val = $this->app->getGlobal('wgMemc')->get($key);
		
		if(empty($val)) {
			// removing Wiki from list is just speed optimization
			// if list is not cached in memory there is no
			// need to recreate it from DB
		} else {
			unset( $val[$wikiId] );
			$this->app->getGlobal('wgMemc')->set($key, $val);
		}
	}
	
	private function loadWikiListFromDB($userId) {
		$db = $this->getDB(false);
		$res = $db->select('wall_notification',
			array('distinct wiki_id'),
			array(
				'user_id' => $userId,
			),
			__METHOD__
		);
		$output = array();
		while($row = $db->fetchRow($res)) {
			$output[ $row['wiki_id'] ] = $sitename = WikiFactory::getWikiByID( $row['wiki_id'] )->city_title;
		}
		return $output;
	}
	
	protected function groupEntity($list){
		$grouped = array();
		foreach(array_reverse($list) as $obj ) {
			$notif = F::build('WallNotificationEntity', array($obj['entityKey']), 'getById');
			if(!empty($notif))
				$grouped[] = $notif;
		}
		return $grouped;
	}

	public function addNotification(RecentChange $RC) {
		
		$rev = Revision::newFromId($RC->getAttribute('rc_this_oldid'));
		$notif = F::build('WallNotificationEntity', array($rev, $this->app->wg->CityId), 'createFromRev');
		if(!empty($notif)) {
			$this->notifyEveryone($notif);
		}
	}

	/*
	 * Helper functions
	 */
	
	public function notifyEveryone($notification) {
		$users = array();
		
		if(empty($notification->data_noncached) || empty($notification->data_noncached->parent_title_dbkey)) {
			$title = "";
		} else {
			$title = $notification->data_noncached->parent_title_dbkey;
		}
		
		$users = $this->getWatchlist($notification->data->wall_username, $title);
	
		//FB:#11089
		$users[$notification->data->wall_userid] = $notification->data->wall_userid;
		
		if(!empty($users[$notification->data->msg_author_id])){
			unset($users[$notification->data->msg_author_id]);	
		} 

		$title = Title::newFromText($notification->data->wall_username. '/' . $notification->data->title_id, NS_USER_WALL ); 
		$this->sendEmails(array_keys($users), $notification );
		$this->addNotificationLinks($users, $notification);
	}
	
	protected function createKeyForMailNotification($watcher, $notification) {
		$key = 'mail-notification-';

		if($notification->isMain()) {
			$key .= 'new-';
			if($watcher == $notification->data->wall_userid ) {
				$key .= 'your';
			} else {
				$key .= 'someone';
			}
		} else {
			$key .= 'reply-';
			
			if( $watcher == $notification->data->parent_user_id ) {
				$key .= 'your';
			} elseif( $notification->data->msg_author_id == $notification->data->parent_user_id && $notification->data->msg_author_id != 0 ) {
				$key .= 'his';
			} else {
				$key .= 'someone';
			}	
		}
		return $key;
	}
	
	protected function sendEmails($watchers, $notification) {
		$watchersOut = array();
		
		$text = strip_tags($notification->data_non_cached->msg_text, '<p><br>');
		$text = substr($text,0,3000).( strlen($text) > 3000 ? '...':'');
		
		$textNoHtml = preg_replace('#<br\s*/?>#i', "\n", $text);
		$textNoHtml = trim(preg_replace('#</?p\s*/?>#i', "\n", $textNoHtml));
		$textNoHtml = substr($textNoHtml,0,3000).( strlen($textNoHtml) > 3000 ? '...':'');
		
		foreach($watchers as $val){
			$watcher = User::newFromId($val);
			if( $watcher->getId() != 0 && ($watcher->getOption('enotifwallthread') )
				|| ($watcher->getOption('enotifmywall') && $notification->data->wall_userid == $watcher->getId())
			) {
				$key = $this->createKeyForMailNotification( $watcher->getId(), $notification );
				
				$watcherName = $watcher->getRealName();
				if(empty($watcherName)) {
					$watcherName = $watcher->getName();	
				}
				
				if( $notification->data->msg_author_username == $notification->data->msg_author_displayname) {
					$author_signature = $notification->data->msg_author_username;
				} else {
					$author_signature = $notification->data->msg_author_displayname . '(' . $notification->data->msg_author_username . ')';
				}
				
				$data = array(
					'$WATCHER' => $watcherName,
					'$WIKI' => $notification->data->wikiname,
					'$PARENT_AUTHOR_NAME' => (empty($notification->data->parent_displayname) ? '':$notification->data->parent_displayname),
					'$AUTHOR_NAME' => $notification->data->msg_author_displayname,
					'$AUTHOR' => $notification->data->msg_author_username,
					'$AUTHOR_SIGNATURE' => $author_signature,
					'$MAIL_SUBJECT' => wfMsg('mail-notification-subject', array(
						'$1' => $notification->data->thread_title,
						'$2' => $notification->data->wikiname
					)),
					'$METATITLE' => $notification->data->thread_title,
					'$MESSAGE_LINK' =>  $notification->data->url,
					'$MESSAGE_NO_HTML' =>  $textNoHtml,
					'$MESSAGE_HTML' =>  $text,
				);
				
				$this->sendEmail($watcher, $key, $data);
			}
		}
		
		return true;
	}
	
	protected function sendEmail($watcher, $key, $data ) {
		$from = new MailAddress( $this->app->wg->PasswordSender, 'Wikia' );
		$replyTo = new MailAddress ( $this->app->wg->NoReplyAddress );
		
		$keys = array_keys($data);
		$values =  array_values($data);
		
		$subject = wfMsgForContent($key);
		
		$text = wfMsgForContent('mail-notification-body');
		
		$subject = str_replace($keys, $values, $subject);
		
		$keys[] = '$SUBJECT';
		$values[] = $subject;
		$data['$SUBJECT'] = $subject; 
		$html = wfRenderPartial('WallExternal', 'mail', array('data' => $data));
		$text = str_replace($keys, $values, $text);
		
		return $watcher->sendMail( $data['$MAIL_SUBJECT'], $text, $from, $replyTo, 'WallNotification', $html );
	}

	protected function getWatchlist($name, $titleDbkey) {
		//TODO: add some caching
		$userTitle = Title::newFromText( $name, NS_USER_WALL );
		
		$dbw = $this->getLocalDB(true);
		$res = $dbw->select( array( 'watchlist' ),
			array( 'wl_user' ),
			array(
				'wl_title' => array($titleDbkey, $userTitle->getDBkey() ),
				'wl_namespace' => array(NS_USER_WALL, NS_USER_WALL_MESSAGE)
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
			$this->addWikiToList($userId, $this->app->wg->CityId, $this->app->wg->sitename);
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
		$updateDBlist = array(); // we will update database AFTER unlocking
		
		$wasUnread = false; // function returns True if in fact there was unread
							// notification

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
						if($data['relation'][ $value ]['read'] == false) {
							$wasUnread = true;
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
		
		return $wasUnread;
	}

	public function markReadAllWikis( $userId ) {
		$list = $this->getWikiList( $userId );
		foreach( $list as $wikiData ) {
			$this->markRead( $userId, $wikiData['id'] );
		}
	}

	protected function addNotificationLinkInternal($userId, $wikiId, $uniqueId, $entityKey, $authorId, $isReply ) {
		if($userId < 1) {
			return true;
		}
		$this->storeInDB($userId, $wikiId, $uniqueId, $entityKey, $authorId, $isReply); 
		//id use to prevent having of extra entry after memc fail.   
		
		// if the object is in memory, update it, if not, skip it (it will be rebuild from db at some point anyway)
		if($this->isCachedData($userId, $wikiId)) {
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
		}
	}
	
	protected function sleep($userId, $wikiId){
		$time = 100000 - $count*1000; //change priority of process with access to resource
		if($time < 0) {
			$time = 0;
		}
		usleep(100000 + $time);		
	}
	
	protected function addNotificationToData(&$data, $uniqueId, $entityKey, $authorId, $isReply, $read = false) {
		$data['notification'][] = $uniqueId;
		
		if(isset($data['relation'][ $uniqueId ]['last']) && $data['relation'][ $uniqueId ]['last'] > -1) {
			// $data['notification'][ $data['relation'][$uniqueId ]['last'] ] = null;
			
			// remove previous element from the list (to keep proper ordering)
			unset( $data['notification'][ $data['relation'][$uniqueId ]['last'] ] );
		}

		if(empty($data['relation'][ $uniqueId ]['list']) || $data['relation'][ $uniqueId ]['read'] ) {
			// this is new Notification (new thread), so create some basic structure for it
			$data['relation'][ $uniqueId ]['list'] = array();
			$data['relation'][ $uniqueId ]['count'] = 0;
			$data['relation'][ $uniqueId ]['read'] = false;
		}

		// if there is no count for this Thread notification, create it
		if(empty($data['relation'][ $uniqueId ]['count'])) $data['relation'][ $uniqueId ]['count'] = count($data['relation'][ $uniqueId ]['list']);
		
		// keep track of where we are references in Notifications list, so that
		// we can remove that entry and readd it at the end, should the new
		// notification for that thread come in (to keep proper order)
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
				$data['relation'][ $uniqueId ]['count'] = 0;
			}
		}
		
		// scan relation list, remove element that has the same author
		$found = false;
		
		foreach( $data['relation'][ $uniqueId ]['list'] as $key=>$rel ) {
			if( $rel['authorId'] == $authorId ) {
				unset($data['relation'][ $uniqueId ]['list'][$key]);
				$found = true;
			}
		}
		
		// if we didn't find same author in our list, we need to remove oldest element
		if( $found == false && count($data['relation'][ $uniqueId ]['list']) > 2 )
			array_shift($data['relation'][ $uniqueId ]['list']);
		
		// add new element
		$data['relation'][ $uniqueId ]['list'][] = array('entityKey' => $entityKey, 'authorId' => $authorId, 'isReply'=>$isReply);
		
		// if this was new author increase author count
		if($found == false) $data['relation'][ $uniqueId ]['count'] += 1;
	
		$data['relation'][ $uniqueId ]['read'] = $read;			
		
	}
	
	protected function isCachedData($userId, $wikiId) {
		$key = $this->getKey($userId, $wikiId);
		$val = F::App()->getGlobal('wgMemc')->get($key);
		
		if(empty($val) && !is_array($val)) {
			return False;
		}
		
		return True;
	}

	protected function getData($cache, $userId, $wiki) {
		$val = $cache->get();
		
		if(empty($val) && !is_array($val)) {
			$val = $this->rebuildData($userId, $wiki);
		}
		
		return $val;
	}
	
	protected function setData($cache, $data) {
		//$cache->delete();
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
			$this->addNotificationToData($data, $value['unique_id'], $value['entity_key'], $value['author_id'], $value['is_reply'], $value['is_read']);
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
		return $this->app->runFunction( 'wfSharedMemcKey', __CLASS__, $userId, $wikiId. 'v22' );
	}
}
