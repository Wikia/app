<?php

class DesignSystemGlobalNavigationWallNotificationsService extends WikiaService {

	const NOTIFICATION_TITLE_LIMIT = 48;

	public function Notification() {
		$wg = F::app()->wg;

		$notify = $this->request->getVal( 'notify' );

		if ( empty( $notify['grouped'][0] ) || empty( $notify['grouped'][0]->data ) ) {
			// do not render this notification, it's bugged
			return;
		}
		/** @var WallNotificationEntity $firstEntity */
		$firstEntity = $notify[ 'grouped' ][ 0 ];

		// for debugging purposes, remove when XW-5224 resolved
		if ( !( $firstEntity instanceof WallNotificationEntity ) ||
			!( $firstEntity instanceof WallNotificationAdminEntity ) ||
			!( $firstEntity instanceof WallNotificationOwnerEntity ) ) {
			\Wikia\Logger\WikiaLogger::instance()->notice(
				'Wall notification entity has wrong type',
				[ 'type' => gettype( $firstEntity ) ]
			);
		}

		$data = $firstEntity->data;

		// for debugging purposes, remove when XW-5224 resolved
		if ( !( $data instanceof stdClass ) ) {
			\Wikia\Logger\WikiaLogger::instance()->notice(
				'Wall notification entity data has wrong type',
				[ 'type' => gettype( $data ) ]
			);
		}

		if ( isset( $data->type ) && ( $data->type === 'ADMIN' || $data->type === 'OWNER' ) ) {
			$this->forward( get_class( $this ), 'NotificationAdmin' );
			return;
		}

		$authors = [ ];
		foreach ( $notify[ 'grouped' ] as $notify_entity ) {
			// for debugging purposes, remove when XW-5224 resolved
			if ( !( $notify_entity instanceof WallNotificationEntity ) ||
				!( $notify_entity instanceof WallNotificationAdminEntity ) ||
				!( $notify_entity instanceof WallNotificationOwnerEntity ) ) {
				\Wikia\Logger\WikiaLogger::instance()->notice(
					'Wall notification entity has wrong type',
					[ 'type' => gettype( $notify_entity ) ]
				);
			}

			if ( !empty( $notify_entity->data ) ) {
				// for debugging purposes, remove when XW-5224 resolved
				if ( !( $notify_entity->data instanceof stdClass ) ) {
					\Wikia\Logger\WikiaLogger::instance()->notice(
						'Wall notification entity data has wrong type',
						[ 'type' => gettype( $notify_entity->data ) ]
					);
				}

				$authors[] = [
					'displayname' => $notify_entity->data->msg_author_displayname,
					'username' => $notify_entity->data->msg_author_username,
					'avatar' => AvatarService::renderAvatar(
						$firstEntity->data->msg_author_username,
						AvatarService::AVATAR_SIZE_SMALL_PLUS
					)
				];
			} else {
				// for debugging purposes, remove when XW-5224 resolved
				\Wikia\Logger\WikiaLogger::instance()->notice(
					'Wall Notification entity has no data',
					[ 'data' => $notify_entity->data ]
				);
			}
		}

		// 1 = 1 user,
		// 2 = 2 users,
		// 3 = more than 2 users

		$userCount = count( $notify[ 'grouped' ] );
		if ( $userCount > 3 ) {
			$userCount = 3;
		}

		$msg = "";
		Hooks::run( 'NotificationGetNotificationMessage', [
			$this,
			&$msg,
			$firstEntity->isMain(),
			$data,
			$authors,
			$userCount,
			$wg->User->getName(),
		] );

		if ( empty( $msg ) ) {
			$msg = $this->getNotificationMessage(
				$firstEntity->isMain(),
				$data,
				$authors,
				$userCount,
				$wg->User->getName()
			);
		}
		$unread = $this->request->getVal( 'unread' );
		if ( !$unread ) {
			$authors = array_slice( $authors, 0, 1 );
		}

		$this->response->setVal( 'unread', $unread );
		$this->response->setVal( 'msg', $msg );

		// The instances of `WallNotificationEntity` in the `$notify['grouped']` array are sorted in reverse
		// chronological order. We want the url to point to the oldest unread item (which is the last element in the
		// array) instead of the most recent so that they start reading where the left off. See bugid 64560.
		$oldestEntity = end( $notify[ 'grouped' ] );
		$url = empty( $oldestEntity->data->url ) ? '' : $oldestEntity->data->url;
		$title = $this->shortenTitle( $data->thread_title ?? '' );
		$this->response->setVal( 'url', WikiFactory::getLocalEnvURL( $url ) );
		$this->response->setVal( 'authors', array_reverse( $authors ) );
		$this->response->setVal( 'title', $title );
		$this->response->setVal( 'iso_timestamp', wfTimestamp( TS_ISO_8601, $data->timestamp ) );

		$this->response->setVal( 'isUnread', $unread ? 'unread' : 'read' );
		if ( $unread && $data->notifyeveryone ) {
			$this->overrideTemplate( 'NotifyEveryone' );
		}
	}

