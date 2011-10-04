<?php
/*
 * in here we render Notifications in top-right corner of Wikia interface
 */

class WallNotificationsModule extends Module {
	public function executeIndex() {
		global $wgUser;
		wfProfileIn(__METHOD__);
		
		$wn = F::build('WallNotifications', array());
		
		$this->response->addAsset('extensions/wikia/Wall/js/WallNotifications.js');
		$this->response->addAsset('extensions/wikia/Wall/css/WallNotifications.scss');
		
		$this->response->setVal('user', $wgUser);
		
		wfProfileOut(__METHOD__);
	}

	public function executeUpdate() {
		wfProfileIn(__METHOD__);
				
		$all = $this->request->getVal('notifications');
		
		//var_dump($all);
		
		$this->response->setVal('user', $this->wg->User);
		
		$this->response->setVal('unread',$all['unread']);
		$this->response->setVal('read',$all['read']);
		$this->response->setVal('count',$all['unread_count']);
		
		//$duration = 60; // one minute
		//$this->response->setHeader('X-Pass-Cache-Control', 'public, max-age=' . $duration);
		
		wfProfileOut(__METHOD__);
	}
	
	public function executeNotification() {
		$notify = $this->request->getVal('notify');
		$data = $notify['grouped'][0]->data;
		$authors = array();
		foreach($notify['grouped'] as $notify_entity) {
			//$authors[] = $notify_entity->data->msg_author_displayname;
			$authors[] = $notify_entity->data->msg_author_username;
		}

		$my_name = $this->wg->User->getName();
		
		$params = array();
		//Msg('msgid', array( '$1'=>
		
		
		if(!$notify['grouped'][0]->isMain()) {
			//$params[] = $data->msg_author_displayname;
			$params[] = $this->getDisplayname($data->msg_author_username);

			$user_count = 1;// 1 = 1 user,
							// 2 = 2 users,
							// 3 = more than 2 users

			if(count($authors) == 2)     { $user_count = 2; $params['$1'] = $authors[1]; }
			elseif(count($authors) > 2 ) { $user_count = 3; }

			$reply_by = 'other'; // who replied?
							   // you = same as person receiving notification
							   // self = same as person who wrote original message (parent)
							   // other = someone else

			if( $data->parent_username == $my_name ) $reply_by = 'you';
			elseif ( $data->parent_username == $data->msg_author_username ) $reply_by = 'self';
			else $params['$'.(count($params)+1)] =$this->getDisplayname( $data->parent_username );

			$whos_wall = 'a'; // on who's wall was the message written?
								   // your  = on message author's wall
								   // other = on someone else's wall
								   // a     = the person was already mentioned (either author of msg or thread)

			if( $data->wall_username == $my_name ) $whos_wall = 'your';
			elseif( $data->wall_username != $data->parent_username && $data->wall_username != $data->msg_author_username ) {
				$whos_wall = 'other';
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->wall_username);
			}
			
			$msgid = "wn-user$user_count-reply-$reply_by-$whos_wall-wall";
			
		} else {
			if( $data->wall_username == $my_name) {
				$msgid = 'wn-newmsg-onmywall';
				//$params['$'.(count($params)+1)] = $data->msg_author_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->msg_author_username);
			} else {
				$msgid = 'wn-newmsg';				
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $this->getDisplayname($data->wall_username);
			}
		}

		$unread = $this->request->getVal('unread');
		$this->response->setVal( 'unread', $unread );
		if(!$unread) $authors = array_slice($authors, 0, 1);

		$msg = wfMsg($msgid, $params);
		$this->response->setVal( 'msg', $msg );
		if ( empty( $data->url ) ) $data->url = '';
		$this->response->setVal( 'url', $data->url );
		$this->response->setVal( 'authors', $authors );
		$this->response->setVal( 'title',  $data->thread_title );
		$this->response->setVal( 'iso_timestamp',  wfTimestamp(TS_ISO_8601, $data->timestamp ));
	}

	private function getDisplayname($username) {
		if(User::isIP($username)) return wfMsg('oasis-anon-user');
		return $username;
	}
}

