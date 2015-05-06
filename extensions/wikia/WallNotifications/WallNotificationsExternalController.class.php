<?php

class WallNotificationsExternalController extends WikiaController {
	const WALL_WIKI_NAME_MAX_LEN = 32;

	const TTL = 300; // 5 minutes

	private $controllerName;

	public function __construct() {
		$this->app = F::app();
	}

	public function init() {
		if( ($this->app->checkSkin('oasis')) || $this->app->checkSkin('venus') ) {
			$this->controllerName = 'GlobalNavigationWallNotifications';
		} else {
			$this->controllerName = 'WallNotifications';
		}
	}

	public function getUpdateCounts() {
		global $wgUser;

		$wne = new WallNotificationsEveryone();
		$wne->processQueue( $wgUser->getId() );

		$wn = new WallNotifications();
		$this->getUpdateCountsInternal( $wn );
		return true;
	}

	public function getUpdateWiki() {
		$id = $this->request->getVal('wikiId');
		$isCrossWiki = $this->request->getVal('isCrossWiki') == 1;
		$wn = new WallNotifications();
		$this->getUpdateWikiInternal( $wn, $id, $isCrossWiki );
		return true;
	}

	public function markAllAsRead() {
		global $wgUser, $wgCityId;

		$forceAll = $this->request->getVal( 'forceAll' );
		$wn = new WallNotifications();
		$ret = $wn->markRead( $wgUser->getId(), $wgCityId );
		if( $ret === false || $forceAll == 'FORCE' ) {
			$ret = $wn->markReadAllWikis( $wgUser->getId() );
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
		wfProfileIn(__METHOD__);

		$all = WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, 'getCounts', $wgUser->getId() ),
			self::TTL,
			function() use ( $wn, $wgUser ) {
				return $wn->getCounts( $wgUser->getId() );
			}
		);

		$sum = 0;
		foreach( $all as $k => $wiki ) {
			$sum += $wiki['unread'];
			$wikiSitename = $wiki['sitename'];

			if( mb_strlen($wikiSitename) > self::WALL_WIKI_NAME_MAX_LEN ) {
				$all[$k]['sitename'] = $wgLang->truncate( $wikiSitename, ( self::WALL_WIKI_NAME_MAX_LEN - 3 ) );
			}
		}

		//solution for problem with cross wiki notification and no wikia domain.
		$notificationKey = uniqid();

		$wgMemc->set( $notificationKey,  $wgUser->getId() );

		$this->response->setVal( 'html', $this->app->renderView( $this->controllerName, 'Update', [
			'notificationCounts' => $all, 'count' => $sum, 'notificationKey' => $notificationKey
		] ) );
		$this->response->setVal( 'count', $sum );
		$this->response->setVal( 'reminder', wfMessage('wall-notifications-reminder', $sum)->text() );
		$this->response->setVal( 'status', true );

		// PLATFORM-1194: cache the response for 5 minutes in the browser cache
		$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
		$this->response->setCacheValidity( self::TTL );

		wfProfileOut(__METHOD__);
	}

	private function getUpdateWikiInternal( WallNotifications $wn, $wikiId, $isCrossWiki = false ) {
		global $wgUser;

		if ( $isCrossWiki ) {
			$all = $wn->getWikiNotifications( $wgUser->getId(), $wikiId, 0 );
		} else {
			$all = $wn->getWikiNotifications( $wgUser->getId(), $wikiId, 5, false, true );
		}

		$this->response->setVal(
			'html',
			$this->app->renderView(  $this->controllerName, 'UpdateWiki', [ 'notifications'=>$all ] )
		);
		$this->response->setVal( 'unread', $all[ 'unread_count' ] );
		$this->response->setVal( 'status', true );

		// PLATFORM-1194: cache the response for 5 minutes in the browser cache
		$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
		$this->response->setCacheValidity( self::TTL );
	}

}
