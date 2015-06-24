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

			$secondUser = '';

			if ( $userCount == 2 ) {
				$secondUser = $nc->getDisplayname( $authors[1]['displayname'] );
			}

			$params = [
				$nc->getDisplayname( $data->msg_author_displayname ),
				$secondUser,
				$data->article_title_text,
				$myName,
			];

			// Messages that can be used here:
			// * forum-notification-user1-reply-to-your
			// * forum-notification-user2-reply-to-your
			// * forum-notification-user3-reply-to-your
			// * forum-notification-user1-reply-to-someone
			// * forum-notification-user2-reply-to-someone
			// * forum-notification-user3-reply-to-someone
			$msgKey = "forum-notification-user$userCount-reply-to-$replyTo";
		} else {
			$msgKey = 'forum-notification-newmsg-on-followed-wall';

			$params = [
				$nc->getDisplayname( $data->msg_author_displayname ),
				$data->wall_displayname,
			];
		}

		$msg = wfMessage( $msgKey, $params )->text();

		return true;
	}
}
