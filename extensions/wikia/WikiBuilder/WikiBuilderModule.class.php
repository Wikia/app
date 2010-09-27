<?php
class WikiBuilderModule extends Module {

	var $wgExtensionsPath;
	var $wgOasisThemes;
	var $wgBlankImgUrl;
	var $wgLanguageCode;
	var $OWBmessages;

	public function executeIndex() {
		global $wgOut, $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds;
		wfProfileIn( __METHOD__ );
		
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = true;
		$wgSuppressAds = true;
		
		wfProfileOut( __METHOD__ );
	}

}