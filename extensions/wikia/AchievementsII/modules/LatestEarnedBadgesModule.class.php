<?php
class LatestEarnedBadgesModule extends Module {

	var $wgBlankImgUrl;
	var $recents;

	public function executeIndex() {
		global $wgUser, $wgOut, $wgExtensionsPath;
		$maxBadgesToDisplay = 6;  // Could make this a global if we want

		wfProfileIn(__METHOD__);

		// include oasis.css override
		if (get_class($wgUser->getSkin()) == 'SkinOasis') {
			$wgOut->addStyle(wfGetSassUrl("$wgExtensionsPath/wikia/AchievementsII/css/oasis.scss"));
		}

		// This code was taken from SpecialLeaderboard so it can be used by both the module and the old Monaco .tmpl
		$rankingService = new AchRankingService();

		// ignore welcome badges
		// FIXME: picking badges up to 30 days old for testing.  change to 3 days for production.
		$blackList = array(BADGE_WELCOME);
		$awardedBadges = $rankingService->getRecentAwardedBadges(null, $maxBadgesToDisplay, 30, $blackList);

		$this->recents = array();
		$count = 1;

		// getRecentAwardedBadges can sometimes return more than $max items
		foreach ($awardedBadges as $badgeData) {
			//$level = $badgeData['badge']->getLevel();
			$this->recents[] = $badgeData;
			if ($count++ >= $maxBadgesToDisplay) break;
		}

		wfProfileOut(__METHOD__);
	}

}