<?php

class WallNotificationsExternalController extends WikiaController {
	const WALL_WIKI_NAME_MAX_LEN = 32;

	private $controllerName;

	public function init() {
		if ( ( $this->app->checkSkin( [ 'oasis' ] ) ) ) {
			$this->controllerName = 'GlobalNavigationWallNotifications';
		} else {
			$this->controllerName = 'WallNotifications';
		}
	}

	public function getUpdateCounts() {
		global $wgUser;

		// check notifications for messages marked with "notify everyone"
		$wne = new WallNotificationsEveryone();
		$wne->processQueue( $wgUser->getId() );

		$wn = new WallNotifications();
		$this->getUpdateCountsInternal( $wn );
		return true;
	}

	public function getUpdateWiki() {
		$id = $this->request->getVal( 'wikiId' );
		$isCrossWiki = $this->request->getVal( 'isCrossWiki' ) == 1;
		$wn = new WallNotifications();
		$this->getUpdateWikiInternal( $wn, $id, $isCrossWiki );
		return true;
	}

	public function markAllAsRead() {
		global $wgUser, $wgCityId;

		$forceAll = $this->request->getVal( 'forceAll' );
		$wn = new WallNotifications();
		$ret = $wn->markRead( $wgUser->getId(), $wgCityId );
		if ( $ret === false || $forceAll == 'FORCE' ) {
			$wn->markReadAllWikis( $wgUser->getId() );
		}

		$this->getUpdateCountsInternal( $wn );

		return true;
	}

	public function markAsRead() {
		global $wgUser, $wgCityId;

		$id = $this->request->getVal( 'id' );
		$wn = new WallNotifications();
		$ret = $wn->markRead( $wgUser->getId(), $wgCityId, $id );
		$this->response->setVal( 'wasUnread', $ret );
		$this->response->setVal( 'status', true );

		return true;
	}

	private function getUpdateCountsInternal( WallNotifications $wn ) {
		global $wgUser, $wgLang, $wgMemc;
		wfProfileIn( __METHOD__ );

		$all = $wn->getCounts( $wgUser->getId() );

		$sum = 0;
		foreach ( $all as $k => $wiki ) {
			$sum += $wiki['unread'];
			$wikiSitename = $wiki['sitename'];

			if ( mb_strlen( $wikiSitename ) > self::WALL_WIKI_NAME_MAX_LEN ) {
				$all[$k]['sitename'] = $wgLang->truncate( $wikiSitename, ( self::WALL_WIKI_NAME_MAX_LEN - 3 ) );
			}
		}

		// solution for problem with cross wiki notification and no wikia domain.
		$notificationKey = uniqid();

		$wgMemc->set( $notificationKey,  $wgUser->getId() );

		$this->response->setVal( 'html', $this->app->renderView( $this->controllerName, 'Update', [
			'notificationCounts' => $all, 'count' => $sum, 'notificationKey' => $notificationKey
		] ) );
		$this->response->setVal( 'count', $sum );
		$this->response->setVal( 'reminder', wfMessage( 'wall-notifications-reminder', $sum )->text() );
		$this->response->setVal( 'status', true );

		$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );

		wfProfileOut( __METHOD__ );
	}

	private function getUpdateWikiInternal( WallNotifications $wn, $wikiId, $isCrossWiki = false ) {
		$user = $this->getContext()->getUser();

		if ( $isCrossWiki ) {
			$all = $wn->getWikiNotifications( $user->getId(), $wikiId, 0 );
		} else {
			$all = $wn->getWikiNotifications( $user->getId(), $wikiId, 5, false, true );
		}

		$html = '';
		if ( $user->isLoggedIn() ) {
			if ( !empty( $all['unread_count'] ) || !empty( $all['read_count'] ) ) {
				foreach ( $all['unread'] as $unreadNotification ) {
					$html .= $this->app->renderView( $this->controllerName, 'Notification', [
						'notify' => $unreadNotification,
						'unread' => true
					] );
				}

				foreach ( $all['read'] as $readNotification ) {
					$html .= $this->app->renderView( $this->controllerName, 'Notification', [
						'notify' => $readNotification,
						'unread' => false
					] );
				}
			} else {
				$html = $this->app->renderPartial( $this->controllerName, 'empty' );
			}
		}

		$this->response->setVal( 'html', $html );

		$this->response->setVal( 'unread', $all[ 'unread_count' ] );
		$this->response->setVal( 'status', true );

		$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
	}

	/**
	 * Requested by Wall Notifications for cross-wiki notifications
	 * @see WallNotificationEntity::loadDataFromRevIdOnWiki()
	 */
	public function getEntityData() {
		// SUS-1879: Disable cache - this endpoint is only requested internally
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$revId = $this->request->getInt( 'revId' );
		$useMasterDB = $this->request->getBool( 'useMasterDB', false );

		$wn = new WallNotificationEntity();
		if ( !$wn->loadDataFromRevId( $revId, $useMasterDB ) ) {
			$this->response->setData( [
				'status' => 'error'
			] );

			return;
		}

		$this->response->setData( [
			'data' => $wn->data,
			'parentTitleDbKey' => $wn->parentTitleDbKey,
			'msgText' => $wn->msgText,
			'threadTitleFull' => $wn->threadTitleFull,
			'status' => 'ok',
		] );
	}
}
