<?php

class CommunityPageExperimentSpecialController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'Community', '', /* $listed = */ false );
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

		$helper = new CommunityPageExperimentHelper();

		$admins = $helper->getRandomAdmins();

		$topContributors = $helper->getTopContributors();
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
			'pageList' => $helper->getPageList(),
			'blankImage' => $this->wg->BlankImgUrl,
			// Hacky
			'headerImage' => $helper->getHeaderImage(),
		] );

		$this->setMessages();
	}

	private function setMessages() {
		$this->response->setValues( [
			'headerWelcomeLoggedInMsg' => $this->msg( 'communitypageexperiment-header-welcome' )->text(),
			'headerWelcomeAnonMsg' => $this->msg( 'communitypageexperiment-header-welcome-anon' )->parse(),
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
}
