<?php
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

class SkinOasis extends SkinTemplate {

	function __construct() {
		$this->skinname  = 'oasis';
		$this->stylename = 'oasis';
		$this->template  = 'OasisTemplate';
		$this->themename = 'oasis';
	}

	function setupSkinUserCss( OutputPage $out ) {}
}

class OasisTemplate extends QuickTemplate {

	function execute() {
		Module::setSkinTemplateObj($this);

		$entryModuleName = Wikia::getVar( 'OasisEntryModuleName', 'Oasis' );

		$response = F::app()->sendRequest( $entryModuleName, 'index', null, false );

		$response->sendHeaders();
		$response->render();
	}

}
