<?php
class SpecialLandingPage extends UnlistedSpecialPage {
	var $button_url;
	var $loggedIn;
	var $logInClass;
	
	
	function __construct() {
		wfLoadExtensionMessages('LandingPage');
		parent::__construct('LandingPage');
	}

	function execute($par ) {
		global $wgOut, $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgShowMyToolsOnly, $wgExtensionsPath, $wgBlankImgUrl, $wgJsMimeType, $wgStyleVersion, $wgTitle, $wgUser, $wgRequest;
		wfProfileIn(__METHOD__);
		$this->setHeaders();
		$wgOut->addStyle(wfGetSassUrl('extensions/wikia/LandingPage/css/LandingPage.scss'));

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/LandingPage/js/LandingPage.js?{$wgStyleVersion}\" ></script>\n");
		// hide wiki and page header
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;

		// only shown "My Tools" on floating toolbar
		$wgShowMyToolsOnly = true;

		// parse language links (RT #71622)
		$languageLinks = array();

		$parsedMsg = wfStringToArray(wfMsg('landingpage-language-links'), '*', 10);
		foreach($parsedMsg as $item) {
			if ($item != '') {
				list($text, $lang) = explode('|', $item);
				$languageLinks[] = array(
					'text' => $text,
					'href' => $wgTitle->getLocalUrl("uselang={$lang}"),
				);
			}
		}
		
	
	
		if ( isset($wgRequest->data['uselang'] )) {
			$languageClass = 'landingpage-language-' .$wgRequest->data['uselang'];
		}
		else {
			$languageClass = '';
		}
	

		// render HTML
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'imagesPath' => $wgExtensionsPath . '/wikia/LandingPage/images/',
			'languageLinks' => $languageLinks,
			'wgBlankImgUrl' => $wgBlankImgUrl,
			'wgTitle' => $wgTitle,
			'languageClass' => $languageClass
		));

		$wgOut->addHTML($template->render('main'));
		wfProfileOut(__METHOD__);
	}
}
