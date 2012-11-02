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
		global $wgOut, $wgResourceBasePath, $wgStylePath, $wgJsMimeType;

		// add CSS and JS for this module
		$this->response->addAsset( 'achievements_css' );
		$this->response->addAsset( 'achievements_js' );

		$this->getBadgesData();
	}

	private function getBadgesData() {
		global $wgContLang;

		// get achievement lists
		$rankingService = new AchRankingService();
		$userProfileService = new AchUserProfileService();
		$userProfileService->getHTML();   // have to call this because it creates our data as a side effect

		$this->ownerName = $userProfileService->mUserOwner->getName();
		$this->ownerBadgesCount = $userProfileService->mOwnerBadgesCount;
		$this->ownerBadges = $userProfileService->mOwnerBadgesSimple;
		$this->ownerCounters = $userProfileService->mOwnerCounters;

		$this->ownerRank = $rankingService->getUserRankingPosition($userProfileService->mUserOwner);
		$this->ownerScore = $wgContLang->formatNum($rankingService->getUserScore($userProfileService->mUserOwner->getId()));

		if($userProfileService->mUserViewer && $userProfileService->mUserViewer->isLoggedIn() && $userProfileService->mUserViewer->getId() == $userProfileService->mUserOwner->getId()) {
			$this->viewer_is_owner = true;
			$challengesBadges = $userProfileService->mChallengesBadges;

			// Let's prune the challengesBadges list to the correct length before passing it to the template
			if ($this->max_challenges != "all") {
				while (count($challengesBadges) > $this->max_challenges) array_pop($challengesBadges);
			}
			$this->challengesBadges = $challengesBadges;
		}

		// UI elements
		$this->leaderboard_url = Skin::makeSpecialUrl("Leaderboard");


		if($userProfileService->mUserViewer && $userProfileService->mUserViewer->isAllowed('editinterface')) {
			$this->customize_url = Skin::makeSpecialUrl("AchievementsCustomize");
		}
	}

	public function executeBadges() {
		$user = trim( $this->getVal( 'user', '' ) );
		$page = $this->request->getInt( 'page', 0 );

		$userProfileService = new AchUserProfileService();
		$userProfileService->initOwnerBadges($user, $page);
		$this->ownerBadges = $userProfileService->mOwnerBadgesSimple;
	}
}