	public function NotificationAdmin() {
		$notify = $this->request->getVal( 'notify' );
		$data = $notify[ 'grouped' ][ 0 ]->data;

		$authoruser = User::newFromId( $data->user_removing_id );
		$walluser = User::newFromId( $data->user_wallowner_id );

		if ( $authoruser instanceof User && $authoruser->getId() > 0 ) {
			$displayname = $authoruser->getName();
		} else {
			$displayname = wfMessage( 'oasis-anon-user' )->escaped();
		}

		$wall_displayname = $walluser->getName();

		$authors = [ ];
		$authors[] = [
			'displayname' => $displayname,
			'username' => $displayname
		];

		if ( $data->type == 'OWNER' ) {
			if ( !$data->is_reply ) {
				$msg = wfMessage( 'wn-owner-thread-deleted' )->escaped();
			} else {
				$msg = wfMessage( 'wn-owner-reply-deleted' )->escaped();
			}
		} else {
			if ( !$data->is_reply ) {
				$msg = wfMessage( 'wn-admin-thread-deleted', [ $wall_displayname ] )->escaped();
			} else {
				$msg = wfMessage( 'wn-admin-reply-deleted', [ $wall_displayname ] )->escaped();
			}
		}

		$this->response->setVal( 'url', WikiFactory::getLocalEnvURL( $data->url ) );
		$this->response->setVal( 'msg', $msg );
		$this->response->setVal( 'authors', $authors );
		$this->response->setVal( 'iso_timestamp', wfTimestamp( TS_ISO_8601, $data->timestamp ) );
		$this->response->setVal( 'title', $this->shortenTitle( $data->title ?? '' ) );
	}

	protected function getNotificationMessage( $isMain, $data, $authors, $userCount, $myName ) {
		$params = [ ];
		if ( !$isMain ) {
			$params[] = $this->getDisplayname( $data->msg_author_displayname );

			if ( $userCount == 2 ) {
				$params[ '$1' ] = $this->getDisplayname( $authors[ 1 ][ 'displayname' ] );
			}

			$reply_by = 'other'; // who replied?
			// you = same as person receiving notification
			// self = same as person who wrote original message (parent)
			// other = someone else

			if ( $data->parent_username == $myName ) {
				$reply_by = 'you';
			} elseif ( in_array( $data->parent_username, $authors ) ) {
				$reply_by = 'self';
			} else $params[ '$' . ( count( $params ) + 1 ) ] = $this->getDisplayname( $data->parent_displayname );

			$whos_wall = 'a'; // on who's wall was the message written?
			// your  = on message author's wall
			// other = on someone else's wall
			// a     = the person was already mentioned (either author of msg or thread)

			if ( $data->wall_username == $myName ) {
				$whos_wall = 'your';
			} elseif ( $data->wall_username != $data->parent_username && !in_array( $data->wall_username, $authors ) ) {
				$whos_wall = 'other';
				$params[ '$' . ( count( $params ) + 1 ) ] = $this->getDisplayname( $data->wall_displayname );
			}

			$msgid = "wn-user$userCount-reply-$reply_by-$whos_wall-wall";
		} else {
			if ( $data->wall_username == $myName ) {
				$msgid = 'wn-newmsg-onmywall';
				$params[ '$' . ( count( $params ) + 1 ) ] = $this->getDisplayname( $data->msg_author_displayname );
			} else if ( $data->msg_author_username != $myName ) {
				$msgid = 'wn-newmsg-on-followed-wall';
				$params[ '$' . ( count( $params ) + 1 ) ] = $this->getDisplayname( $data->msg_author_displayname );
				$params[ '$' . ( count( $params ) + 1 ) ] = $this->getDisplayname( $data->wall_displayname );
			} else {
				$msgid = 'wn-newmsg';
				$params[ '$' . ( count( $params ) + 1 ) ] = $this->getDisplayname( $data->wall_displayname );
			}
		}
		$msg = wfMessage( $msgid, $params )->text();
		return $msg;
	}

	public function Update() {
		global $wgEnableWallExt, $wgEnableForumExt;

		wfProfileIn( __METHOD__ );

		if ( !$this->getContext()->getUser()->isLoggedIn() ) {
			$this->skipRendering();
			return;
		}

		$this->response->setVal( 'alwaysGrouped', empty( $wgEnableWallExt ) && empty( $wgEnableForumExt ) );
		$this->response->setVal( 'notificationKey', $this->request->getVal( 'notificationKey' ) );

		$notificationCounts = $this->request->getVal( 'notificationCounts' );
		$this->response->setVal( 'notificationCounts', $notificationCounts );
		$this->response->setVal( 'wikiCount', count( $notificationCounts ) );

		$unreadCount = $this->request->getVal( 'count' );
		$this->response->setVal( 'count', $unreadCount );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param string $title
	 * @return string
	 */
	protected function shortenTitle( string $title ): string {
		return WallHelper::shortenText( $this->getContext()->getLanguage(), $title, static::NOTIFICATION_TITLE_LIMIT );
	}

	public function getDisplayname( $username ): string {
		if ( User::isIP( $username ) ) {
			return wfMessage( 'oasis-anon-user' )->text();
		}
		return $username ?? '';
	}
}
