<?php

class CommunityPageSpecialController extends WikiaSpecialPageController {
	const COMMUNITY_PAGE_HERO_IMAGE = 'Community-Page-Header.jpg';
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const ALL_MEMBERS_LIMIT = 20;
	const TOP_ADMINS_MODULE_LIMIT = 3;
	const TOP_CONTRIBUTORS_MODULE_LIMIT = 5;

	private $usersModel;
	private $wikiModel;
	private $meetupModel;

	public function __construct() {
		parent::__construct( 'Community' );
		$this->usersModel = new CommunityPageSpecialUsersModel( $this->getUser() );
		$this->wikiModel = new CommunityPageSpecialWikiModel();
		$this->meetupModel = new CommunityPageMeetupModel();
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
			'heroImageUrl' => $this->getHeroImageUrl(),
			'inviteFriendsText' => $this->msg( 'communitypage-invite-friends' )->plain(),
			'headerWelcomeMsg' => $this->msg( 'communitypage-tasks-header-welcome' )->parse(),
			'adminWelcomeMsg' => $this->msg( 'communitypage-admin-welcome-message' )->text(),
			'pageListEmptyText' => $this->msg( 'communitypage-page-list-empty' )->plain(),
			'pageTitle' => $this->msg( 'communitypage-title' )->plain(),
			'topContributors' => $this->sendRequest(
				'CommunityPageSpecialController',
				'getTopContributorsData',
				[ 'limit' => self::TOP_CONTRIBUTORS_MODULE_LIMIT ]
			)->getData(),
			'topAdminsData' => $this->sendRequest( 'CommunityPageSpecialController', 'getTopAdminsData' )
				->getData(),
			'recentlyJoined' => $this->sendRequest( 'CommunityPageSpecialController', 'getRecentlyJoinedData' )
				->getData(),
			'nearByUsers' => $this->sendRequest('CommunityPageSpecialController','getNearByUsers')->getData(),
			'communityPolicyModule' => $this->getCommunityPolicyData(),
			'recentActivityModule' => $this->getRecentActivityData(),
			'insightsModules' => $this->getInsightsModulesData(),
			'helpModule' => $this->getHelpModuleData()
		] );
	}

	/**
	 * Set context for contributorsModule template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	public function getTopContributorsData() {
		$limit = $this->request->getInt( 'limit', 0 );

		$currentUserContributionCount = ( new UserStatsService( $this->getUser()->getId() ) )->getEditCountFromWeek();
		$topContributors = $this->usersModel->getTopContributors();
		$topContributorsCount = count( $topContributors );
		$userRank = $this->calculateCurrentUserRank( $currentUserContributionCount , $topContributors );

		if ( $limit > 0 ) {
			$topContributors = array_slice( $topContributors, 0, $limit );
		}

		$topContributorsDetails = $this->getContributorsDetails( $topContributors );

		$this->response->setData( [
			'admin' => $this->msg( 'communitypage-admin' )->plain(),
			'topContribsHeaderText' => $this->msg( 'communitypage-top-contributors-week' )->plain(),
			'yourRankText' => $this->msg( 'communitypage-user-rank' )->plain(),
			'userContributionsText' => $this->msg( 'communitypage-user-contributions' )
				->numParams( $this->wg->Lang->formatNum( $currentUserContributionCount ) )
				->text(),
			'noContribsText' => $this->msg( 'communitypage-no-contributions' )->plain(),
			'contributors' => $topContributorsDetails,
			'userAvatar' => AvatarService::renderAvatar(
				$this->getUser()->getName(),
				AvatarService::AVATAR_SIZE_SMALL_PLUS
			),
			'userRank' => $userRank,
			'weeklyEditorCount' => $this->formatTotalEditorsNumber( $topContributorsCount ),
			'userContribCount' => $currentUserContributionCount
		] );
	}

	/**
	 * Set context for topAdmins template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	public function getTopAdminsData() {
		$allAdmins = $this->usersModel->getAllAdmins();

		$topAdminsTemplateData = CommunityPageSpecialTopAdminsFormatter::prepareData( $allAdmins );

		// Add details to top admins
		$topAdminsTemplateData[CommunityPageSpecialTopAdminsFormatter::TOP_ADMINS_LIST] =
			$this->getContributorsDetails(
				$topAdminsTemplateData[CommunityPageSpecialTopAdminsFormatter::TOP_ADMINS_LIST]
			);

		$templateMessages = [
			'topAdminsHeaderText' => $this->msg( 'communitypage-admins' )->plain(),
			'otherAdmins' => $this->msg( 'communitypage-other-admins' )->plain(),
			'noAdminText' => $this->msg( 'communitypage-no-admins' )->plain(),
			'noAdminContactText' => $this->msg( 'communitypage-no-admins-contact' )->plain(),
			'noAdminHref' => $this->msg( 'communitypage-communitycentral-link' )->inContentLanguage()->text(),
		];
		$this->response->setData( array_merge( $templateMessages, $topAdminsTemplateData ) );
	}

	/**
	 * Set context for allAdmins template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	public function getAllAdminsData() {
		$allAdminsDetails = $this->getContributorsDetails( $this->usersModel->getAllAdmins() );

		$this->response->setData( [
			'topAdminsHeaderText' => $this->msg( 'communitypage-admins' )->plain(),
			'allAdminsList' => $allAdminsDetails,
			'allAdminsCount' => $this->wg->Lang->formatNum( count( $allAdminsDetails ) ),
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
		$currentUser = $this->getUser();
		$allMembers = $this->usersModel->getAllContributors( $currentUser->getId() );
		$allMembers = $this->addTimeAgoDataDetail( $allMembers );

		$moreMembers = SpecialPage::getTitleFor( 'ListUsers' );
		$membersCount = $this->usersModel->getMemberCount();

		$this->response->setData( [
			'allMembersHeaderText' => $this->msg( 'communitypage-all-members' )->plain(),
			'allContributorsLegend' => $this->msg( 'communitypage-modal-tab-all-contribution-header' )->plain(),
			'admin' => $this->msg( 'communitypage-admin' )->plain(),
			'joinedText' => $this->msg( 'communitypage-joined' )->plain(),
			'noMembersText' => $this->msg( 'communitypage-no-members' )->plain(),
			'members' => $allMembers,
			'membersCount' => $this->wg->Lang->formatNum( $membersCount ),
			'haveMoreMembers' => $membersCount >= CommunityPageSpecialUsersModel::ALL_CONTRIBUTORS_MODAL_LIMIT,
			'moreMembersLink' => $moreMembers->getCanonicalURL(),
			'moreMembersText' => $this->msg( 'communitypage-view-more' )->plain(),
		] );
	}
	
	public function getNearByUsers(){
		$currentUser = $this->getUser();
		$currentUserLocation = $this->getCurrentUserLocation($currentUser);
		$nearByUser = $this->meetupModel->getNearByUsers($currentUserLocation);
		
		$nearByUserDetails = $this->getContributorsDetails($nearByUser);

		$this->response->setData([
			'users' => array_filter($nearByUserDetails),
		]);
	}

	/**
	 * Set context for recentActivityModule template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	
	private  function getCurrentUserLocation($currentUser){
		return (new CommunityPageLocationModel())->getCurrentUserLocation($currentUser);
	}
	
	private function getRecentActivityData() {
		return ( new CommunityPageSpecialRecentActivityModel() )->getData();
	}

	private function getHelpModuleData() {
		return ( new CommunityPageSpecialHelpModel() )->getData();
	}

	private function getInsightsModulesData() {
		return ( new CommunityPageSpecialInsightsModel() )->getInsightsModules();
	}

	private function getCommunityPolicyData() {
		return ( new CommunityPageSpecialCommunityPolicyModel() )->getData();
	}

	public function getModalHeaderData() {
		$memberCount = $this->usersModel->getMemberCount();

		$this->response->setData( [
			'allText' => $this->msg( 'communitypage-modal-tab-all' )->plain(),
			'allCount' => $this->wg->Lang->formatNum( $memberCount ),
			'adminsText' => $this->msg( 'communitypage-modal-tab-admins' )->plain(),
			'allAdminsCount' => $this->wg->Lang->formatNum( count( $this->usersModel->getAllAdmins() ) ),
			'leaderboardText' => $this->msg( 'communitypage-top-contributors-week' )->plain(),
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
			if ( User::isIp( $userName ) ) {
				return '';
			}
			$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );
			$count += 1;

			return [
				'userName' => $userName,
				'avatar' => $avatar,
				'contributionsText' => $this->msg( 'communitypage-contributions' )
					->numParams( $this->wg->Lang->formatNum( $contributor['contributions'] ) )->text(),
				'profilePage' => $user->getUserPage()->getLocalURL(),
				'count' => $count,
				'isAdmin' => $contributor['isAdmin'],
				'city' => $contributor['city'],
			];
		} , $contributors );
	}

	private function addTimeAgoDataDetail( $members ) {
		foreach ( $members as $key => $member ) {
			$members[$key]['timeAgo'] = wfTimeFormatAgo( $member['latestRevision'] );
		}

		return $members;
	}

	private function getHeroImageUrl() {
		$heroImageUrl = '';
		$heroImage = Title::newFromText( self::COMMUNITY_PAGE_HERO_IMAGE, NS_FILE );
		if ( $heroImage instanceof Title && $heroImage->exists() ) {
			$heroImageFile = wfFindFile( $heroImage );
			if ( $heroImageFile instanceof File ) {
				$heroImageUrl = $heroImageFile->getUrl();
			}
		}

		return $heroImageUrl;
	}

	private function calculateCurrentUserRank( $userContributionCount , $topContributors ) {
		$userRank = '-';

		if ( $userContributionCount > 0 ) {
			$rank = 1;

			foreach ( $topContributors as $contributor ) {
				if ( $contributor['userId'] == $this->wg->user->getId() ) {
					$userRank = $rank;
					break;
				}
				$rank++;
			}
		}
		return $userRank;
	}

	private function formatTotalEditorsNumber( $editors ) {
		if ( $editors === 0 ) {
			$editors = '-';
		}

		return $editors;
	}
}
