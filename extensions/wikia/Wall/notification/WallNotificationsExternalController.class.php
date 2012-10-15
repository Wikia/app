<?php

class WallNotificationsExternalController extends WikiaController {
	const WALL_WIKI_NAME_MAX_LEN = 32;

	var $helper;
	public function __construct() {
		$this->app = F::app();
	}

	public function init() {
		$this->helper = F::build('WallHelper', array());
	}

	public function getUpdateCounts() {
		$wne = F::build('WallNotificationsEveryone', array());
		$wne->processQueue($this->wg->user->getId());

		$wn = F::build('WallNotifications', array());
		$this->getUpdateCountsInternal($wn);
		return true;
	}

	public function getUpdateWiki() {
		$id = $this->request->getVal('wikiId');
		$isCrossWiki = $this->request->getVal('isCrossWiki') == 1;
		$wn = F::build('WallNotifications', array());
		$this->getUpdateWikiInternal($wn, $id, $isCrossWiki);
		return true;
	}

	public function markAllAsRead() {
		$forceAll = $this->request->getVal('forceAll');
		$wn = F::build('WallNotifications', array());
		$ret = $wn->markRead( $this->wg->User->getId(), $this->wg->CityId );
		if($ret === false || $forceAll == 'FORCE') {
			$ret = $wn->markReadAllWikis( $this->wg->User->getId() );
		}
		$this->getUpdateCountsInternal($wn);
		return true;
	}

	public function markAsRead() {
		$id = $this->request->getVal('id');
		$wn = F::build('WallNotifications', array());
		$ret = $wn->markRead( $this->wg->User->getId(), $this->wg->CityId, $id );
		$this->response->setVal('wasUnread', $ret);
		$this->response->setVal('status', true);

		return true;
	}

	private function getUpdateCountsInternal(WallNotifications $wn) {
		wfProfileIn(__METHOD__);

		$app = F::app();
		$all = $wn->getCounts( $this->wg->User->getId() );

		$sum = 0;
		foreach($all as $k => $wiki) {
			$sum += $wiki['unread'];
			$wikiSitename = $wiki['sitename'];

			if( mb_strlen($wikiSitename) > self::WALL_WIKI_NAME_MAX_LEN ) {
				$all[$k]['sitename'] = $app->wg->Lang->truncate($wikiSitename, (self::WALL_WIKI_NAME_MAX_LEN - 3) );
			}
		}

		//solution for problem with cross wiki notification and no wikia domain.
		$notificationKey = uniqid();

		$this->app->runFunction( 'wfSharedMemcKey', 'notificationkey', $notificationKey);
		$app->wg->Memc->set($notificationKey,  $this->wg->User->getId() );

		$this->response->setVal('html', $this->app->renderView( 'WallNotifications', 'Update', array('notificationCounts' => $all, 'count' => $sum, 'notificationKey' => $notificationKey) ));
		$this->response->setVal('count', $sum);
		$this->response->setVal('reminder', $this->app->wf->MsgExt( 'wall-notifications-reminder', array('parsemag'), $sum ) );
		$this->response->setVal('status', true);

		wfProfileOut(__METHOD__);
	}

	private function getUpdateWikiInternal(WallNotifications $wn, $wikiId, $isCrossWiki = false) {
		if ( $isCrossWiki ) {
			$all = $wn->getWikiNotifications( $this->wg->User->getId(), $wikiId, 0 );
		} else {
			$all = $wn->getWikiNotifications( $this->wg->User->getId(), $wikiId, 5, false, true );
		}

		$this->response->setVal('html', $this->app->renderView( 'WallNotifications', 'UpdateWiki', array('notifications'=>$all) ));
		$this->response->setVal('unread', $all[ 'unread_count' ] );
		$this->response->setVal('status', true);
	}

}
