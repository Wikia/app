<?php
class WikiBuilderModule extends Module {

	var $OWBmessages;
	var $userName;
	var $wgBlankImgUrl;
	var $wgExtensionsPath;
	var $wgLanguageCode;
	var $wgOasisThemes;
	var $wgStylePath;
	var $wgWikiPaymentAdsFreePrice;

	public function executeIndex() {
		global $wgOut, $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds, $wgUser;
		wfProfileIn( __METHOD__ );

		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = true;
		$wgSuppressAds = true;

		$this->userName = $wgUser->getName();

		wfProfileOut( __METHOD__ );
	}
}