<?php

class SpecialCreateNewWiki extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'CreateNewWiki', 'createnewwiki' );
	}

	/**
	 * @param string $par
	 * @throws ErrorPageError
	 */
	public function execute( $par ) {
		wfProfileIn( __METHOD__ );
		$out = $this->getOutput();

		$this->checkPermissions();

		if ( wfReadOnly() ) {
			$out->readOnlyPage();
			wfProfileOut( __METHOD__ );
			return;
		}

		// SUS-1182: CreateNewWiki should check for valid email before progressing to the second step
		if ( !$this->getUser()->isEmailConfirmed() ) {
			throw new ErrorPageError( 'cnw-error-unconfirmed-email-header', 'cnw-error-unconfirmed-email' );
		}

		$out->setPageTitle( wfMessage( 'cnw-title' ) );

		$out->addHtml( F::app()->renderView( 'CreateNewWiki', 'Index' ) );
		Wikia::addAssetsToOutput( 'create_new_wiki_scss' );
		Wikia::addAssetsToOutput( 'create_new_wiki_js' );

		wfProfileOut( __METHOD__ );
	}

}
