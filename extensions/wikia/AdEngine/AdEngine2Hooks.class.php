<?php
/**
 * AdEngine II Hooks
 */
class AdEngine2Hooks {
	const ASSET_GROUP_ADENGINE_DESKTOP = 'adengine2_desktop_js';
	const ASSET_GROUP_VENUS_ADS = 'adengine2_venus_ads_js';
	const ASSET_GROUP_OASIS_IN_CONTENT_ADS = 'adengine2_oasis_in_content_ads_js';
	const ASSET_GROUP_ADENGINE_AMAZON_MATCH = 'adengine2_amazon_match_js';
	const ASSET_GROUP_ADENGINE_MOBILE = 'wikiamobile_ads_js';
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
		global
			$wgAdDriverForceLiftiumAd,
			$wgAdDriverForceOpenXAd,
			$wgAdDriverForceTurtleAd,
			$wgAdDriverUseSevenOneMedia,
			$wgEnableKruxOnMobile,
			$wgEnableKruxTargeting,
			$wgLiftiumOnLoad,
			$wgNoExternals,
			$wgUsePostScribe;

		$wgNoExternals = $request->getBool( 'noexternals', $wgNoExternals );
		$wgLiftiumOnLoad = $request->getBool( 'liftiumonload', (bool)$wgLiftiumOnLoad );

		$wgAdDriverForceLiftiumAd = $request->getBool( 'forceliftium', $wgAdDriverForceLiftiumAd );
		$wgAdDriverForceOpenXAd = $request->getBool( 'forceopenx', $wgAdDriverForceOpenXAd );
		$wgAdDriverForceTurtleAd = $request->getBool( 'forceturtle', $wgAdDriverForceTurtleAd );

		$wgEnableKruxTargeting = !$wgNoExternals && $wgEnableKruxTargeting;
		$wgEnableKruxOnMobile = $request->getBool( 'enablekrux', $wgEnableKruxOnMobile && !$wgNoExternals );

		// use PostScribe with 71Media - check scriptwriter.js:35
		if ( $wgAdDriverUseSevenOneMedia ) {
			$wgUsePostScribe = true;
		}

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
		$vars[] = 'wgAdDriverIncontentPlayerSlotCountries';
		$vars[] = 'wgAdDriverTurtleCountries';
		$vars[] = 'wgAmazonMatchCountries';
		$vars[] = 'wgAmazonMatchCountriesMobile';
		$vars[] = 'wgAmazonMatchOldCountries';
		$vars[] = 'wgHighValueCountries'; // Used by Liftium only
		$vars[] = 'wgAdDriverOpenXCountries';
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
		global $wgTitle, $wgUsePostScribe;
		$skin = RequestContext::getMain()->getSkin();
		$skinName = $skin->getSkinName();

		$adContext = ( new AdEngine2ContextService() )->getContext( $wgTitle, $skinName );

		$vars['ads'] = ['context' => $adContext];

		// Legacy vars:
		$vars['adslots2'] = [];                  // Queue for ads registration
		$vars['adDriverLastDARTCallNoAds'] = []; // Used to hop by DART ads
		$vars['adDriver2ForcedStatus'] = [];     // 3rd party code (eg. dart collapse slot template) can force AdDriver2 to respect unusual slot status

		// GA vars
		$vars['wgGaHasAds'] = isset( $adContext['opts']['showAds'] );

		// 71Media
		$vars['wgUsePostScribe'] = $wgUsePostScribe;

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

		global $wgAdDriverUseTopInContentBoxad, $wgAdDriverUseTaboola;

		$jsAssets[] = self::ASSET_GROUP_ADENGINE_DESKTOP;

		if ( AdEngine2Service::shouldLoadLiftium() ) {
			$jsAssets[] = self::ASSET_GROUP_LIFTIUM;
			$jsAssets[] = self::ASSET_GROUP_LIFTIUM_EXTRA;
		}

		if ( $wgAdDriverUseTopInContentBoxad ) {
			$jsAssets[] = self::ASSET_GROUP_OASIS_IN_CONTENT_ADS;
		}

		if ( $wgAdDriverUseTaboola === true ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_TABOOLA;
		}

		$jsAssets[] = 'adengine2_interactive_maps_js';

		return true;
	}

	/**
	 * Modify assets appended to the top of the page: add RubiconRtp and AmazonMatch lookup services
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroupsBlocking( &$jsAssets ) {

		// Tracking should be available very early, so we can track how lookup calls (Amazon, Rubicon) perform
		$jsAssets[] = self::ASSET_GROUP_ADENGINE_TRACKING;

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

	public static function onSkinAfterBottomScripts( Skin $skin, &$text ) {
		// TODO: Check whether this works also on Oasis!
		if ( $skin->getSkinName() === 'venus' ) {
			$text .= AdEngine2Controller::getLiftiumOptionsScript();
			$text .= Html::inlineScript( 'Liftium.init();' ) . "\n";
		}
		return true;
	}

	public static function onVenusAssetsPackages( array &$jsHeadGroups, array &$jsBodyGroups, array &$cssGroups ) {
		$jsHeadGroups[] = self::ASSET_GROUP_ADENGINE_TRACKING;
		$jsHeadGroups[] = self::ASSET_GROUP_ADENGINE_DESKTOP;
		$jsHeadGroups[] = self::ASSET_GROUP_VENUS_ADS;

		if ( AnalyticsProviderRubiconRTP::isEnabled() ) {
			$jsHeadGroups[] = self::ASSET_GROUP_ADENGINE_RUBICON_RTP;
		}

		if ( AnalyticsProviderAmazonMatch::isEnabled() ) {
			$jsHeadGroups[] = self::ASSET_GROUP_ADENGINE_AMAZON_MATCH;
		}

		if ( AdEngine2Service::shouldLoadLiftium() ) {
			$jsBodyGroups[] = self::ASSET_GROUP_LIFTIUM;
		}
		return true;
	}
}
