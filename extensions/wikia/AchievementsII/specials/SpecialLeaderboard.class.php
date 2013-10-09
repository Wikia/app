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

		if ($skinName == 'SkinOasis') {
			$assetsManager = AssetsManager::getInstance();
			$scssPackage = 'special_leaderboard_oasis_css';
			$jsPackage = 'special_leaderboard_oasis_js';

			foreach ( $assetsManager->getURL( $scssPackage ) as $url ) {
				$wgOut->addStyle( $url );
			}

			foreach ( $assetsManager->getURL( $jsPackage ) as $url ) {
				$wgOut->addScript( "<script src=\"{$url}\"></script>" );
			}
		}
		// include oasis.css override
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AchievementsII/css/oasis.scss'));

		// ranking
		$ranking = $rankingService->getUsersRanking(20, true);

		//make array of latest badges, per user
		$topUserIDs = array();
		foreach($ranking as $rankedUser) {
			$topUserIDs[] = $rankedUser->getID();
		}
		$usersService = new AchUsersService;
		$topUserBadges = $usersService->getMostRecentUserBadge($topUserIDs);

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
