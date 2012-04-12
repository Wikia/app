<?php
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

class SkinOasis extends WikiaSkin {
	function __construct() {
		parent::__construct( 'OasisTemplate', 'oasis' );

		//non-strict checks of css/js/scss assets/packages
		$this->strictAssetUrlCheck = false;
	}

	function setupSkinUserCss( OutputPage $out ) {}
}

class OasisTemplate extends WikiaQuickTemplate {
	function execute() {
		$this->app->setSkinTemplateObj($this);
		$response = $this->app->sendRequest( Wikia::getVar( 'OasisEntryModuleName', 'Oasis' ), 'index', null, false );
		$response->sendHeaders();
		$response->render();
	}
}