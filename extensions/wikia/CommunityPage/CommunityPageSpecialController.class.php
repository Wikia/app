<?php

class CommunityPageSpecialController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'Community', '', /* $listed = */ false );
	}

	public function index() {
		$this->specialPage->setHeaders();
		$output = $this->getOutput();
		$output->setPageTitle( $this->msg( 'communitypageexperiment-title' )->plain() );

		$output->addScript(
			'<script src="' .
			AssetsManager::getInstance()->getOneCommonURL('extensions/wikia/CommunityPage/scripts/ext.communityPage.js') .
			'"></script>');

		$output->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/CommunityPage/styles/ext.communityPageOverrides.scss'));
		$output->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/CommunityPage/styles/ext.communityPage.scss'));

		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressFooter = true;

		$this->foo = $this->msg( 'communitypageexperiment-title' )->plain();
	}

}
