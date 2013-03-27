<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'AdEngine',
	'author' => 'Inez Korczynski, Nick Sullivan'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'wfAdEngineSetupJSVars';
$wgHooks['WikiaSkinTopScripts'][] = 'wfAdEngineSetupTopVars';

function wfAdEngineSetupTopVars(&$vars) {
	global $wgCityId, $wgEnableKruxTargeting, $wgNoExternals;

	wfProfileIn(__METHOD__);

	// generic type of page: forum/search/article/home/...
	$vars['wikiaPageType'] = WikiaPageType::getPageType();
	$vars['wikiaPageIsHub'] = WikiaPageType::isWikiaHub();

	// category/hub
	$catInfo = HubService::getComscoreCategory($wgCityId);
	$vars['cscoreCat'] = $catInfo->cat_name;

	// Krux
	$cat = AdEngine2Controller::getCachedCategory();
	if (!empty($wgEnableKruxTargeting) && empty($wgNoExternals)) {
		$vars['wgEnableKruxTargeting'] = $wgEnableKruxTargeting;
		$vars['wgKruxCategoryId'] = WikiFactoryHub::getInstance()->getKruxId($cat['id']);
	}

	wfProfileOut(__METHOD__);

	return true;
}

function wfAdEngineSetupJSVars(Array &$vars) {
	wfProfileIn(__METHOD__);

	global $wgRequest, $wgNoExternals, $wgEnableAdsInContent, $wgEnableOpenXSPC,
		$wgAdDriverCookieLifetime, $wgHighValueCountries,
		$wgUser, $wgEnableWikiAnswers, $wgAdDriverUseCookie, $wgAdDriverUseExpiryStorage,
		$wgEnableAdMeldAPIClient, $wgEnableAdMeldAPIClientPixels,
		$wgLoadAdDriverOnLiftiumInit, $wgOutboundScreenRedirectDelay,
		$wgEnableOutboundScreenExt;

	$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

	if (!empty($wgNoExternals)) {
		$vars["wgNoExternals"] = $wgNoExternals;
	}
	if (!empty($wgEnableAdsInContent)) {
		$vars["wgEnableAdsInContent"] = $wgEnableAdsInContent;
	}
	if (!empty($wgEnableAdMeldAPIClient)) {
		$vars["wgEnableAdMeldAPIClient"] = $wgEnableAdMeldAPIClient;
	}
	if (!empty($wgEnableAdMeldAPIClientPixels)) {
		$vars["wgEnableAdMeldAPIClientPixels"] = $wgEnableAdMeldAPIClientPixels;
	}

	// OpenX SPC (init in AdProviderOpenX.js)
	if (!empty($wgEnableOpenXSPC)) {
		$vars["wgEnableOpenXSPC"] = $wgEnableOpenXSPC;
	}

	// AdDriver
	$vars['wgAdDriverCookieLifetime'] = $wgAdDriverCookieLifetime;
	$highValueCountries = WikiFactory::getVarValueByName('wgHighValueCountries', 177);	// community central
	if (empty($highValueCountries)) {
		$highValueCountries = $wgHighValueCountries;
	}
	$vars['wgHighValueCountries'] = $highValueCountries;

	if (!empty($wgAdDriverUseExpiryStorage)) {
		$vars["wgAdDriverUseExpiryStorage"] = $wgAdDriverUseExpiryStorage;
	}
	if (!empty($wgAdDriverUseCookie)) {
		$vars["wgAdDriverUseCookie"] = $wgAdDriverUseCookie;
	}
	if (!empty($wgLoadAdDriverOnLiftiumInit)) {
		$vars['wgLoadAdDriverOnLiftiumInit'] = $wgLoadAdDriverOnLiftiumInit;
	}

	if ($wgUser->getOption('showAds')) {
		$vars['wgUserShowAds'] = true;
	}

	// Answers sites
	if (!empty($wgEnableWikiAnswers)) {
		$vars['wgEnableWikiAnswers'] = $wgEnableWikiAnswers;
	}

	if (!empty($wgOutboundScreenRedirectDelay)) {
		$vars['wgOutboundScreenRedirectDelay'] = $wgOutboundScreenRedirectDelay;
	}
	if (!empty($wgEnableOutboundScreenExt)) {
		$vars['wgEnableOutboundScreenExt'] = $wgEnableOutboundScreenExt;
	}

	wfProfileOut(__METHOD__);
	return true;
}

class AdEngine {
	public static function getLiftiumOptionsScript() {
		wfProfileIn(__METHOD__);

		global $wgDBname, $wgTitle, $wgLang;

		// See Liftium.js for documentation on options
		$options = array();
		$options['pubid'] = 999;
		$options['baseUrl'] = '/__varnish_liftium/';
		$options['kv_wgDBname'] = $wgDBname;
		if (is_object($wgTitle)){
		       $options['kv_article_id'] = $wgTitle->getArticleID();
		       $options['kv_wpage'] = $wgTitle->getPartialURL();
		}
		$cat = AdEngine2Controller::getCachedCategory();
		$options['kv_Hub'] = $cat['name'];
		$options['kv_skin'] = RequestContext::getMain()->getSkin()->getSkinName();
		$options['kv_user_lang'] = $wgLang->getCode();
		$options['kv_cont_lang'] = $GLOBALS['wgLanguageCode'];
		$options['kv_isMainPage'] = WikiaPageType::isMainPage();
		$options['kv_page_type'] = WikiaPageType::getPageType();
		$options['geoUrl'] = "http://geoiplookup.wikia.com/";
		if (!empty($wgDartCustomKeyValues)) {
			$options['kv_dart'] = $wgDartCustomKeyValues;
		}

		$options['kv_domain'] = $_SERVER['HTTP_HOST'];
		$options['hasMoreCalls'] = true;
		$options['isCalledAfterOnload'] = true;
		$options['maxLoadDelay'] = 6000;

		$js = "LiftiumOptions = " . json_encode($options) . ";\n";

		$out = "\n<!-- Liftium options -->\n";
		$out .= Html::inlineScript( $js )."\n";

		wfProfileOut(__METHOD__);

		return $out;
	}

}
