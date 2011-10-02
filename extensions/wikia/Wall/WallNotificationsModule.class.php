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
		
		$msgid  = 'wn-';
		$params = array();
		//Msg('msgid', array( '$1'=>
		
		if(!$notify['grouped'][0]->isMain()) {
			//$params[] = $data->msg_author_displayname;
			$params[] = $data->msg_author_username;
			if(count($authors) == 2) {
				$msgid .= 'user2-';
				$params['$1'] = $authors[1];
			} elseif(count($authors) > 2 ) {
				$msgid .= 'user3-';
			} else {
				$msgid .= 'user1-';
			}
			$msgid .= 'reply-';
			if( $data->parent_username == $my_name )
				$msgid .= 'you-';
			elseif ( $data->parent_username == $data->msg_author_username )
				$msgid .= 'self-';
			else {
				$msgid .= 'other-';
				//$params['$'.(count($params)+1)] = $data->parent_displayname;
				$params['$'.(count($params)+1)] = $data->parent_username;
			}
			if( $data->wall_username == $my_name )
				$msgid .= 'your-wall';
			else {
			//elseif( $data->wall_username != $data->parent_username && $data->wall_username != $data->msg_author_username ) {
				$msgid .= 'other-wall';
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $data->wall_username;
			}
		} else {
			if( $data->wall_username == $my_name) {
				$msgid = 'wn-newmsg-onmywall';
				//$params['$'.(count($params)+1)] = $data->msg_author_displayname;
				$params['$'.(count($params)+1)] = $data->msg_author_username;
			} else {
				$msgid = 'wn-newmsg';				
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $data->wall_username;
			}
		}

		$msg = wfMsg($msgid, $params);
		$this->response->setVal( 'msg', $msg );
		if ( empty( $data->url ) ) $data->url = '';
		$this->response->setVal( 'url', $data->url );
		$this->response->setVal( 'authors', $authors );
		$this->response->setVal( 'title',  $data->thread_title );
		$this->response->setVal( 'iso_timestamp',  wfTimestamp(TS_ISO_8601, $data->timestamp ));
		$this->response->setVal( 'unread', $this->request->getVal('unread') );
	}
}

