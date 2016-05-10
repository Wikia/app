<?php

class CommunityPageSpecialController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE,
		TOP_ADMINS_LIMIT = null,
		TOP_ADMINS_MODULE_LIMIT = 3,
		TOP_CONTRIBUTORS_LIMIT = 5,
		ALL_MEMBERS_LIMIT = 20;
	private $usersModel;
	private $wikiModel;
	private $userTotalContributionCount;

	public function __construct() {
		parent::__construct( 'Community' );
		$this->usersModel = new CommunityPageSpecialUsersModel();
		$this->wikiModel = new CommunityPageSpecialWikiModel();
		$this->userTotalContributionCount = $this->usersModel->getUserContributions( $this->getUser(), false );
	}

	public function index() {
		$this->specialPage->setHeaders();
		$this->getOutput()->setPageTitle( $this->msg( 'communitypage-title' )->plain() );
		$this->addAssets();

		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;

		// queue i18n messages for export to JS
		JSMessages::enqueuePackage( 'CommunityPageSpecial', JSMessages::EXTERNAL );

		// remove user styles and js
		$this->getOutput()->disallowUserJs();

		$this->response->setValues( [
			'inviteFriendsText' => $this->msg( 'communitypage-invite-friends' )->plain(),
			'headerWelcomeMsg' => $this->msg( 'communitypage-tasks-header-welcome' )->plain(),
			'adminWelcomeMsg' => $this->msg( 'communitypage-admin-welcome-message' )->text(),
			'pageListEmptyText' => $this->msg( 'communitypage-page-list-empty' )->plain(),
			'showPopupMessage' => true,
			'popupMessageText' => 'This is just a test message for the popup message box',
			'userIsMember' => ( $this->userTotalContributionCount > 0 ),
			'pageTitle' => $this->msg( 'communitypage-title' )->plain(),
			'topContributors' => $this->sendRequest( 'CommunityPageSpecialController', 'getTopContributorsData' )
				->getData(),
			'topAdmins' => $this->sendRequest( 'CommunityPageSpecialController', 'getTopAdminsData' )
				->getData(),
			'recentlyJoined' => $this->sendRequest( 'CommunityPageSpecialController', 'getRecentlyJoinedData' )
				->getData(),
			'recentActivityModule' => $this->getRecentActivityData(),
		] );
	}

	/**
	 * Set context for contributorsModule template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	public function getTopContributorsData() {
		$userContributionCount = $this->usersModel->getUserContributions( $this->getUser() );
		$contributors = $this->usersModel->filterGlobalBots(
				// get extra contributors so if there's global bots they can be filtered out
				$this->usersModel->getTopContributors( 50 )
			);
		// get details for only 5 of the remaining contributors
		$contributorDetails = $this->getContributorsDetails(
			array_slice( $contributors, 0, self::TOP_CONTRIBUTORS_LIMIT )
		);

		$userRank = '-';
		$editors = count( $contributors );

		if ( $editors === 0 ) {
			$editors = '-';
		}

		if ( $userContributionCount > 0 ) {
			$rank = 1;

			foreach ( $contributors as $contributor ) {
				if ( $contributor['userId'] == $this->wg->user->getId() ) {
					$userRank = $rank;
					break;
				}
				$rank++;
			}
		}

		$this->response->setData( [
			'admin' => $this->msg( 'communitypage-admin' )->plain(),
			'topContribsHeaderText' => $this->msg( 'communitypage-top-contributors-week' )->plain(),
			'yourRankText' => $this->msg( 'communitypage-user-rank' )->plain(),
			'userContributionsText' => $this->msg( 'communitypage-user-contributions' )
				->numParams( $userContributionCount )
				->text(),
			'noContribsText' => $this->msg( 'communitypage-no-contributions' )->plain(),
			'contributors' => $contributorDetails,
			'userAvatar' => AvatarService::renderAvatar(
				$this->getUser()->getName(),
				AvatarService::AVATAR_SIZE_SMALL_PLUS
			),
			'userRank' => $userRank,
			'weeklyEditorCount' => $editors,
			'userContribCount' => $userContributionCount
		] );
	}

	/**
	 * Set context for topAdmins template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	public function getTopAdminsData() {
		$topAdmins = $this->usersModel->filterGlobalBots(
			// get all admins who have contributed in the last two years ordered by contributions
			$this->usersModel->getTopContributors( self::TOP_ADMINS_LIMIT, false, true )
		);
		$topAdminsDetails = $this->getContributorsDetails( $topAdmins );

		$topAdminsTemplateData = CommunityPageSpecialTopAdminsFormatter::prepareData( $topAdminsDetails );
		$templateMessages = [
			'topAdminsHeaderText' => $this->msg( 'communitypage-admins' )->plain(),
			'otherAdmins' => $this->msg( 'communitypage-other-admins' )->plain(),
			'noAdminText' => $this->msg( 'communitypage-no-admins' )->plain(),
			'noAdminContactText' => $this->msg( 'communitypage-no-admins-contact' )->plain(),
			'noAdminHref' => $this->msg( 'communitypage-communitycentral-link' )->inContentLanguage()->text(),
		];
		$this->response->setData( array_merge($templateMessages, $topAdminsTemplateData) );
	}

	/**
	 * Set context for allAdmins template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	public function getAllAdminsData() {
		$allAdmins = $this->usersModel->filterGlobalBots(
			// get all admins who have contributed in the last two years ordered by contributions
			$this->usersModel->getTopContributors( self::TOP_ADMINS_LIMIT, false, true )
		);
		$topAdminsDetails = $this->getContributorsDetails( $allAdmins );

		$this->response->setData( [
			'topAdminsHeaderText' => $this->msg( 'communitypage-admins' )->plain(),
			'admins' => $topAdminsDetails,
			'adminCount' => count( $topAdminsDetails ),
			'noAdminText' => $this->msg( 'communitypage-no-admins' )->plain(),
			'noAdminContactText' => $this->msg( 'communitypage-no-admins-contact' )->plain(),
			'noAdminHref' => $this->msg( 'communitypage-communitycentral-link' )->inContentLanguage()->text(),
		] );
	}

	/**
	 * Set context for recentlyJoined template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	public function getRecentlyJoinedData() {
		$recentlyJoined = $this->usersModel->getRecentlyJoinedUsers();

		$this->response->setData( [
			'allMembers' => $this->msg( 'communitypage-view-all-members' )->plain(),
			'recentlyJoinedHeaderText' => $this->msg( 'communitypage-recently-joined' )->plain(),
			'members' => $recentlyJoined,
			'haveNewMembers' => count( $recentlyJoined ) > 0,
		] );
	}

	/**
	 * Set context for allMembers template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	public function getAllMembersData() {
		$allMembers = $this->usersModel->getAllMembers();

		$this->response->setData( [
			'allMembersHeaderText' => $this->msg( 'communitypage-all-members' )->plain(),
			'admin' => $this->msg( 'communitypage-admin' )->plain(),
			'joinedText' => $this->msg( 'communitypage-joined' )->plain(),
			'noMembersText' => $this->msg( 'communitypage-no-members' )->plain(),
			'members' => array_slice( $allMembers, 0, self::ALL_MEMBERS_LIMIT ),
		] );
	}

	/**
	 * Set context for recentActivityModule template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	private function getRecentActivityData() {
		$data = $this->sendRequest( 'LatestActivityController', 'executeIndex' )->getData();
		$recentActivity = [];

		foreach ( $data['changeList'] as $activity ) {
			$changeType = $activity['changetype'];

			switch ( $changeType ) {
				case 'new':
					$changeTypeString = $this->msg( 'communitypage-created' )->plain();
					break;
				case 'delete':
					$changeTypeString = $this->msg( 'communitypage-deleted' )->plain();
					break;
				case 'edit':
					// fall through
				default:
					$changeTypeString = $this->msg( 'communitypage-edited' )->plain();
					break;
			}

			$changeMessage = $this->msg( 'communitypage-activity',
				$activity['user_href'], $changeTypeString, $activity['page_href'] )->plain();

			$recentActivity[] = [
				'timeAgo' => $activity['time_ago'],
				'userAvatar' => AvatarService::renderAvatar(
					$activity['user_name'],
					AvatarService::AVATAR_SIZE_SMALL_PLUS ),
				'userName' => $activity['user_name'],
				'userHref' => $activity['user_href'],
				'changeTypeString' => $changeTypeString,
				'editedPageTitle' => $activity['page_title'],
				'changeMessage' => $changeMessage,
			];
		}

		$title = SpecialPage::getTitleFor( 'WikiActivity' );

		return [
			'activityHeading' => $data['moduleHeader'],
			'moreActivityText' => $this->msg( 'communitypage-recent-activity' )->plain(),
			'moreActivityLink' => $title->getCanonicalURL(),
			'activity' => $recentActivity,
		];
	}

	public function getModalHeaderData() {
		$adminData =  $this->sendRequest( 'CommunityPageSpecialController', 'getTopAdminsData' )->getData();
		$memberCount = $this->usersModel->getMemberCount();

		$this->response->setData( [
			'allText' => $this->msg( 'communitypage-modal-tab-all' )->plain(),
			'allCount' => $memberCount,
			'adminsText' => $this->msg( 'communitypage-modal-tab-admins' )->plain(),
			'adminsCount' => $adminData['adminCount'],
			'leaderboardText' => $this->msg( 'communitypage-modal-tab-leaderboard' )->plain(),
		] );
	}

	private function addAssets() {
		$this->response->addAsset( 'special_community_page_js' );
		$this->response->addAsset( 'special_community_page_scss' );
	}

	/**
	 * Get details for display of top contributors
	 *
	 * @param array $contributors List of contributors containing userId and contributions for each user
	 * @return array
	 */
	private function getContributorsDetails( $contributors ) {
		$count = 0;

		return array_map( function ( $contributor ) use ( &$count ) {
			$user = User::newFromId( $contributor['userId'] );
			$userName = $user->getName();
			$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );
			$count += 1;

			return [
				'userName' => $userName,
				'avatar' => $avatar,
				'contributionsText' => $this->msg( 'communitypage-contributions' )
					->numParams( $contributor['contributions'] )->text(),
				'profilePage' => $user->getUserPage()->getLocalURL(),
				'count' => $count,
				'isAdmin' => $contributor['isAdmin'],
			];
		} , $contributors );
	}
}
