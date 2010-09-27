<?php

class SpecialWikiBuilder extends UnlistedSpecialPage {

	public function __construct() {
		wfLoadExtensionMessages('WikiBuilder');
		parent::__construct('WikiBuilder', 'wikibuilder');
	}
	
	public function execute() {
		global $wgOut, $wgExtensionsPath, $wgUser;
		wfProfileIn( __METHOD__ );
		
		// TODO: check user rights
		if ( !$wgUser->isAllowed( 'wikibuilder' ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}
		
		$wgOut->addHtml(wfRenderModule('WikiBuilder'));
		$wgOut->addStyle(wfGetSassUrl('extensions/wikia/WikiBuilder/css/WikiBuilder.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/JavascriptAPI/Mediawiki.js"></script>');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ThemeDesigner/js/ThemeDesigner.js"></script>');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiBuilder/js/WikiBuilder.js"></script>');
		
		wfProfileOut( __METHOD__ );
	}

}