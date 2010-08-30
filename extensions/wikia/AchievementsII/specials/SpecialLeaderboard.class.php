<?php

class SpecialLeaderboard extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('AchievementsII');
		parent::__construct('Leaderboard', '' /* no restriction */, true /* listed */);
	}

	function execute($user_id) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgExtensionsPath, $wgStylePath, $wgStyleVersion, $wgSupressPageTitle, $wgUser, $wgWikiaBotLikeUsers, $wgJsMimeType;

		$wgSupressPageTitle = true;
		$rankingService = new AchRankingService();

		$this->setHeaders();
		
		$skinName = get_class($wgUser->getSkin());

		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/leaderboard.css?{$wgStyleVersion}");
		if( $skinName == 'SkinMonoBook' ) {
			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/leaderboard_monobook.css?{$wgStyleVersion}");
		} elseif( $skinName == 'SkinWikiaphone' ) {
			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/leaderboard_wikiaphone.css?{$wgStyleVersion}");
		}
		
		/** don't show and use JavaScript and CSS from Monoaco on Oasis **/
		if ($skinName != 'SkinOasis') {
			$wgOut->addStyle( "common/article_sidebar.css" );

			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/achievements_sidebar.css?{$wgStyleVersion}");
			$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/achievements.js?{$wgStyleVersion}\"></script>\n");
		}

		/** use Oasis JavaScript **/
		if ($skinName == 'SkinOasis') {
			$wgOut->addScript("<script src=\"{$wgStylePath}/oasis/js/Achievements.js?{$wgStyleVersion}\"></script>\n");
		}
		
		// ranking
		$ranking = $rankingService->getUsersRanking(20, true);

		// recent  -- REMOVED BY OWEN FOR OASIS
		/*
		$levels = array(BADGE_LEVEL_PLATINUM, BADGE_LEVEL_GOLD, BADGE_LEVEL_SILVER, BADGE_LEVEL_BRONZE);
		$recents = array();
		$maxEntries = 9;

		foreach($levels as $level) {
			$limit = 3;
			$blackList = null;
			
			if($level == BADGE_LEVEL_BRONZE) {
				if($maxEntries <= 0) break;
				
				$limit = $maxEntries;
				$blackList = array(BADGE_WELCOME);
			}

			$awardedBadges = $rankingService->getRecentAwardedBadges($level, $limit, 3, $blackList);

			if($total = count($awardedBadges)) {
				$recents[$level] = $awardedBadges;
				$maxEntries -= $total;
			}
		}
		 */

		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'ranking' => $ranking,
//			'recents' => $recents,
			'username' => $wgUser->getName()
		));

		$wgOut->addHTML($template->render('SpecialLeaderboard'));

		wfProfileOut(__METHOD__);
	}

}
