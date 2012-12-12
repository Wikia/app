<?php
class SpecialLandingPage extends UnlistedSpecialPage {
	var $button_url;
	var $loggedIn;
	var $logInClass;
	var $destCityId = 80433; // this page will always redirect to this wiki


	function __construct() {
		parent::__construct('LandingPage');
	}

	function execute($par ) {
		global $wgOut, $wgCityId, $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgShowMyToolsOnly, $wgExtensionsPath, $wgBlankImgUrl, $wgJsMimeType, $wgTitle, $wgUser, $wgRequest;
		wfProfileIn(__METHOD__);

		// redirect to www.wikia.com
		if ( $wgCityId == 177 ) {
			$destServer = WikiFactory::getVarValueByName( 'wgServer', $this->destCityId );
			$destArticlePath = WikiFactory::getVarValueByName( 'wgArticlePath', $this->destCityId );

			$wgOut->redirect( $destServer . str_replace( '$1', 'Special:LandingPage', $destArticlePath ) );
			wfProfileOut(__METHOD__);
			return;
		}

		$this->setHeaders();
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/LandingPage/css/LandingPage.scss'));

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

		// fetching the landingpage sites
		$landingPageLinks = CorporatePageHelper::parseMsgImg( 'landingpage-sites', false, false );

		// render HTML
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'imagesPath' => $wgExtensionsPath . '/wikia/LandingPage/images/',
			'languageLinks' => $languageLinks,
			'wgBlankImgUrl' => $wgBlankImgUrl,
			'wgTitle' => $wgTitle,
			'landingPageLinks' => $landingPageLinks,
			'landingPageSearch' => F::app()->getView(
				"SearchController",
				"Index",
				array (
					"placeholder" => "Search Wikia",
					"fulltext" => "0",
					"wgBlankImgUrl" => $wgBlankImgUrl,
					"wgTitle" => $wgTitle
				)
			)
		));

		$wgOut->addHTML($template->render('main'));
		wfProfileOut(__METHOD__);
	}
}
