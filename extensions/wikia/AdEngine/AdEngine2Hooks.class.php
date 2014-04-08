<?php
/**
 * AdEngine II Hooks
 */
class AdEngine2Hooks {

	/**
	 * Handle URL parameters and set proper global variables early enough
	 *
	 * @author Sergey Naumov
	 */
	static public function onAfterInitialize($title, $article, $output, $user, WebRequest $request, $wiki) {

		global $wgAdDriverForceDirectGptAd, $wgAdDriverForceLiftiumAd, $wgEnableRHonDesktop,
			   $wgLiftiumOnLoad, $wgNoExternals, $wgAdVideoTargeting, $wgAdPageType;

		$wgNoExternals = $request->getBool('noexternals', $wgNoExternals);
		$wgLiftiumOnLoad = $request->getBool('liftiumonload', (bool) $wgLiftiumOnLoad);
		$wgAdVideoTargeting = $request->getBool('videotargetting', (bool) $wgAdVideoTargeting);

		$wgEnableRHonDesktop = $request->getBool( 'noremnant', $wgEnableRHonDesktop );

		$wgAdDriverForceDirectGptAd = $request->getBool('forcedirectgpt', $wgAdDriverForceDirectGptAd);
		$wgAdDriverForceLiftiumAd = $request->getBool('forceliftium', $wgAdDriverForceLiftiumAd);
		$wgAdPageType = AdEngine2Service::getPageType();

		return true;
	}


