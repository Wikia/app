<?php
class AchievementsModule extends Module {

	var $wgBlankImgUrl;

	var $viewer_is_owner = false;
	var $ownerRank = 0;
	var $ownerScore = 0;
	var $ownerName;

	var $leaderboard_url;
	var $customize_url;
	var $ownerBadges = array();
	var $ownerCounters = array();
	var $challengesBadges = array();
	var $max_badges = 6; // sets how many badges are visible from the begining, more badges create 'more'-link
	var $max_challenges = 'all';  // limit how many badges are in the "more badges you can earn" list. either a number or 'all'

	public function executeIndex() {
		global $wgTitle, $wgUser, $wgOut, $wgExtensionsPath, $wgStylePath, $wgStyleVersion;

		// add CSS for this module
		//$wgOut->addStyle(wfGetSassUrl("skins/oasis/css/modules/Achievements.scss"));
		$wgOut->addStyle(wfGetSassUrl("extensions/wikia/AchievementsII/css/oasis.scss"));
		// add JS for this module
		//$wgOut->addScript("<script src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/achievements.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script src=\"{$wgStylePath}/oasis/js/Achievements.js?{$wgStyleVersion}\"></script>\n");

		// get achievement lists
		$rankingService = new AchRankingService();
		$userProfileService = new AchUserProfileService();
		$userProfileService->getHTML();   // have to call this because it creates our data as a side effect

		$this->ownerName = $userProfileService->mUserOwner->getName();
			
		if ($userProfileService->mUserOwner && !($userProfileService->mUserOwner->getOption('hidepersonalachievements'))) {
			$this->ownerBadges = $userProfileService->mOwnerBadgesSimple;
			$this->ownerCounters = $userProfileService->mOwnerCounters;

			$this->ownerRank = $rankingService->getUserRank($userProfileService->mUserOwner->getId());
			$this->ownerScore = $rankingService->getUserScore($userProfileService->mUserOwner->getId());

			if (count($this->ownerBadges) >= 4) {
				$this->max_challenges = 4;
			}
		}
		if($userProfileService->mUserViewer && $userProfileService->mUserViewer->isLoggedIn() && $userProfileService->mUserViewer->getId() == $userProfileService->mUserOwner->getId()) {
			$this->viewer_is_owner = true;
			$this->challengesBadges = $userProfileService->mChallengesBadges;

			// Let's prune the challengesBadges list to the correct length before passing it to the template
			if ($this->max_challenges == "all") {
				$this->challengesBadges = $this->challengesBadges;
			}
			else {
				while (count($this->challengesBadges) > $this->max_challenges) array_pop($this->challengesBadges);
			}
		}

		// UI elements
		$this->leaderboard_url = Skin::makeSpecialUrl("Leaderboard");
		

		if($userProfileService->mUserViewer && $userProfileService->mUserViewer->isAllowed('editinterface')) {
			$this->customize_url = Skin::makeSpecialUrl("AchievementsCustomize");
		}

	}


	/**
	 * adds the hock for own JavaScript variables in the document
	 */
	public function __construct() {
		global $wgHooks;
		$wgHooks['MakeGlobalVariablesScript'][] = 'AchievementsModule::addAchievementsJSVariables';
	}

	
	/**
	 * adds JavaScript variables inside the page source, cl
	 *
	 * @param mixed $vars the main vars for the JavaScript printout
	 *
	 */
	static function addAchievementsJSVariables (&$vars) {
		$lang_view_all = wfMsg('achievements-viewall-oasis');
		$lang_view_less = wfMsg('achievements-viewless');		
		$vars['wgAchievementsMoreButton'] = array($lang_view_all, $lang_view_less);
		return true;
	}
}