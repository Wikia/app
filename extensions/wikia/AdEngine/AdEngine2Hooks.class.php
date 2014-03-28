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
			   $wgLiftiumOnLoad, $wgNoExternals, $wgAdVideoTargeting;

		$wgNoExternals = $request->getBool('noexternals', $wgNoExternals);
		$wgLiftiumOnLoad = $request->getBool('liftiumonload', (bool) $wgLiftiumOnLoad);
		$wgAdVideoTargeting = $request->getBool('videotargetting', (bool) $wgAdVideoTargeting);

		$wgEnableRHonDesktop = $request->getBool( 'noremnant', $wgEnableRHonDesktop );

		$wgAdDriverForceDirectGptAd = $request->getBool( 'forcedirectgpt', $wgAdDriverForceDirectGptAd );
		$wgAdDriverForceLiftiumAd = $request->getBool( 'forceliftium', $wgAdDriverForceLiftiumAd );

		return true;
	}


	/**
	 * Register global JS variables bottom (migrated from wfAdEngineSetupJSVars)
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	static public function onMakeGlobalVariablesScript(array &$vars) {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgEnableAdsInContent, $wgEnableOpenXSPC,
			   $wgAdDriverCookieLifetime, $wgHighValueCountriesDefault,
			   $wgUser, $wgEnableWikiAnswers, $wgAdDriverUseCookie, $wgAdDriverUseExpiryStorage,
			   $wgEnableAdMeldAPIClient, $wgEnableAdMeldAPIClientPixels,
			   $wgLoadAdDriverOnLiftiumInit, $wgOutboundScreenRedirectDelay,
			   $wgEnableOutboundScreenExt, $wgAdDriverUseSevenOneMedia,
			   $wgAdPageLevelCategoryLangsDefault, $wgAdDriverTrackState,
			   $wgAdDriverForceDirectGptAd, $wgAdDriverForceLiftiumAd,
			   $wgEnableRHonDesktop, $wgOut;

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
			$variablesToExpose['wgAdDriverSevenOneMediaCombinedUrl'] = ResourceLoader::makeCustomURL($wgOut, ['wikia.ext.adengine.sevenonemedia'], 'scripts');
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
	 * Register ad-related vars on top (migrated from wfAdEngineSetupTopVars)
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


	/**
	 * Deal with external interwiki links: add exitstitial class to them if needed
	 *
	 * @param $skin
	 * @param $target
	 * @param $options
	 * @param $text
	 * @param $attribs
	 * @param $ret
	 *
	 * @return bool
	 */
	static public function onLinkEnd($skin, Title $target, array $options, &$text, array &$attribs, &$ret) {
		if ($target->isExternal()) {
			static::handleExternalLink($attribs['href'], $attribs);
		}
		return true;
	}

	/**
	 * Deal with external links: add exitstitial class to them if needed
	 *
	 * @param $url
	 * @param $text
	 * @param $link
	 * @param $attribs
	 *
	 * @return bool
	 */
	static function onLinkerMakeExternalLink(&$url, &$text, &$link, &$attribs) {
		static::handleExternalLink($url, $attribs);
		return true;
	}

	/**
	 * Add exitstitial class to the external links pointing to not-whitelisted domains
	 * if $wgEnableOutboundScreenExt is set, user is anonymous, not in editor, etc
	 *
	 * @param $url
	 * @param $attribs
	 *
	 * @return null
	 */
	static private function handleExternalLink($url, &$attribs) {
		global $wgEnableOutboundScreenExt, $wgRTEParserEnabled, $wgTitle, $wgUser;

		if (!$wgEnableOutboundScreenExt
			|| $wgRTEParserEnabled    // skip logic when in FCK
			|| empty($wgTitle)        // setup functions can call MakeExternalLink before wgTitle is set RT#144229
			|| $wgUser->isLoggedIn()  // logged in users have no exit stitial ads
			|| strpos($url, 'http://') !== 0
		) {
			return;
		}

		foreach (static::getExitstitialUrlsWhiteList() as $whiteListedUrl) {
			if (preg_match('/' . preg_quote($whiteListedUrl) . '/i', $url)) {
				return;
			}
		}

		if (isset($attribs['class'])) {
			$attribs['class'] .= ' exitstitial';
		}
	}


	static private function getExitstitialUrlsWhiteList() {

		global $wgDevelEnvironment, $wgCityId;

		static $whiteList = null;

		if (is_array($whiteList)) {
			return $whiteList;
		}

		$whiteList = [];
		$whiteListContent = wfMsgExt('outbound-screen-whitelist', array('language' => 'en'));

		if (!empty($whiteListContent)) {
			$lines = explode("\n", $whiteListContent);
			foreach($lines as $line) {
				if(strpos($line, '* ') === 0 ) {
					$whiteList[] = trim($line, '* ');
				}
			}
		}

		$wikiDomains = WikiFactory::getDomains($wgCityId);
		if ($wikiDomains !== false) {
			$whiteList = array_merge($wikiDomains, $whiteList);
		}

		// Devboxes run on different domains than just what is in WikiFactory.
		if ($wgDevelEnvironment && !empty($_SERVER['SERVER_NAME'])) {
			array_unshift($whiteList, $_SERVER['SERVER_NAME']);
		}

		return $whiteList;
	}

}
