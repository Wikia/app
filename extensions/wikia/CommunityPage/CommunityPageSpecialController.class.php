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

	public function index() {
		$this->specialPage->setHeaders();
		$output = $this->getOutput();
		$output->setPageTitle( $this->msg( 'communitypageexperiment-title' )->plain() );

		$this->addAssets();

		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressFooter = true;

		$this->foo = $this->msg( 'communitypageexperiment-title' )->plain();

		$contributors = ( new CommunityPageSpecialModel() )->getTopContributors();
		$this->contributors = $contributors;
	}



}
