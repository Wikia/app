<?php
/*
 * in here we render Notifications in top-right corner of Wikia interface
 */

class WallNotificationsController extends WikiaController {

	public function __construct() {
		$this->app = F::App();
	}
	
	public function Index() {
		wfProfileIn(__METHOD__);
		
		if($this->wg->User->isLoggedIn()) {
		
			$wn = F::build('WallNotifications', array());
			
			$this->response->addAsset('extensions/wikia/Wall/js/WallNotifications.js');
			$this->response->addAsset('extensions/wikia/Wall/css/WallNotifications.scss');
				
		}

		$this->response->setVal('user', $this->wg->User);
		
		wfProfileOut(__METHOD__);
	}

	public function Update() {
		wfProfileIn(__METHOD__);
		
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
			$realname = $authoruser->getRealName();
			$username = $authoruser->getName();
			if($authoruser->getId() > 0) {
				$displayname = empty($realname) ? $username : $realname;	
			} else {
				$displayname = $this->app->wf->Msg('oasis-anon-user');	
			}
		} else {
			//annon
			$displayname = $app->wf->Msg('oasis-anon-user');
		}
		
		$wall_realname = $walluser->getRealName();
		$wall_username = $walluser->getName();
		$wall_displayname = empty($wall_realname) ? $wall_username:$wall_realname;
		
		$authors = array();
		$authors[] = array(
			'displayname' => $displayname,
			'username' => $username
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
		$this->response->setVal( 'title',  $data->title );
		$this->response->setVal( 'iso_timestamp',  wfTimestamp(TS_ISO_8601, $data->timestamp ));
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
		
		$my_name = $this->wg->User->getName();
		
		$params = array();
		//Msg('msgid', array( '$1'=>
		
		if(!$notify['grouped'][0]->isMain()) {
			//$params[] = $data->msg_author_displayname;
			$params[] = $this->getDisplayname($data->msg_author_displayname);
			
			$user_count = 1;// 1 = 1 user,
							// 2 = 2 users,
							// 3 = more than 2 users
			
			if(count($authors) == 2)     { $user_count = 2; $params['$1'] = $this->getDisplayname( $authors[1]['displayname'] ); }
			elseif(count($authors) > 2 ) { $user_count = 3; /*$params['$'.(count($params)+1)] = $notify['count'];*/ }
			
			$reply_by = 'other'; // who replied?
							   // you = same as person receiving notification
							   // self = same as person who wrote original message (parent)
							   // other = someone else
			
			if( $data->parent_username == $my_name ) $reply_by = 'you';
			elseif ( in_array($data->parent_username, $authors) ) $reply_by = 'self';
			else $params['$'.(count($params)+1)] =$this->getDisplayname( $data->parent_displayname );
			
			$whos_wall = 'a'; // on who's wall was the message written?
								   // your  = on message author's wall
								   // other = on someone else's wall
								   // a     = the person was already mentioned (either author of msg or thread)
			
			if( $data->wall_username == $my_name ) $whos_wall = 'your';
			elseif( $data->wall_username != $data->parent_username && !in_array($data->wall_username, $authors) ) {
				$whos_wall = 'other';
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->wall_displayname);
			}
			
			$msgid = "wn-user$user_count-reply-$reply_by-$whos_wall-wall";
		} else {
			if( $data->wall_username == $my_name) {
				$msgid = 'wn-newmsg-onmywall';
				//$params['$'.(count($params)+1)] = $data->msg_author_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->msg_author_displayname);
			} else if( $data->msg_author_username != $my_name ) {
				$msgid = 'wn-newmsg-on-followed-wall';
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->msg_author_displayname);
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->wall_displayname);
			} else {
				$msgid = 'wn-newmsg';
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->wall_displayname);
			}
		}
		
		$unread = $this->request->getVal('unread');
		$this->response->setVal( 'unread', $unread );
		if(!$unread) $authors = array_slice($authors, 0, 1);
		
		$msg = wfMsgExt($msgid, array( 'parsemag'), $params);
		$this->response->setVal( 'msg', $msg );
		if ( empty( $data->url ) ) $data->url = '';
		$this->response->setVal( 'url', $this->fixNotificationURL($data->url) );
		$this->response->setVal( 'authors', array_reverse($authors) );
		$this->response->setVal( 'title',  $data->thread_title );
		$this->response->setVal( 'iso_timestamp',  wfTimestamp(TS_ISO_8601, $data->timestamp ));
	}

	private function getDisplayname($username) {
		if( User::isIP($username) ) return wfMsg('oasis-anon-user');
		return $username;
	}
}

