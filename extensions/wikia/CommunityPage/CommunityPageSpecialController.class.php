<?php

class CommunityPageSpecialController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'Community', '', /* $listed = */ false );
	}

	protected function addAssets() {
		$this->response->addAsset( 'special_community_page_js' );
		$this->response->addAsset( 'special_community_page_scss' );
	}

	protected function populateData() {
		$model = new CommunityPageSpecialModel();

		$this->response->setValues( [
			'headerWelcomeMsg' => $this->msg( 'communitypage-tasks-header-welcome' )->plain(),
			'adminWelcomeMsg' => $this->msg( 'communitypage-tasks-admin-welcome' )->text(),
			'pageListEmptyText' => $this->msg( 'communitypage-page-list-empty' )->plain(),
			'pageListEditText' => $this->msg( 'communitypage-page-list-edit' )->plain(),
			'inviteFriendsText' => $this->msg( 'communitypage-invite-friends' )->plain(),
		] );

		$this->userIsMember = CommunityPageSpecialHelper::userHasEdited( $this->wg->User );
		$this->pageTitle = $this->msg( 'communitypage-title' )->plain();
		$this->contributors = $model->getTopContributorsDetails();
	}

	public function index() {
		$this->specialPage->setHeaders();
		$output = $this->getOutput();
		$output->setPageTitle( $this->msg( 'communitypage-title' )->plain() );

		$this->addAssets();
		$this->populateData();

		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressFooter = true;
	}
}
