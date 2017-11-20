<?php

abstract class WallNotificationControllerBase extends WikiaService {
	const NOTIFICATION_TITLE_LIMIT = 48;

	public function Index() {
		global $wgUser, $wgEnableWallExt, $wgEnableForumExt;
		$loggedIn = $wgUser->isLoggedIn();
		$suppressWallNotifications = $this->areNotificationsSuppressedByExtensions();
		if ( $loggedIn && !$suppressWallNotifications ) {
			$this->addAssets();
			$this->response->setVal( 'prehide', ( empty( $wgEnableWallExt ) && empty( $wgEnableForumExt ) ) );
		}
		$this->response->setVal( 'loggedIn', $loggedIn );
	}

	public function getDisplayname( $username ) {
		if ( User::isIP( $username ) ) {
			return wfMessage( 'oasis-anon-user' )->text();
		}
		return $username;
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
		$this->updateExt( $notificationCounts );

		$unreadCount = $this->request->getVal( 'count' );
		$this->response->setVal( 'count', $unreadCount );

		wfProfileOut( __METHOD__ );
	}

	public function Notification() {
		$wg = F::app()->wg;

		$notify = $this->request->getVal( 'notify' );

		if ( empty( $notify[ 'grouped' ][ 0 ] ) ) {
			// do not render this notification, it's bugged
			return;
		}
		/** @var WallNotificationEntity $firstEntity */
		$firstEntity = $notify[ 'grouped' ][ 0 ];

		$data = $firstEntity->data;
		if ( isset( $data->type ) && ( $data->type === 'ADMIN' || $data->type === 'OWNER' ) ) {
			// SUS-254 this logic is duplicated in WallNotificationsExternalController::init but we need it here also
			if ( ( $this->app->checkSkin( [ 'oasis' ] ) ) ) {
				$controllerName = 'GlobalNavigationWallNotifications';
			} else {
				$controllerName = 'WallNotifications';
			}
			$this->forward( $controllerName, 'NotificationAdmin' );
			return;
		}

		$authors = [ ];
		foreach ( $notify[ 'grouped' ] as $notify_entity ) {
			$authors[] = [
				'displayname' => $notify_entity->data->msg_author_displayname,
				'username' => $notify_entity->data->msg_author_username,
				'avatar' => AvatarService::renderAvatar(
					$firstEntity->data->msg_author_username,
					AvatarService::AVATAR_SIZE_SMALL_PLUS
				)
			];
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

		$this->setUnread( $unread );
		if ( $unread && $data->notifyeveryone ) {
			$this->setTemplate();
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

	/**
	 * @param string $title
	 * @return string
	 */
	protected function shortenTitle( string $title ): string {
		return WallHelper::shortenText( $this->getContext()->getLanguage(), $title, static::NOTIFICATION_TITLE_LIMIT );
	}

	/**
	 * @param $notificationCounts
	 * @return void
	 */
	protected abstract function updateExt( $notificationCounts );

	/**
	 * @return void
	 */
	protected abstract function addAssets();

	/**
	 * @return bool
	 */
	protected abstract function areNotificationsSuppressedByExtensions();

	/**
	 * @param bool $unread
	 * @return void
	 */
	protected abstract function setUnread( $unread );

	/**
	 * @return void
	 */
	protected abstract function setTemplate();
}
