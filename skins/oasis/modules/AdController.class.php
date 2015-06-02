<?php

class AdController extends WikiaController {

	public function index() {
		$this->slotName = $this->request->getVal('slotName');
		$this->pageTypes = $this->request->getVal('pageTypes');
		$this->includeLabel = $this->request->getVal('includeLabel');
	}

	public function executeConfig() {
		// TODO: stub
	}

	public function executeTop() {
		if ( WikiaPageType::isWikiaHub() ) {
			$leaderboardName = 'HUB_TOP_LEADERBOARD';
		} elseif ( $this->wg->EnableWikiaHomePageExt ) {
			$leaderboardName = 'CORP_TOP_LEADERBOARD';
		} elseif ( WikiaPageType::isMainPage() ) {
			$leaderboardName = 'HOME_TOP_LEADERBOARD';
		} else {
			$leaderboardName = 'TOP_LEADERBOARD';
		}
		$this->leaderboardName = $leaderboardName;
	}
}
