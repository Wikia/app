<?php
/**
 * AdEngine II Hooks
 */
class AdEngine2Hooks {
	const ASSET_GROUP_CORE = 'oasis_shared_core_js';
	const ASSET_GROUP_ADENGINE = 'adengine2_js';
	const ASSET_GROUP_VENUS_ADS = 'adengine2_venus_ads_js';
	const ASSET_GROUP_OASIS_ADS = 'adengine2_oasis_ads_js';
	const ASSET_GROUP_ADENGINE_AMAZON_MATCH = 'adengine2_amazon_match_js';
	const ASSET_GROUP_ADENGINE_INTERSTITIAL = 'adengine2_interstitial_js';
	const ASSET_GROUP_ADENGINE_MOBILE = 'wikiamobile_ads_js';
	const ASSET_GROUP_ADENGINE_LATE = 'adengine2_late_js';
	const ASSET_GROUP_ADENGINE_RUBICON_RTP = 'adengine2_rubicon_rtp_js';
	const ASSET_GROUP_ADENGINE_TABOOLA = 'adengine2_taboola_js';
	const ASSET_GROUP_ADENGINE_TRACKING = 'adengine2_tracking_js';
	const ASSET_GROUP_LIFTIUM = 'liftium_ads_js';
	const ASSET_GROUP_LIFTIUM_EXTRA = 'liftium_ads_extra_js';

	/**
	 * Handle URL parameters and set proper global variables early enough
	 *
	 * @author Sergey Naumov
	 */
	public static function onAfterInitialize( $title, $article, $output, $user, WebRequest $request, $wiki ) {

		// TODO: review top and bottom vars (important for adsinhead)

		global $wgAdDriverForceDirectGptAd, $wgAdDriverForceLiftiumAd, $wgAdDriverUseInterstitial,
			   $wgLiftiumOnLoad, $wgNoExternals, $wgEnableKruxTargeting,
			   $wgAdEngineDisableLateQueue, $wgLoadAdsInHead, $wgLoadLateAdsAfterPageLoad,
			   $wgEnableKruxOnMobile, $wgAdDriverForceTurtleAd;

		$wgNoExternals = $request->getBool( 'noexternals', $wgNoExternals );
		$wgLiftiumOnLoad = $request->getBool( 'liftiumonload', (bool)$wgLiftiumOnLoad );

		$wgAdEngineDisableLateQueue = $request->getBool( 'noremnant', $wgAdEngineDisableLateQueue );

		$wgAdDriverForceDirectGptAd = $request->getBool( 'forcedirectgpt', $wgAdDriverForceDirectGptAd );
		$wgAdDriverForceLiftiumAd = $request->getBool( 'forceliftium', $wgAdDriverForceLiftiumAd );
		$wgAdDriverForceTurtleAd = $request->getBool( 'forceturtle', $wgAdDriverForceTurtleAd );
		$wgAdDriverUseInterstitial = $request->getBool( 'interstitial', $wgAdDriverUseInterstitial );

		$wgLoadAdsInHead = $request->getBool( 'adsinhead', $wgLoadAdsInHead );
		$wgLoadLateAdsAfterPageLoad = $request->getBool( 'lateadsafterload', $wgLoadLateAdsAfterPageLoad );

		$wgEnableKruxTargeting = !$wgAdEngineDisableLateQueue && !$wgNoExternals && $wgEnableKruxTargeting;
		$wgEnableKruxOnMobile = $request->getBool( 'enablekrux', $wgEnableKruxOnMobile && !$wgNoExternals );

		return true;
	}

	/**
	 * Register "instant" global JS
	 *
	 * @param array $vars
	 *
	 * @return bool
	 */
	public static function onInstantGlobalsGetVariables( array &$vars )
	{
		$vars[] = 'wgAdDriverAlwaysCallDartInCountries';
		$vars[] = 'wgAdDriverAlwaysCallDartInCountriesMobile';

		$vars[] = 'wgAmazonMatchCountries';
		$vars[] = 'wgAmazonMatchOldCountries';
		$vars[] = 'wgHighValueCountries';
		$vars[] = 'wgAdDriverTurtleCountries';

		/**
		 * Disaster Recovery
		 * @link https://one.wikia-inc.com/wiki/Ads/Disaster_recovery
		 */
		$vars[] = 'wgSitewideDisableGpt';
		$vars[] = 'wgSitewideDisableKrux';
		$vars[] = 'wgSitewideDisableLiftium';
		$vars[] = 'wgSitewideDisableRubiconRTP';
		$vars[] = 'wgSitewideDisableSevenOneMedia';

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
		$wg = F::app()->wg;
		$title = $wg->Title;
		$skin = RequestContext::getMain()->getSkin();
		$skinName = $skin->getSkinName();

		$adContext = ( new AdEngine2ContextService() )->getContext( $title, $skinName );

		$vars['ads'] = ['context' => $adContext];

		// Legacy vars:
		$vars['adslots2'] = [];                  // Queue for ads registration
		$vars['adDriverLastDARTCallNoAds'] = []; // Used to hop by DART ads
		$vars['adDriver2ForcedStatus'] = [];     // 3rd party code (eg. dart collapse slot template) can force AdDriver2 to respect unusual slot status

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

		global $wgAdDriverUseInterstitial, $wgAdDriverUseBottomLeaderboard,
			$wgAdDriverUseTopInContentBoxad, $wgAdDriverUseTaboola;

		$coreGroupIndex = array_search( self::ASSET_GROUP_CORE, $jsAssets );
		if ( $coreGroupIndex === false ) {
			// Do nothing. oasis_shared_core_js must be present for ads to work
			return true;
		}

		if ( AdEngine2Service::areAdsInHead() ) {
			if ( AdEngine2Service::shouldLoadLateQueue() ) {
				array_splice( $jsAssets, $coreGroupIndex + 1, 0, self::ASSET_GROUP_ADENGINE_LATE );
			}
			// The ASSET_GROUP_ADENGINE_LATE package was added to the blocking group
		} else {
			array_splice( $jsAssets, $coreGroupIndex + 1, 0, self::ASSET_GROUP_ADENGINE );
			if ( AdEngine2Service::shouldLoadLateQueue() ) {
				array_splice( $jsAssets, $coreGroupIndex + 2, 0, self::ASSET_GROUP_ADENGINE_LATE );
			}
		}

		if ( AdEngine2Service::shouldLoadLiftium() ) {
			$jsAssets[] = self::ASSET_GROUP_LIFTIUM;
			$jsAssets[] = self::ASSET_GROUP_LIFTIUM_EXTRA;
		}

		if ( $wgAdDriverUseInterstitial === true ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_INTERSTITIAL;
		}

		if ( $wgAdDriverUseTopInContentBoxad ) {
			$jsAssets[] = self::ASSET_GROUP_OASIS_ADS;
		}

		if ( $wgAdDriverUseBottomLeaderboard === true ) {
			$jsAssets[] = 'adengine2_bottom_leaderboard_js';
		}

		if ( $wgAdDriverUseTaboola === true ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_TABOOLA;
		}

		$jsAssets[] = 'adengine2_interactive_maps_js';

		return true;
	}

