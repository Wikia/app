<?php

abstract class WallNotificationControllerBase extends WikiaController {
	public function __construct() {
		parent::__construct();
	}

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

	public function checkTopic() {
		// force json format
		$this->getResponse()->setFormat( 'json' );

		$result = false;

		$topic = $this->getRequest()->getVal( 'query' );
		if ( !empty( $topic ) ) {
			/** @var $title title */
			$title = Title::newFromText( $topic );

			if ( $title instanceof Title ) {
				$result = (bool)$title->exists();
			}
		}

		$this->response->setVal( 'exists', $result );
	}

	public function Update() {
		global $wgUser, $wgEnableWallExt, $wgEnableForumExt;

		wfProfileIn( __METHOD__ );

		$this->response->setVal( 'alwaysGrouped', empty( $wgEnableWallExt ) && empty( $wgEnableForumExt ) );
		$this->response->setVal( 'notificationKey', htmlentities( $this->request->getVal( 'notificationKey' ), ENT_QUOTES ) );

		$notificationCounts = $this->request->getVal( 'notificationCounts' );
		$this->response->setVal( 'notificationCounts', $notificationCounts );

		$this->updateExt( $notificationCounts );

		$unreadCount = $this->request->getVal( 'count' );
		$this->response->setVal( 'count', $unreadCount );

		$this->response->setVal( 'user', $wgUser );

		wfProfileOut( __METHOD__ );
	}

	public function updateWiki() {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		$all = $this->request->getVal( 'notifications' );

		$this->response->setVal( 'user', $wgUser );
		$this->response->setVal( 'unread', $all[ 'unread' ] );
		$this->response->setVal( 'read', $all[ 'read' ] );

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
		wfRunHooks( 'NotificationGetNotificationMessage', [
			&$this, &$msg, $firstEntity->isMain(), $data, $authors, $userCount, $wg->User->getName()
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
		$title = $this->getTitle( $data->thread_title );
		$this->response->setVal( 'url', $this->fixNotificationURL( $url ) );
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
			$displayname = wfMessage( 'oasis-anon-user' )->text();
		}

		$wall_displayname = $walluser->getName();

		$authors = [ ];
		$authors[] = [
			'displayname' => $displayname,
			'username' => $displayname
		];

		if ( $data->type == 'OWNER' ) {
			if ( !$data->is_reply ) {
				$msg = wfMessage( 'wn-owner-thread-deleted' )->text();
			} else {
				$msg = wfMessage( 'wn-owner-reply-deleted' )->text();
			}
		} else {
			if ( !$data->is_reply ) {
				$msg = wfMessage( 'wn-admin-thread-deleted', [ $wall_displayname ] )->text();
			} else {
				$msg = wfMessage( 'wn-admin-reply-deleted', [ $wall_displayname ] )->text();
			}
		}

		$this->response->setVal( 'url', $this->fixNotificationURL( $data->url ) );
		$this->response->setVal( 'msg', $msg );
		$this->response->setVal( 'authors', $authors );
		$this->response->setVal( 'iso_timestamp', wfTimestamp( TS_ISO_8601, $data->timestamp ) );
		$this->response->setVal( 'title', $this->getTitle( $data->title ) );
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

	protected function fixNotificationURL( $url ) {
		global $wgStagingList;
		$hostOn = getHostPrefix();

		$hosts = $wgStagingList;
		foreach ( $hosts as $host ) {
			$prefix = 'http://' . $host . '.';
			if ( strpos( $url, $prefix ) !== false ) {
				if ( empty( $hostOn ) ) {
					return str_replace( $prefix, 'http://', $url );
				} else {
					return str_replace( $prefix, 'http://' . $hostOn . '.', $url );
				}
			}
		}

		if ( !empty( $hostOn ) ) {
			return str_replace( 'http://', 'http://' . $hostOn . '.', $url );
		}

		return $url;
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
	 * @param string $title
	 * @return string
	 */
	protected abstract function getTitle( $title );

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
