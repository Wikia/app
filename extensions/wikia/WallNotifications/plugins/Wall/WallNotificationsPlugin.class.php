<?php

class WallNotificationsPlugin {

	static public function onGetNotificationMessage($nc, &$msg, $isMain, $data, $authors, $userCount, $myName) {
		if ( empty( $data->article_title_ns ) || MWNamespace::getSubject( $data->article_title_ns ) != NS_USER_WALL ) {
			return true;
		}

		$params = array();
		if(!$isMain) {
			//$params[] = $data->msg_author_displayname;
			$params[] = $nc->getDisplayname($data->msg_author_displayname);

			if($userCount == 2) {
				$params['$1'] = $nc->getDisplayname( $authors[1]['displayname'] );
			}

			$reply_by = 'other'; // who replied?
							   // you = same as person receiving notification
							   // self = same as person who wrote original message (parent)
							   // other = someone else

			if( $data->parent_username == $myName ) $reply_by = 'you';
			elseif ( in_array($data->parent_username, $authors) ) $reply_by = 'self';
			else $params['$'.(count($params)+1)] =$nc->getDisplayname( $data->parent_displayname );

			$whos_wall = 'a'; // on who's wall was the message written?
								   // your  = on message author's wall
								   // other = on someone else's wall
								   // a     = the person was already mentioned (either author of msg or thread)

			if( $data->wall_username == $myName ) $whos_wall = 'your';
			elseif( $data->wall_username != $data->parent_username && !in_array($data->wall_username, $authors) ) {
				$whos_wall = 'other';
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $nc->getDisplayname($data->wall_displayname);
			}

			$msgid = "wn-user$userCount-reply-$reply_by-$whos_wall-wall";
		} else {
			if( $data->wall_username == $myName) {
				$msgid = 'wn-newmsg-onmywall';
				//$params['$'.(count($params)+1)] = $data->msg_author_displayname;
				$params['$'.(count($params)+1)] = $nc->getDisplayname($data->msg_author_displayname);
			} else if( $data->msg_author_username != $myName ) {
				$msgid = 'wn-newmsg-on-followed-wall';
				$params['$'.(count($params)+1)] = $nc->getDisplayname($data->msg_author_displayname);
				$params['$'.(count($params)+1)] = $nc->getDisplayname($data->wall_displayname);
			} else {
				$msgid = 'wn-newmsg';
				//$params['$'.(count($params)+1)] = $data->wall_displayname;
				$params['$'.(count($params)+1)] = $nc->getDisplayname($data->wall_displayname);
			}
		}
		$msg = wfMsgExt($msgid, array( 'parsemag'), $params);

		return true;
	}

	static public function onGetMailNotificationMessage($notification, &$data, $key, $watcherName, $author_signature, $textNoHtml, $text) {
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
			'$MSG_KEY_SUBJECT' => $key,
			'$MSG_KEY_BODY' => 'mail-notification-body',
			'$MSG_KEY_GREETING' => 'mail-notification-html-greeting',
		);

		return true;
	}

}
