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
			'contributors' => $this->getTopContributorsDetails(),
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

	protected function addAssets() {
		$this->response->addAsset( 'special_community_page_js' );
		$this->response->addAsset( 'special_community_page_scss' );
	}

	/**
	 * Get details for display of top contributors
	 *
	 * @return array
	 */
	protected function getTopContributorsDetails() {
		$contributors = $this->usersModel->getTopContributorsRaw();

		return array_map( function ( $contributor ) {
			$user = User::newFromId( $contributor['userId'] );
			$userName = $user->getName();
			$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS - 2 );

			return [
				'userName' => $userName,
				'avatar' => $avatar,
				'contributions' => $contributor['contributions'],
				'profilePage' => $user->getUserPage()->getLocalURL()
			];
		}, $contributors );
	}


}
