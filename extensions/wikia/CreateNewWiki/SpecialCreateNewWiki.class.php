<?php

class SpecialCreateNewWiki extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct('CreateNewWiki', 'createnewwiki');
	}

	public function execute( $par ) {
		wfProfileIn( __METHOD__ );
		$out = $this->getOutput();

		$this->checkPermissions();

		if ( wfReadOnly() ) {
			$out->readOnlyPage();
			wfProfileOut(__METHOD__);
			return;
		}

		$out->setPageTitle(wfMsg('cnw-title'));

		$out->addHtml( F::app()->renderView( 'CreateNewWiki', 'Index' ) );
		Wikia::addAssetsToOutput( 'create_new_wiki_scss' );
		Wikia::addAssetsToOutput( 'create_new_wiki_js' );

		wfProfileOut( __METHOD__ );
	}

}
