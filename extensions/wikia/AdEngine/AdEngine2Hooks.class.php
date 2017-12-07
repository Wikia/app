<?php

/**
 * AdEngine II Hooks
 */
class AdEngine2Hooks {
	const ASSET_GROUP_ADENGINE_A9 = 'adengine2_a9_js';
	const ASSET_GROUP_ADENGINE_DESKTOP = 'adengine2_desktop_js';
	const ASSET_GROUP_ADENGINE_MOBILE = 'wikiamobile_ads_js';
	const ASSET_GROUP_ADENGINE_PREBID = 'adengine2_pr3b1d_js';
	const ASSET_GROUP_ADENGINE_TOP = 'adengine2_top_js';

	/**
	 * Handle URL parameters and set proper global variables early enough
	 *
	 * @author Sergey Naumov
	 */
	public static function onAfterInitialize( $title, $article, $output, $user, WebRequest $request, $wiki ) {
		global $wgNoExternals;

		// TODO: we shouldn't have it in AdEngine - ticket for Platform: PLATFORM-1296
		$wgNoExternals = $request->getBool( 'noexternals', $wgNoExternals );

		return true;
	}

	/**
	 * Register "instant" global JS
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	public static function onInstantGlobalsGetVariables( array &$vars ) {
		$vars[] = 'wgAdDriverAbTestIdTargeting';
		$vars[] = 'wgAdDriverAdProductsBridgeCountries';
		$vars[] = 'wgAdDriverAdProductsBridgeMobileCountries';
		$vars[] = 'wgAdDriverAolBidderCountries';
		$vars[] = 'wgAdDriverAolOneMobileBidderCountries';
		$vars[] = 'wgAdDriverAppNexusAstBidderCountries';
		$vars[] = 'wgAdDriverAppNexusBidderCountries';
		$vars[] = 'wgAdDriverAudienceNetworkBidderCountries';
		$vars[] = 'wgAdDriverA9BidderCountries';
		$vars[] = 'wgAdDriverA9VideoBidderCountries';
		$vars[] = 'wgAdDriverDelayCountries';
		$vars[] = 'wgAdDriverDelayTimeout';
		$vars[] = 'wgAdDriverDisableSraCountries';
		$vars[] = 'wgAdDriverEvolve2Countries';
		$vars[] = 'wgAdDriverFMRLogisticRegressionRabbitCountries';
		$vars[] = 'wgAdDriverFMRPassiveAggressiveClassifierRabbitCountries';
		$vars[] = 'wgAdDriverFVMidrollCountries';
		$vars[] = 'wgAdDriverFVPostrollCountries';
		$vars[] = 'wgAdDriverHighImpactSlotCountries';
		$vars[] = 'wgAdDriverHighImpact2SlotCountries';
		$vars[] = 'wgAdDriverIncontentPlayerSlotCountries';
		$vars[] = 'wgAdDriverIndexExchangeBidderCountries';
		$vars[] = 'wgAdDriverKikimoraPlayerTrackingCountries';
		$vars[] = 'wgAdDriverKikimoraTrackingCountries';
		$vars[] = 'wgAdDriverKikimoraViewabilityTrackingCountries';
		$vars[] = 'wgAdDriverKruxCountries';
		$vars[] = 'wgAdDriverKILOCountries';
		$vars[] = 'wgAdDriverLBScrollExperimentCountires';
		$vars[] = 'wgAdDriverLBScrollExperimentBucket';
		$vars[] = 'wgAdDriverMEGACountries';
		$vars[] = 'wgAdDriverMegaAdUnitBuilderForFVCountries';
		$vars[] = 'wgAdDriverMoatTrackingForFeaturedVideoAdCountries';
		$vars[] = 'wgAdDriverMoatTrackingForFeaturedVideoAdSampling';
		$vars[] = 'wgAdDriverNetzAthletenCountries';
		$vars[] = 'wgAdDriverOpenXPrebidBidderCountries';
		$vars[] = 'wgAdDriverOutstreamVideoFrequencyCapping';
		$vars[] = 'wgAdDriverPageFairDetectionCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextFVCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextFVFrequency';
		$vars[] = 'wgAdDriverPorvataMoatTrackingCountries';
		$vars[] = 'wgAdDriverPorvataMoatTrackingSampling';
		$vars[] = 'wgAdDriverPrebidBidderCountries';
		$vars[] = 'wgAdDriverPubMaticBidderCountries';
		$vars[] = 'wgAdDriverRubiconDisplayPrebidCountries';
		$vars[] = 'wgAdDriverRubiconPrebidCountries';
		$vars[] = 'wgAdDriverSourcePointDetectionCountries';
		$vars[] = 'wgAdDriverSourcePointDetectionMobileCountries';
		$vars[] = 'wgAdDriverSrcPremiumCountries';
		$vars[] = 'wgAdDriverTurtleCountries';
		$vars[] = 'wgPorvataVastLoggerConfig';

		/**
		 * Disaster Recovery
		 * @link https://wikia-inc.atlassian.net/wiki/display/ADEN/Disaster+Recovery
		 */
		$vars[] = 'wgSitewideDisableGpt';
		$vars[] = 'wgSitewideDisableKrux';

