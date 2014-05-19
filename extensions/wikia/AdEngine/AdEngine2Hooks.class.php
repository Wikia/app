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

		// TODO: review top and bottom vars (important for adsinhead)

		global $wgAdDriverForceDirectGptAd, $wgAdDriverForceLiftiumAd, $wgEnableRHonDesktop,
			$wgLiftiumOnLoad, $wgNoExternals, $wgAdVideoTargeting, $wgAdPageType, $wgLoadAdsInHead, $wgEnableKruxTargeting;

		$wgNoExternals = $request->getBool('noexternals', $wgNoExternals);
		$wgLiftiumOnLoad = $request->getBool('liftiumonload', (bool) $wgLiftiumOnLoad);
		$wgAdVideoTargeting = $request->getBool('videotargetting', (bool) $wgAdVideoTargeting);

		$wgEnableRHonDesktop = $request->getBool( 'noremnant', $wgEnableRHonDesktop );

		$wgAdDriverForceDirectGptAd = $request->getBool('forcedirectgpt', $wgAdDriverForceDirectGptAd);
		$wgAdDriverForceLiftiumAd = $request->getBool('forceliftium', $wgAdDriverForceLiftiumAd);
		$wgAdPageType = AdEngine2Service::getPageType();

		$wgLoadAdsInHead = $request->getBool('adsinhead', $wgLoadAdsInHead);

		$wgEnableKruxTargeting = !$wgNoExternals && $wgEnableKruxTargeting;

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
		foreach (AdEngine2Service::getBottomJsVariables() as $varName => $varValue) {
			$vars[$varName] = $varValue;
		}
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
		foreach (AdEngine2Service::getTopJsVariables() as $varName => $varValue) {
			$vars[$varName] = $varValue;
		}
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

	/**
	 * Add the resource loader modules needed for AdEngine to work.
	 *
	 * Note the dependency resolver does not work at this time, so we need to add every
	 * module needed including their dependencies.
	 *
	 * @param $scriptModules
	 * @param $skin
	 * @return bool
	 */
	static public function onWikiaSkinTopModules(&$scriptModules, $skin) {
		if (AdEngine2Service::areAdsInHead() || AnalyticsProviderAmazonDirectTargetedBuy::isEnabled()) {
			$scriptModules[] = 'wikia.instantGlobals';
			$scriptModules[] = 'wikia.cookies';
			$scriptModules[] = 'wikia.geo';
			$scriptModules[] = 'wikia.window';
		}
		if (AdEngine2Service::areAdsInHead()) {
			$scriptModules[] = 'wikia.document';
			$scriptModules[] = 'wikia.abTest';
			$scriptModules[] = 'wikia.cache';
			$scriptModules[] = 'wikia.localStorage';
			$scriptModules[] = 'wikia.location';
			$scriptModules[] = 'wikia.log';
			$scriptModules[] = 'wikia.querystring';
			$scriptModules[] = 'wikia.tracker';
		}
		return true;
	}
}
