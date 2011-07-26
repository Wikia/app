<?php
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

class SkinSkele extends SkinTemplate {

	function __construct() {
		$this->skinname  = 'skeleskin';
		$this->stylename = 'skeleskin';
		$this->template  = 'SkeleSkinTemplate';
		$this->themename = 'skeleskin';
	}

	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'skeleskin';
		$this->stylename = 'skeleskin';
		$this->template  = 'SkeleSkinTemplate';
		$this->themename = 'skeleskin';

		// register templates
		global $wgWikiaTemplateDir;
		$dir = dirname( __FILE__ ) . '/';
		$wgWikiaTemplateDir['SharedTemplates'] = $dir.'skeleskin';
	}

	function setupSkinUserCss( OutputPage $out ) {}
}

class SkeleSkinTemplate extends QuickTemplate {

	function execute() {
		Module::setSkinTemplateObj( $this );

		$entryModuleName = Wikia::getVar( 'SkeleSkinEntryModuleName', 'Skeleskin' );

		$response = F::app()->sendRequest( $entryModuleName, 'index', null, false );

		$response->sendHeaders();
		$response->render();
	}

}