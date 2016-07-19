<?php

class CommunityTasksPageSpecialController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'CommunityTasks', '', /* $listed = */ false );
	}

	public function index() {
		$this->specialPage->setHeaders();
		$output = $this->getOutput();
		$output->setPageTitle( $this->msg( 'communitypageexperiment-tasks-title' )->plain() );
		$output->addModuleStyles( 'ext.communityPageExperiment' );
		$output->addModuleScripts( 'ext.communityPageExperiment' );
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressFooter = true;

		$helper = new CommunityPageExperimentHelper();

		$this->response->setValues( [
			'pageList' => $helper->getPageList(),
			'blankImage' => $this->wg->BlankImgUrl,
			// Hacky
			'headerImage' => $helper->getHeaderImage(),
		] );

		$this->setMessages();
	}

	private function setMessages() {
		$this->response->setValues( [
			'headerWelcomeMsg' => $this->msg( 'communitypageexperiment-tasks-header-welcome' )->plain(),
			'adminWelcomeMsg' => $this->msg( 'communitypageexperiment-tasks-admin-welcome' )->text(),
			'pageListEmptyText' => $this->msg( 'communitypageexperiment-page-list-empty' )->plain(),
			'pageListEditText' => $this->msg( 'communitypageexperiment-page-list-edit' )->plain(),
		] );
	}
}
