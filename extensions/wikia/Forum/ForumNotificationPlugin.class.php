<?php
/**
 * ForumNotificationPlugin
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

//TODO: Consider to have some interface defined in the wall ext

class ForumNotificationPlugin {
	static public function onGetNotificationMessage($nc, &$msg, $isMain, $data, $authors, $userCount, $myName) {

		if ( empty( $data->article_title_ns ) || MWNamespace::getSubject( $data->article_title_ns ) != NS_WIKIA_FORUM_BOARD ) {
			return true;
		}

		if ( !$isMain ) {
			if ( $data->parent_username == $myName ) {
				$replyTo = "your";
			} else {
				$replyTo = "someone";
			}

			//$params[] = $data->msg_author_displayname;
			$params['$1'] = $nc->getDisplayname( $data->msg_author_displayname );
			$params['$2'] = "";

			if ( $userCount == 2 ) {
				$params['$2'] = $nc->getDisplayname( $authors[1]['displayname'] );
			}

			$params['$3'] = $data->article_title_text;

			$msgid = "forum-notification-user$userCount-reply-to-$replyTo";
		} else {
			$msgid = 'forum-notification-newmsg-on-followed-wall';

			$params['$1'] = $nc->getDisplayname( $data->msg_author_displayname );
			$params['$2'] = $data->wall_displayname;
		}

		$msg = wfMsgExt( $msgid, array( 'parsemag' ), $params );

		return true;
	}

	static public function onGetMailNotificationMessage($notification, &$data, $key, $watcherName, $author_signature, $textNoHtml, $text) {
		if ( empty( $notification->data->article_title_ns ) || MWNamespace::getSubject( $notification->data->article_title_ns ) != NS_WIKIA_FORUM_BOARD ) {
			return true;
		}

		$data = array(
			'$WATCHER' => $watcherName,
			'$BOARDNAME' => $notification->data->article_title_text,
			'$WIKI' => $notification->data->wikiname,
			'$AUTHOR_NAME' => $notification->data->msg_author_displayname,
			'$AUTHOR' => $notification->data->msg_author_username,
			'$AUTHOR_SIGNATURE' => $author_signature,
			'$MAIL_SUBJECT' => wfMsg( 'forum-mail-notification-subject', array( '$1' => $notification->data->thread_title, '$2' => $notification->data->wikiname ) ),
			'$METATITLE' => $notification->data->thread_title,
			'$MESSAGE_LINK' => $notification->data->url,
			'$MESSAGE_NO_HTML' => $textNoHtml,
			'$MESSAGE_HTML' => $text,
			'$MSG_KEY_SUBJECT' => 'forum-' . $key,
			'$MSG_KEY_BODY' => 'forum-mail-notification-body',
			'$MSG_KEY_GREETING' => 'forum-mail-notification-html-greeting'
		);

		return true;
	}

}
