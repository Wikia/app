<?php
/**
 * Sandbox SpecialPage for VisualEditor extension
 * 
 * @file
 * @ingroup Extensions
 */

class SpecialVisualEditorSandbox extends SpecialPage {

	/* Methods */

	public function __construct() {
		parent::__construct( 'VisualEditorSandbox' );
	}

	public function execute( $par ) {
		global $wgOut;

		$wgOut->addModules( 'ext.visualEditor.special.sandbox' );
		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'visualeditor-sandbox-title' )  );
		$modeWikitext = wfMsgHtml( 'visualeditor-tooltip-wikitext' );
		$modeJson = wfMsgHtml( 'visualeditor-tooltip-json' );
		$modeHtml = wfMsgHtml( 'visualeditor-tooltip-html' );
		$modeRender = wfMsgHtml( 'visualeditor-tooltip-render' );
		$modeHistory = wfMsgHtml( 'visualeditor-tooltip-history' );
		$modeHelp = wfMsgHtml( 'visualeditor-tooltip-help' );

		$dir = dirname( __FILE__ );
		ob_start();
		include( 'modules/sandbox/base.php' );
		$out = ob_get_clean();
		$wgOut->addHtml( $out );
	}
}
