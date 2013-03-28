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
