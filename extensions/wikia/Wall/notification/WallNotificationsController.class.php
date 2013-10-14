<?php
/*
 * in here we render Notifications in top-right corner of Wikia interface
 */


class WallNotificationsController extends WikiaController {

	const NOTIFICATION_TITLE_LIMIT = 48;

	public function __construct() {
		$this->app = F::App();
	}

	public function Index() {
		wfProfileIn( __METHOD__ );
		$loggedIn = $this->wg->User->isLoggedIn();
		$suppressWallNotifications = $this->areNotificationsSuppressedByExtensions();

		if( $loggedIn && !$suppressWallNotifications ) {
			$this->response->addAsset( 'extensions/wikia/Wall/js/WallNotifications.js' );
			$this->response->addAsset( 'extensions/wikia/Wall/css/WallNotifications.scss' );
			$this->response->setVal( 'prehide', ( empty( $this->wg->EnableWallExt ) && empty( $this->wg->EnableForumExt ) ) );
		}

		$this->response->setVal( 'loggedIn', $loggedIn );
		$this->response->setVal( 'suppressWallNotifications', $suppressWallNotifications );
		wfProfileOut( __METHOD__ );
	}

	public function Update() {
		wfProfileIn(__METHOD__);

		$this->response->setVal('alwaysGrouped', empty($this->app->wg->EnableWallExt) && empty($this->app->wg->EnableForumExt)  );

		$this->response->setVal('notificationKey', $this->request->getVal('notificationKey') );

		$notificationCounts = $this->request->getVal('notificationCounts');

		$this->response->setVal('notificationCounts', $notificationCounts);

		$unreadCount = $this->request->getVal('count');
		$this->response->setVal('count', $unreadCount);


		$this->response->setVal('user', $this->wg->User);


		//$duration = 60; // one minute
		//$this->response->setHeader('X-Pass-Cache-Control', 'public, max-age=' . $duration);

		wfProfileOut(__METHOD__);
	}

	public function UpdateWiki() {
		wfProfileIn(__METHOD__);

		$all = $this->request->getVal('notifications');

		$this->response->setVal('user', $this->wg->User);
		$this->response->setVal('unread', $all['unread']);
		$this->response->setVal('read', $all['read']);

		//$this->response->setVal('count', $all['unread_count']);

		//$duration = 60; // one minute
		//$this->response->setHeader('X-Pass-Cache-Control', 'public, max-age=' . $duration);

		wfProfileOut(__METHOD__);
	}

	public function NotificationAdmin() {
		$notify = $this->request->getVal('notify');
		$data = $notify['grouped'][0]->data;

		$authoruser = User::newFromId($data->user_removing_id);
		$walluser = User::newFromId($data->user_wallowner_id);

		if( $authoruser instanceof User ) {
			if($authoruser->getId() > 0) {
				$displayname = $authoruser->getName();
			} else {
				$displayname = wfMsg('oasis-anon-user');
			}
		} else {
			//annon
			$displayname = wfMsg('oasis-anon-user');
		}

		$wall_displayname = $walluser->getName();

		$authors = array();
		$authors[] = array(
			'displayname' => $displayname,
			'username' => $displayname
		);

		if( $data->type == 'OWNER' ) {
			if( !$data->is_reply ) {
				$msg = wfMsg( 'wn-owner-thread-deleted' );
			} else {
				$msg = wfMsg( 'wn-owner-reply-deleted' );
			}
		} else {
			if( !$data->is_reply ) {
				$msg = wfMsg( 'wn-admin-thread-deleted', array( $wall_displayname ) );
			} else {
				$msg = wfMsg( 'wn-admin-reply-deleted', array( $wall_displayname ) );
			}
		}

		$this->response->setVal( 'url', $this->fixNotificationURL($data->url) );
		$this->response->setVal( 'msg', $msg );
		$this->response->setVal( 'authors', $authors );
		$this->response->setVal( 'title', $data->title );
		$this->response->setVal( 'iso_timestamp',  wfTimestamp(TS_ISO_8601, $data->timestamp ));
	}

	private function areNotificationsSuppressedByExtensions() {
		$suppressed = $this->app->wg->atCreateNewWikiPage || !$this->app->wg->User->isAllowed( 'read' );
		return !empty($suppressed);
	}

	private function fixNotificationURL($url) {
		global $wgStagingList;
		$hostOn = getHostPrefix();

		$hosts = $wgStagingList;
		foreach($hosts as $host){
			$prefix = 'http://'.$host.'.';
			if(strpos($url, $prefix)  !== false ) {
				if(empty($hostOn)) {
					return str_replace($prefix, 'http://', $url );
				} else {
					return str_replace($prefix, 'http://'.$hostOn.'.', $url );
				}
			}
		}

		if(!empty($hostOn)){
			return str_replace('http://', 'http://'.$hostOn.'.', $url );
		}

		return $url;
	}

