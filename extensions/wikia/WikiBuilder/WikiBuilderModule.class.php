<?php
class WikiBuilderModule extends Module {

	var $OWBmessages;
	var $wgBlankImgUrl;
	var $wgExtensionsPath;
	var $wgLanguageCode;
	var $wgOasisThemes;
	var $wgStylePath;

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