	/**
	 * Modify assets appended to the top of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroupsBlocking( &$jsAssets ) {

		// Tracking should be available very early, so we can track how lookup calls (Amazon, Rubicon) perform
		$jsAssets[] = self::ASSET_GROUP_ADENGINE_TRACKING;

		if ( AdEngine2Service::areAdsInHead() ) {
			// Add ad asset to JavaScripts loaded on top (in <head>)
			$jsAssets[] = self::ASSET_GROUP_ADENGINE;
		}

		if ( AnalyticsProviderRubiconRTP::isEnabled() ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_RUBICON_RTP;
		}

		if ( AnalyticsProviderAmazonMatch::isEnabled() ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_AMAZON_MATCH;
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
		$scriptModules[] = 'wikia.localStorage';
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
	 * Note the dependency resolver does not work at this time, so we need to add every
	 * module needed including their dependencies.
	 *
	 * @static
	 * @param $jsStaticPackages
	 * @param $jsExtensionPackages
	 * @param $scssPackages
	 * @return bool
	 */
	public static function onWikiaMobileAssetsPackages( array &$jsStaticPackages, array &$jsExtensionPackages, array &$scssPackages ) {

		global $wgAdDriverUseTaboola;

		$coreGroupIndex = array_search( self::ASSET_GROUP_ADENGINE_MOBILE, $jsStaticPackages );

		if ( $coreGroupIndex === false ) {
			// Do nothing. ASSET_GROUP_ADENGINE_MOBILE must be present for ads to work
			return true;
		}

		if ( $wgAdDriverUseTaboola === true ) {
			array_splice( $jsStaticPackages, $coreGroupIndex, 0, self::ASSET_GROUP_ADENGINE_TABOOLA );
		}

		return true;
	}

	public static function onSkinAfterContent( &$text ) {
		global $wgTitle, $wgAdDriverUseTaboola;

		if ( !$wgAdDriverUseTaboola ) {
			return true;
		}

		$skin = RequestContext::getMain()->getSkin()->getSkinName();

		// File pages handle their own rendering of related pages wrapper
		if ( ( $skin === 'oasis' ) && $wgTitle->getNamespace() !== NS_FILE ) {
			$text = $text . F::app()->renderView( 'Ad', 'Index', ['slotName' => 'NATIVE_TABOOLA'] );
		}

		return true;
	}

	public static function onSkinAfterBottomScripts(Skin $skin, &$text) {
		// TODO: Check whether this works also on Oasis!
		if ($skin->getSkinName() === 'venus') {
			$text .= AdEngine2Controller::getLiftiumOptionsScript();
			$text .= Html::inlineScript( 'Liftium.init();' )."\n";
		}
		return true;
	}

	public static function onVenusAssetsPackages( array &$jsHeadGroups, array &$jsBodyGroups, array &$cssGroups ) {
		$jsHeadGroups[] = self::ASSET_GROUP_ADENGINE_TRACKING;
		$jsHeadGroups[] = self::ASSET_GROUP_ADENGINE;
		$jsHeadGroups[] = self::ASSET_GROUP_VENUS_ADS;

		if ( AnalyticsProviderRubiconRTP::isEnabled() ) {
			$jsHeadGroups[] = self::ASSET_GROUP_ADENGINE_RUBICON_RTP;
		}

		if ( AnalyticsProviderAmazonMatch::isEnabled() ) {
			$jsHeadGroups[] = self::ASSET_GROUP_ADENGINE_AMAZON_MATCH;
		}

		if ( AdEngine2Service::shouldLoadLateQueue() ) {
			$jsBodyGroups[] = self::ASSET_GROUP_ADENGINE_LATE;
		}
		if ( AdEngine2Service::shouldLoadLiftium() ) {
			$jsBodyGroups[] = self::ASSET_GROUP_LIFTIUM;
		}
		return true;
	}
}