	public function Notification() {
		$notify = $this->request->getVal('notify');
		if(empty($notify['grouped'][0])) {
			// do not render this notification, it's bugged
			return false;
		}
		$data = $notify['grouped'][0]->data;
		if(isset($data->type) && $data->type === 'ADMIN') {
			$this->forward(__CLASS__, 'NotificationAdmin');
			return;
		}
		$data = $notify['grouped'][0]->data;
		if(isset($data->type) && $data->type === 'OWNER') {
			$this->forward(__CLASS__, 'NotificationAdmin');
			return;
		}
		$authors = array();
		foreach($notify['grouped'] as $notify_entity) {
			$authors[] = array(
				'displayname' => $notify_entity->data->msg_author_displayname,
				'username' => $notify_entity->data->msg_author_username );
		}

		// 1 = 1 user,
		// 2 = 2 users,
		// 3 = more than 2 users

		$userCount = 1;
		if(count($authors) == 2){
			$userCount = 2;
		} elseif(count($authors) > 2 ) {
			$userCount = 3;
		}

		$msg = "";
		wfRunHooks('NotificationGetNotificationMessage', array(&$this, &$msg, $notify['grouped'][0]->isMain(), $data, $authors,$userCount,  $this->wg->User->getName()) );

		if(empty($msg)) {
			$msg = $this->getNotificationMessage($notify['grouped'][0]->isMain(), $data, $authors,$userCount,  $this->wg->User->getName());
		}

		$unread = $this->request->getVal('unread');
		$this->response->setVal( 'unread', $unread );
		if(!$unread) $authors = array_slice($authors, 0, 1);

		$this->response->setVal( 'msg', $msg );

		// The instances of `WallNotificationEntity` in the `$notify['grouped']` array are sorted in reverse
		// chronological order. We want the url to point to the oldest unread item (which is the last element in the
		// array) instead of the most recent so that they start reading where the left off. See bugid 64560.
		$oldestEntity = end( $notify['grouped'] );
		if ( empty( $oldestEntity->data->url ) ) {
			$oldestEntity->data->url = '';
		}

		$this->response->setVal( 'url', $this->fixNotificationURL( $oldestEntity->data->url ) );
		$this->response->setVal( 'authors', array_reverse($authors) );
		$this->response->setVal( 'title', $data->thread_title );
		$this->response->setVal( 'iso_timestamp',  wfTimestamp(TS_ISO_8601, $data->timestamp ));

		if($unread && $data->notifyeveryone) {
			$this->response->getView()->setTemplate( 'WallNotificationsController', 'NotifyEveryone' );
		}
	}

	private function getNotificationMessage($isMain, $data, $authors, $userCount, $myName) {
		$params = array();
		if(!$isMain) {
			//$params[] = $data->msg_author_displayname;
			$params[] = $this->getDisplayname($data->msg_author_displayname);

			if($userCount == 2) {
				$params['$1'] = $this->getDisplayname( $authors[1]['displayname'] );
			}

			$reply_by = 'other'; // who replied?
							   // you = same as person receiving notification
							   // self = same as person who wrote original message (parent)
							   // other = someone else

			if( $data->parent_username == $myName ) $reply_by = 'you';
			elseif ( in_array($data->parent_username, $authors) ) $reply_by = 'self';
			else $params['$'.(count($params)+1)] =$this->getDisplayname( $data->parent_displayname );

			$whos_wall = 'a'; // on who's wall was the message written?
								   // your  = on message author's wall
								   // other = on someone else's wall
								   // a     = the person was already mentioned (either author of msg or thread)

			if( $data->wall_username == $myName ) $whos_wall = 'your';
			elseif( $data->wall_username != $data->parent_username && !in_array($data->wall_username, $authors) ) {
				$whos_wall = 'other';
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->wall_displayname);
			}

			$msgid = "wn-user$userCount-reply-$reply_by-$whos_wall-wall";
		} else {
			if( $data->wall_username == $myName) {
				$msgid = 'wn-newmsg-onmywall';
				//$params['$'.(count($params)+1)] = $data->msg_author_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->msg_author_displayname);
			} else if( $data->msg_author_username != $myName ) {
				$msgid = 'wn-newmsg-on-followed-wall';
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->msg_author_displayname);
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->wall_displayname);
			} else {
				$msgid = 'wn-newmsg';
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->wall_displayname);
			}
		}
		$msg = wfMsgExt($msgid, array( 'parsemag'), $params);
		return $msg;
	}

	public function getDisplayname($username) {
		if( User::isIP($username) ) return wfMsg('oasis-anon-user');
		return $username;
	}

	public function checkTopic() {
		// force json format
		$this->getResponse()->setFormat( 'json' );

		$result = false;

		$topic = $this->getRequest()->getVal( 'query' );
		if( !empty( $topic ) ) {
			/** @var $title title */
			$title = Title::newFromText( $topic );

			if ( $title instanceof Title ) {
				$result = (bool) $title->exists();
			}
		}

		$this->response->setVal( 'exists' , $result );
	}

}

