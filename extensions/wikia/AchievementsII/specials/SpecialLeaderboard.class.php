<?php

class SpecialLeaderboard extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('AchievementsII');
		parent::__construct('Leaderboard', '' /* no restriction */, true /* listed */);
	}

	function execute($user_id) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgSupressPageTitle, $wgUser, $wgWikiaBotLikeUsers, $wgJsMimeType;

		$wgSupressPageTitle = true;
		$rankingService = new AchRankingService();

		$this->setHeaders();

		$wgOut->addStyle( "common/userpage_sidebar.css" );
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/leaderboard.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/achievements.js?{$wgStyleVersion}\"></script>\n");
		// ranking
		$ranking = $rankingService->getUsersRanking();

		// recent
		$levels = array(BADGE_LEVEL_PLATINUM, BADGE_LEVEL_GOLD, BADGE_LEVEL_SILVER, BADGE_LEVEL_BRONZE);
		$recents = array();

		foreach($levels as $level) {
			$awardedBadges = $rankingService->getRecentAwardedBadges($level);

			if(count($awardedBadges))
				$recents[$level] = $awardedBadges;
		}

		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'ranking' => $ranking,
			'recents' => $recents,
			'username' => $wgUser->getName()
		));

		$wgOut->addHTML($template->render('SpecialLeaderboard'));

		wfProfileOut(__METHOD__);
	}

}
