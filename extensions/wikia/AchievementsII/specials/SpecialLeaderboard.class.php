<?php

class SpecialLeaderboard extends SpecialPage {

	function __construct() {
		parent::__construct('Leaderboard', '' /* no restriction */, true /* listed */);
	}

	function execute($user_id) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgExtensionsPath, $wgStylePath, $wgSupressPageSubtitle, $wgUser, $wgResourceBasePath, $wgJsMimeType;

		$wgSupressPageSubtitle = true;
		$rankingService = new AchRankingService();

		$this->setHeaders();

		$wgOut->setPageTitle(wfMsg('achievements-title'));

		$skinName = get_class($this->getSkin());

		// FIXME: use AM group here
		if ($skinName == 'SkinOasis') {
			//tooltips
			$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/tooltip/jquery.wikia.tooltip.js\"></script>");
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/WikiaTooltip.scss'));

			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/AchievementsII/css/leaderboard_oasis.scss'));
			$wgOut->addScript("<script src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/SpecialLeaderboard.js\"></script>\n");
			$wgOut->addScript("<script src=\"{$wgStylePath}/oasis/js/Achievements.js\"></script>\n");
		} else {
			$wgOut->addStyle( "common/article_sidebar.css" );
			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/achievements_sidebar.css");
			$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/achievements.js\"></script>\n");

			if ($skinName == 'SkinMonoBook') {
				$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/leaderboard_monobook.css");
			} else if ($skinName == 'SkinWikiaphone') {
				$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/leaderboard_wikiaphone.css");
			}
		}

		// ranking
		$ranking = $rankingService->getUsersRanking(20, true);

		//make array of latest badges, per user
		$topUserIDs = array();
		foreach($ranking as $rankedUser) {
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
