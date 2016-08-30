<?php

class SpecialCreateNewWiki extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct('CreateNewWiki', 'createnewwiki');
	}

	public function execute( $par ) {
		global $wgUser, $wgOut;
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			wfProfileOut(__METHOD__);
			return;
		}

		if (!$wgUser->isAllowed('createnewwiki')) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		$wgOut->setPageTitle(wfMsg('cnw-title'));
		$wgOut->addHtml(F::app()->renderView('CreateNewWiki', 'Index'));
		Wikia::addAssetsToOutput( 'create_new_wiki_scss' );
		Wikia::addAssetsToOutput( 'create_new_wiki_js' );

		wfProfileOut( __METHOD__ );
	}

}