	/**
	 * Register global JS variables bottom
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	static public function onMakeGlobalVariablesScript(array &$vars) {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgEnableAdsInContent, $wgEnableOpenXSPC,
			   $wgHighValueCountriesDefault, $wgUser,
			   $wgEnableAdMeldAPIClient, $wgEnableAdMeldAPIClientPixels,
			   $wgOutboundScreenRedirectDelay, $wgEnableOutboundScreenExt, $wgAdDriverUseSevenOneMedia,
			   $wgAdPageLevelCategoryLangsDefault, $wgAdDriverTrackState,
			   $wgAdDriverForceDirectGptAd, $wgAdDriverForceLiftiumAd,
			   $wgOasisResponsive, $wgOasisResponsiveLimited,
			   $wgEnableRHonDesktop, $wgAdPageType, $wgOut;

		$highValueCountries = WikiFactory::getVarValueByName(
			'wgHighValueCountries',
			[$wgCityId, Wikia::COMMUNITY_WIKI_ID],
			false,
			$wgHighValueCountriesDefault
		);

		$pageLevelCategoryLanguages = WikiFactory::getVarValueByName(
			'wgAdPageLevelCategoryLangs',
			[$wgCityId, Wikia::COMMUNITY_WIKI_ID],
			false,
			$wgAdPageLevelCategoryLangsDefault
		);

		$variablesToExpose = [
			"wgEnableAdsInContent" => $wgEnableAdsInContent,
			"wgEnableAdMeldAPIClient" => $wgEnableAdMeldAPIClient,
			"wgEnableAdMeldAPIClientPixels" => $wgEnableAdMeldAPIClientPixels,
			"wgEnableOpenXSPC" => $wgEnableOpenXSPC,
			// Ad Driver
			"wgHighValueCountries" => $highValueCountries,
			"wgAdPageLevelCategoryLangs" => $pageLevelCategoryLanguages,
			'wgAdPageType' => $wgAdPageType,
			"wgAdDriverUseSevenOneMedia" => $wgAdDriverUseSevenOneMedia,
			"wgUserShowAds" => $wgUser->getOption('showAds'),
			"wgOutboundScreenRedirectDelay" => $wgOutboundScreenRedirectDelay,
			"wgEnableOutboundScreenExt" => $wgEnableOutboundScreenExt,
			"wgAdDriverTrackState" => $wgAdDriverTrackState,
			"wgEnableRHonDesktop" => $wgEnableRHonDesktop,
			"wgAdDriverForceDirectGptAd" => $wgAdDriverForceDirectGptAd,
			"wgAdDriverForceLiftiumAd" => $wgAdDriverForceLiftiumAd
		];

		if (!empty($wgAdDriverUseSevenOneMedia)) {
			$url = ResourceLoader::makeCustomURL($wgOut, ['wikia.ext.adengine.sevenonemedia'], 'scripts');
			$variablesToExpose['wgAdDriverSevenOneMediaCombinedUrl'] = $url;
			$variablesToExpose['wgAdDriverSevenOneMediaDisableFirePlaces'] = !empty($wgOasisResponsive) && empty($wgOasisResponsiveLimited);
		}

		foreach($variablesToExpose as $varName => $varValue) {
			if ((bool) $varValue === true) {
				$vars[$varName] = $varValue;
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Register ad-related vars on top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	static public function onWikiaSkinTopScripts(&$vars, &$scripts) {
		global $wgRequest, $wgCityId, $wgEnableKruxTargeting, $wgNoExternals, $wgAdVideoTargeting, $wgLiftiumOnLoad,
			   $wgDartCustomKeyValues, $wgWikiDirectedAtChildrenByStaff;

		wfProfileIn(__METHOD__);

		// ad slots container
		$vars['adslots2'] = [];

		// Used to hop by DART ads
		$vars['adDriverLastDARTCallNoAds'] = [];

		// 3rd party code (eg. dart collapse slot template) can force AdDriver2 to respect unusual slot status
		$vars['adDriver2ForcedStatus'] = [];

		$variablesToExpose = [
			// AdEngine2.js
			'wgLoadAdsInHead' => AdEngine2Service::areAdsInHead(),
			'wgAdsInHeadGroup' => AdEngine2Service::getAdsInHeadGroup(),
			'wgShowAds' => AdEngine2Service::areAdsShowableOnPage(),
			'wgAdsShowableOnPage' => AdEngine2Service::areAdsShowableOnPage(),
			'wgAdVideoTargeting' => $wgAdVideoTargeting,
			'wgAdDriverStartLiftiumOnLoad' => $wgLiftiumOnLoad,

			// generic type of page: forum/search/article/home/...
			'wikiaPageType' => WikiaPageType::getPageType(),
			'wikiaPageIsHub' => WikiaPageType::isWikiaHub(),
			'wikiaPageIsWikiaHomePage' => WikiaPageType::isWikiaHomePage(),
			'wikiaPageIsCorporate' => WikiaPageType::isCorporatePage(),

			// category/hub
			'cscoreCat' => HubService::getCategoryInfoForCity($wgCityId)->cat_name,

			// Krux
			'wgEnableKruxTargeting' => $wgEnableKruxTargeting,
			'wgUsePostScribe' => $wgRequest->getBool('usepostscribe', false),
			'wgDartCustomKeyValues' => $wgDartCustomKeyValues,
			'wgWikiDirectedAtChildren' => (bool) $wgWikiDirectedAtChildrenByStaff
		];

		// WikiaDartHelper.js
		$cat = AdEngine2Service::getCachedCategory();
		$vars['cityShort'] = $cat['short'];

		if (!empty($wgEnableKruxTargeting) && empty($wgNoExternals)) {
			$cat = AdEngine2Service::getCachedCategory();
			$variablesToExpose['wgKruxCategoryId'] = WikiFactoryHub::getInstance()->getKruxId($cat['id']);
		}

		foreach($variablesToExpose as $varName => $varValue) {
			if ((bool) $varValue === true) {
				$vars[$varName] = $varValue;
			}
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Modify assets appended to the bottom of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	static public function onOasisSkinAssetGroups(&$jsAssets) {

		global $wgEnableRHonDesktop;

		$coreGroupIndex = array_search(AdEngine2Service::ASSET_GROUP_CORE, $jsAssets);
		if ($coreGroupIndex === false) {
			// Do nothing. oasis_shared_core_js must be present for ads to work
			return true;
		}

		if (!AdEngine2Service::areAdsInHead()) {
			// Add ad asset to JavaScripts loaded on bottom (with regular JavaScripts)
			array_splice($jsAssets, $coreGroupIndex + 1, 0, AdEngine2Service::ASSET_GROUP_ADENGINE);
		}

		if ($wgEnableRHonDesktop === false) {
			$jsAssets[] = AdEngine2Service::ASSET_GROUP_LIFTIUM;
		}
		return true;
	}

	/**
	 * Modify assets appended to the top of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	static public function onOasisSkinAssetGroupsBlocking(&$jsAssets) {
		if (AdEngine2Service::areAdsInHead()) {
			// Add ad asset to JavaScripts loaded on top (in <head>)
			$jsAssets[] = AdEngine2Service::ASSET_GROUP_ADENGINE;
		}
		return true;
	}

	static public function onWikiaSkinTopModules(&$scriptModules, $skin) {
		if (AdEngine2Service::areAdsInHead() || AnalyticsProviderAmazonDirectTargetedBuy::isEnabled()) {
			$scriptModules[] = 'wikia.cookies';
			$scriptModules[] = 'wikia.geo';
			$scriptModules[] = 'wikia.window';
		}
		if (AdEngine2Service::areAdsInHead()) {
			$scriptModules[] = 'wikia.location';
			$scriptModules[] = 'wikia.log';
			$scriptModules[] = 'wikia.querystring';
			$scriptModules[] = 'wikia.tracker';
		}
		return true;
	}
}
