<?php
class LatestEarnedBadgesController extends WikiaController {

	public function executeIndex() {
		$maxBadgesToDisplay = 6;  // Could make this a global if we want

		wfProfileIn(__METHOD__);

		$this->response->addAsset('achievements_js');

		// This code was taken from SpecialLeaderboard so it can be used by both the module and the old Monaco .tmpl
		$rankingService = new AchRankingService();

		// ignore welcome badges
		$blackList = array(BADGE_WELCOME);
		$awardedBadges = $rankingService->getRecentAwardedBadges(null, $maxBadgesToDisplay, 3, $blackList);

		$recents = array();
		$count = 1;

		// getRecentAwardedBadges can sometimes return more than $max items
		foreach ($awardedBadges as $badgeData) {
			//$level = $badgeData['badge']->getLevel();
			$recents[] = $badgeData;
			if ($count++ >= $maxBadgesToDisplay) break;
		}
		$this->recents = $recents;

		wfProfileOut(__METHOD__);
	}

}