		return true;
	}

	/**
	 * Register "instant" global JS
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	public static function onInstantGlobalsGetNewsAndStoriesVariables( array &$vars ) {
		// shared variables with communities
		$vars[] = 'wgAdDriverKikimoraPlayerTrackingCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextVideoCountries';
		$vars[] = 'wgAdDriverPlayAdsOnNextVideoFrequency';
		$vars[] = 'wgAdDriverPorvataMoatTrackingCountries';
		$vars[] = 'wgAdDriverPorvataMoatTrackingSampling';
		$vars[] = 'wgAdDriverVideoMidrollCountries';
		$vars[] = 'wgAdDriverVideoMoatTrackingCountries';
		$vars[] = 'wgAdDriverVideoMoatTrackingSampling';
		$vars[] = 'wgAdDriverVideoPostrollCountries';

		// TODO: Remove after src=[gpt,ns] is finished
		$vars[] = 'wgAdDriverNewsAndStoriesSingleSrcKeyValueCountries';
		$vars[] = 'wgAdDriverNewsAndStoriesSrcKeyValueCountries';

		// news&stories variables only
		$vars[] = 'wgAdDriverF2InstartLogicRecoveryCountries';
		$vars[] = 'wgAdDriverF2MEGAVideosCountries';
		$vars[] = 'wgAdDriverF2OoyalaPosKeyValueCountries';

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
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgTitle;

		$skin = RequestContext::getMain()->getSkin();
		$skinName = $skin->getSkinName();

		$adContext = ( new AdEngine2ContextService() )->getContext( $wgTitle, $skinName );

		$vars['ads'] = [
			'context' => $adContext,
			'runtime' => [
				'disableBtf' => false,
			],
		];

		// Legacy vars:
		// Queue for ads registration
		$vars['adslots2'] = [ ];
		// Used to hop by DART ads
		$vars['adDriverLastDARTCallNoAds'] = [ ];
		// 3rd party code (eg. dart collapse slot template) can force AdDriver2 to respect unusual slot status
		$vars['adDriver2ForcedStatus'] = [ ];

		// GA vars
		$vars['wgGaHasAds'] = isset($adContext['opts']['showAds']);

		return true;
	}

	/**
	 * Modify assets appended to the bottom of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		$jsAssets[] = static::ASSET_GROUP_ADENGINE_DESKTOP;

		return true;
	}

	/**
	 * Modify assets appended to the top of the page: add lookup services
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroupsBlocking( &$jsAssets ) {

		// Tracking should be available very early, so we can track how lookup calls perform
		$jsAssets[] = static::ASSET_GROUP_ADENGINE_TOP;

		if ( AnalyticsProviderA9::isEnabled() ) {
			$jsAssets[] = static::ASSET_GROUP_ADENGINE_A9;
		}

		if ( AnalyticsProviderPrebid::isEnabled() ) {
			$jsAssets[] = static::ASSET_GROUP_ADENGINE_PREBID;
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
	public static function onWikiaSkinTopModules( &$scriptModules, $skin ) {
		$scriptModules[] = 'wikia.abTest';
		$scriptModules[] = 'wikia.cache';
		$scriptModules[] = 'wikia.cookies';
		$scriptModules[] = 'wikia.document';
		$scriptModules[] = 'wikia.geo';
		$scriptModules[] = 'wikia.instantGlobals';
		$scriptModules[] = 'wikia.location';
		$scriptModules[] = 'wikia.log';
		$scriptModules[] = 'wikia.querystring';
		$scriptModules[] = 'wikia.tracker.stub';
		$scriptModules[] = 'wikia.window';
		return true;
	}

	/**
	 * Modify assets appended to the bottom of wikiaMobileSkin
	 *
	 * @static
	 * @param $jsStaticPackages
	 * @param $jsExtensionPackages
	 * @param $scssPackages
	 * @return bool
	 */
	public static function onWikiaMobileAssetsPackages( array &$jsStaticPackages, array &$jsExtensionPackages, array &$scssPackages ) {
		$coreGroupIndex = array_search( static::ASSET_GROUP_ADENGINE_MOBILE, $jsStaticPackages );

		if ( $coreGroupIndex === false ) {
			// Do nothing. ASSET_GROUP_ADENGINE_MOBILE must be present for ads to work
			return true;
		}

		return true;
	}

}
