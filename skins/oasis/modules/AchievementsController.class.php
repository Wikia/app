<?php
class AchievementsController extends WikiaController {

	public function init() {
		$this->viewer_is_owner = false;
		$this->ownerRank = 0;
		$this->ownerScore = 0;
		$this->ownerName = null;

		$this->leaderboard_url = null;
		$this->customize_url = null;
		$this->ownerBadgesCount = 0;
		$this->ownerBadges = array();
		$this->ownerCounters = array();
		$this->challengesBadges = array();
		//$this->max_badges = 6; // sets how many badges are visible from the begining, more badges create 'more'-link
		$this->max_challenges = 'all';  // limit how many badges are in the "more badges you can earn" list. either a number or 'all'
	}

	public function executeIndex() {
		$userProfileService = new AchUserProfileService();
		if ( !$userProfileService->isVisible() ) {
			$this->skipRendering();
			return;
		}

		// add CSS and JS for this module
		$this->response->addAsset( 'achievements_css' );
		$this->response->addAsset( 'achievements_js' );

		$this->getBadgesData();
	}

	private function getBadgesData() {
		global $wgContLang;

		wfProfileIn(__METHOD__);

		// get achievement lists
		$rankingService = new AchRankingService();
		$userProfileService = new AchUserProfileService();

		$this->ownerName = $userProfileService->getOwnerUser()->getName();
		$this->ownerBadgesCount = $userProfileService->getBadgesCount();
		$this->ownerBadges = $userProfileService->getBadgesAnnotated(0);
		$this->ownerCounters = $userProfileService->getCounters();;

		$this->ownerRank = $rankingService->getUserRankingPosition($userProfileService->getOwnerUser());
		$this->ownerScore = $wgContLang->formatNum($rankingService->getUserScore($userProfileService->getOwnerUser()->getId()));

		// if user is viewing their own page
		if ( $userProfileService->getViewerUser() && !$userProfileService->getViewerUser()->isAnon()
				&& $userProfileService->getViewerUser()->getId() == $userProfileService->getOwnerUser()->getId()
		) {
			$this->viewer_is_owner = true;
			$challengesBadges = $userProfileService->getChallengesAnnotated();

			// Let's prune the challengesBadges list to the correct length before passing it to the template
			if ($this->max_challenges != "all") {
				$challengesBadges = array_slice($challengesBadges,0,$this->max_challenges);
			}
			$this->challengesBadges = $challengesBadges;
		}

		// UI elements
		$this->leaderboard_url = Skin::makeSpecialUrl("Leaderboard");


		if ( $userProfileService->getViewerUser() && $userProfileService->getViewerUser()->isAllowed('editinterface') ) {
			$this->customize_url = Skin::makeSpecialUrl("AchievementsCustomize");
		}

		wfProfileOut(__METHOD__);
	}

	public function executeBadges() {
		$userName = trim( $this->getVal( 'user', '' ) );
		$page = $this->request->getInt( 'page', 0 );

		$userProfileService = new AchUserProfileService( User::newFromName($userName) );
		$this->ownerBadges = $userProfileService->getBadgesAnnotated($page);
	}
}
