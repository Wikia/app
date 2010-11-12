<?php

class SpecialLeaderboard extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('AchievementsII');
		parent::__construct('Leaderboard', '' /* no restriction */, true /* listed */);
	}

	function execute($user_id) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgExtensionsPath, $wgStylePath, $wgStyleVersion, $wgSupressPageSubtitle, $wgUser, $wgWikiaBotLikeUsers, $wgJsMimeType;

		$wgSupressPageSubtitle = true;
		$rankingService = new AchRankingService();

		$this->setHeaders();
		
		$wgOut->setPageTitle(wfMsg('achievements-title'));

		$skinName = get_class($wgUser->getSkin());

		if ($skinName == 'SkinOasis') {
			$wgOut->addStyle(wfGetSassUrl('/extensions/wikia/AchievementsII/css/leaderboard_oasis.scss'));
		} else if ($skinName == 'SkinMonoBook') {
			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/leaderboard_monobook.css?{$wgStyleVersion}");
		} else if ($skinName == 'SkinWikiaphone') {
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
			$wgOut->addScript("<script src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/SpecialLeaderboard.js?{$wgStyleVersion}\"></script>\n");
			$wgOut->addScript("<script src=\"{$wgStylePath}/oasis/js/Achievements.js?{$wgStyleVersion}\"></script>\n");
		}
		
		// ranking
		$ranking = $rankingService->getUsersRanking(20, true);
		
		//make array of latest badges, per user
		$topUserIDs = array();
		foreach($ranking as $rank => $rankedUser) {
			$topUserIDs[] = $rankedUser->getID();
		}		
		$userService = new AchUserProfileService;
		$topUserBadges = $userService->getMostRecentUserBadge($topUserIDs);
		

		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'ranking' => $ranking,
			'topUserBadges' => $topUserBadges,
			'userpage' => $wgUser->getUserPage()->getPrefixedURL()			
		));

		$wgOut->addHTML($template->render('SpecialLeaderboard'));

		wfProfileOut(__METHOD__);
	}

}
