<?php

class CommunityPageExperimentSpecialController extends WikiaSpecialPageController {
	private $wikiService;

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const HEADER_IMAGE_NAME = 'Community-Page-Header.jpg';

	public function __construct() {
		parent::__construct( 'Community', '', /* $listed = */ false );

		$this->wikiService = new WikiService();
	}

	public function index() {
		$this->specialPage->setHeaders();
		$output = $this->getOutput();
		$output->setPageTitle( $this->msg( 'communitypageexperiment-title' )->plain() );
		$output->addModuleStyles( 'ext.communityPageExperiment' );
		$output->addModuleScripts( 'ext.communityPageExperiment' );
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressFooter = true;

		$numAdmins = $this->getRequest()->getBool( 'singleadmin' ) ? 1 : 2;

		$admins = $this->getRandomAdmins( $numAdmins );

		$topContributors = $this->getTopContributors();
		$extraContributors = false;
		if ( $topContributors['numextra'] > 0 ) {
			$extraContributors = $this->msg( 'communitypageexperiment-top-contributors-more' )
			                          ->numParams( $topContributors['numextra'] )->text();
		}

		$this->response->setValues( [
			'isLoggedIn' => $this->getUser()->isLoggedIn(),
			'signupUrl' => $this->getSignupUrl(),
			'admins' => $admins,
			'topContributors' => $topContributors['list'],
			'extraContributors' => $extraContributors,
			'pageList' => $this->getPageList(),
			'blankImage' => $this->wg->BlankImgUrl,
			// Hacky
			'headerImage' => $this->getHeaderImage(),
		] );

		$this->setMessages();
	}

	private function getRandomAdmins( $num = 1 ) {
		$adminIds = $this->wikiService->getWikiAdminIds( $this->wg->CityId, /* $useMaster = */ false, /* $excludeBots = */ true );
		if ( empty( $adminIds ) ) {
			return [];
		}
		$numAdmins = count( $adminIds );
		if ( $numAdmins < $num ) {
			$num = $numAdmins;
		}

		$randomAdminIds = array_rand( $adminIds, $num );
		if ( !is_array( $randomAdminIds ) ) {
			$randomAdminIds = [ $randomAdminIds ];
		}

		$admins = [];
		foreach ( $randomAdminIds as $adminId ) {
			$admins[] = $this->getAdminData( $adminIds[$adminId] );
		}

		return $admins;
	}

	private function getAdminData( $userId ) {
		$adminUser = User::newFromId( $userId );
		$adminUserName = $adminUser->getName();
		$adminAvatar = '';
		$extraAvatarClasses = 'logged-avatar-placeholder';

		if ( !AvatarService::isEmptyOrFirstDefault( $adminUserName ) ) {
			$extraAvatarClasses = 'logged-avatar';
			$adminAvatar = AvatarService::renderAvatar( $adminUser->getName(), AvatarService::AVATAR_SIZE_MEDIUM - 2 );
		}

		return [
			'adminUserName' => $adminUserName,
			'adminUserUrl' => $adminUser->getUserPage()->getLocalURL(),
			'extraAvatarClasses' => $extraAvatarClasses,
			'adminAvatar' => $adminAvatar,
		];
	}

	private function getTopContributors() {
		$topEditors = $this->wikiService->getTopEditors( $this->wg->CityId, /* $limit = */ WikiService::TOPUSER_LIMIT, /* $excludeBots = */ true );
		$limit = 5;
		$limitedTopEditors = array_slice( $topEditors, 0, $limit, true );
		$numOtherEditors = count( $topEditors ) - $limit;

		$topEditorList = [];
		foreach ( $limitedTopEditors as $userId => $edits ) {
			$user = User::newFromId( $userId );
			$userName = $user->getName();
			$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS - 2 );

			$topEditorList[] = [
				'username' => $userName,
				'userpage' => $user->getUserPage()->getLocalURL(),
				'avatar' => $avatar,
				'edits' => $this->getLanguage()->formatNum( $edits ),
			];
		}
		return [ 'list' => $topEditorList, 'numextra' => $numOtherEditors ];
	}

	private function getPageList() {
		global $wgCommunityPageExperimentPages;

		$pages = [];

		if ( empty( $wgCommunityPageExperimentPages ) ) {
			return $pages;
		}

		foreach ( $wgCommunityPageExperimentPages as $page ) {
			$title = Title::newFromText( $page );
			if ( !( $title instanceof Title ) ) {
				continue;
			}

			$editActionParam = ( EditorPreference::isVisualEditorPrimary() ? 'veaction' : 'action' );

			$pages[] = [
				'titleText' => $title->getPrefixedText(),
				'titleUrl' => $title->getLocalURL(),
				'editUrl' => $title->getLocalURL( [ $editActionParam => 'edit' ] ),
			];
		}

		return $pages;
	}

	private function setMessages() {
		$this->response->setValues( [
			'headerWelcomeLoggedInMsg' => $this->msg( 'communitypageexperiment-header-welcome' )->text(),
			'headerWelcomeAnonMsg' => $this->msg( 'communitypageexperiment-header-welcome-anon' )->plain(),
			'joinButtonText' => $this->msg( 'communitypageexperiment-header-join-button' )->plain(),
			'adminWelcomeMsg' => $this->msg( 'communitypageexperiment-admin-welcome' )->text(),
			'adminGroupName' => $this->msg( 'communitypageexperiment-admin-group-name' )->plain(),
			'topContributorsHeading' => $this->msg( 'communitypageexperiment-top-contributors' )->plain(),
			'pageListEmptyText' => $this->msg( 'communitypageexperiment-page-list-empty' )->plain(),
			'pageListEditText' => $this->msg( 'communitypageexperiment-page-list-edit' )->plain(),
		] );
	}

	private function getSignupUrl() {
		$userLoginHelper = new UserLoginHelper();
		return $userLoginHelper->getNewAuthUrl( '/register' );
	}

	private function getHeaderImage() {
		$title = Title::newFromText( self::HEADER_IMAGE_NAME, NS_FILE );
		$file = wfFindFile( $title );
		if ( $file instanceof File ) {
			return $file->getUrl();
		}

		return false;
	}
}
