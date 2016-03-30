<?php

class CommunityPageSpecialController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	public $usersModel;

	public function __construct() {
		parent::__construct( 'Community' );
		$this->usersModel = new CommunityPageSpecialUsersModel();
	}

	public function index() {
		$this->specialPage->setHeaders();
		$this->getOutput()->setPageTitle( $this->msg( 'communitypage-title' )->plain() );
		$this->addAssets();

		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressFooter = true;

		$this->response->setValues( [
			'adminWelcomeMsg' => $this->msg( 'communitypage-tasks-admin-welcome' )->text(),
			'pageListEmptyText' => $this->msg( 'communitypage-page-list-empty' )->plain(),
			'showPopupMessage' => true,
			'popupMessageText' => 'This is just a test message for the popup message box',
			'userIsMember' => CommunityPageSpecialHelper::userHasEdited( $this->wg->User ),
			'pageTitle' => $this->msg( 'communitypage-title' )->plain(),
			'topContributors' => $this->getTopContributorsData(),
			'admins' => $this->getAdminsModuleData(),
			'recentlyJoined' => $this->getRecentlyJoinedData(),
		] );
	}

	public function header() {
		$this->response->setValues( [
			'inviteFriendsText' => $this->msg( 'communitypage-invite-friends' )->plain(),
			'headerWelcomeMsg' => $this->msg( 'communitypage-tasks-header-welcome' )->plain(),
			'pageListEditText' => $this->msg( 'communitypage-page-list-edit' )->plain(),
			'thisMonthText' => $this->msg( 'communitypage-this-month' )->plain(),
			'showMonthlySummary' => true,
			'statPagesTitle' => $this->msg( 'communitypage-pages' )->plain(),
			'statPagesNumber' => 45,
			'statPageViewsTitle' => $this->msg( 'communitypage-pageviews' )->plain(),
			'statPageViewsNumber' => '1,049',
			'statEditsTitle' => $this->msg( 'communitypage-edits' )->plain(),
			'statEditsNumber' => 621,
			'statEditorsTitle' => $this->msg( 'communitypage-editors' )->plain(),
			'statEditorsNumber' => 23,
		] );
	}

	/**
	 * Set context for contributorsModule template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	protected function getTopContributorsData() {
		$userContribCount = 2;

		return [
			'topContribsHeaderText' => $this->msg( 'communitypage-top-contributors-week' )->plain(),
			'yourRankText' => $this->msg( 'communitypage-user-rank' )->plain(),
			'userContributionsText' => $this->msg( 'communitypage-user-contributions' )
				->numParams( $userContribCount )
				->text(),
			'contributors' => $this->getContributorsDetails(
				DataMartService::getTopContributorsByWiki( 5 )
			),
			'userAvatar' => AvatarService::renderAvatar(
				$this->wg->user->getName(),
				AvatarService::AVATAR_SIZE_SMALL_PLUS
			),
			'userRank' => 302,
			'memberCount' => 309,
			'userContribCount' => $userContribCount
		];
	}

	/**
	 * Set context for adminsModule template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	protected function getAdminsModuleData() {
		$topAdmins = $this->usersModel->getTopAdmins();
		$remainingAdminCount = count ( $topAdmins ) - 2;

		return [
			'topAdminsHeaderText' => $this->msg( 'communitypage-admins' )->plain(),
			'otherAdmins' => $this->msg( 'communitypage-other-admins' )->plain(),
			'admins' => array_slice( $topAdmins, 0, 2 ),
			'otherAdminCount' => $remainingAdminCount,
			'haveOtherAdmins' => $remainingAdminCount > 0,
		];
	}

	/**
	 * Set context for recentlyJoinedModule template. Needs to be passed through the index method in order to work.
	 * @return array
	 */
	protected function getRecentlyJoinedData() {
		$recentlyJoined = $this->usersModel->getRecentlyJoinedUsers();

		return [
			'recentlyJoined' => $recentlyJoined,
			'recentlyJoinedHeaderText' => $this->msg( 'communitypage-recently-joined' )->plain(),
			'members' => $recentlyJoined,
		];
	}

	protected function addAssets() {
		$this->response->addAsset( 'special_community_page_js' );
		$this->response->addAsset( 'special_community_page_scss' );
	}

	/**
	 * Get details for display of top contributors
	 *
	 * @param array $contributors List of contributors containing userId and contributions for each user
	 * @return array
	 */
	protected function getContributorsDetails( $contributors ) {
		$count = 0;

		return array_map( function ( $contributor ) use ( &$count ) {
			$user = User::newFromId( $contributor['userId'] );
			$userName = $user->getName();
			$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS - 2 );
			$count += 1;

			return [
				'userName' => $userName,
				'avatar' => $avatar,
				'contributionsText' => $this->msg( 'communitypage-contributions' )
					->numParams( $contributor['contributions'] )->text(),
				'profilePage' => $user->getUserPage()->getLocalURL(),
				'count' => $count,
			];
		}, $contributors );
	}
}
