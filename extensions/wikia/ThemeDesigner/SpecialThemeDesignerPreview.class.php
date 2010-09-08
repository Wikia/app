<?php

class SpecialThemeDesignerPreview extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesignerPreview', 'themedesignerpreview' );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		global $wgOut;

		$this->setHeaders();

		$wgOut->setPageTitle('Example Page Title');

		$wgOut->addHtml("<b>Some</b> <i>html</i>");

		$wgOut->addWikiText("''And some'' '''wikitext'''");

		wfProfileOut( __METHOD__ );
	}
}
