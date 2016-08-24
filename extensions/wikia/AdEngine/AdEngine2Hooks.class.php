<?php
/**
 * AdEngine II Hooks
 */
class AdEngine2Hooks {
	const ASSET_GROUP_ADENGINE_AMAZON_MATCH = 'adengine2_amazon_match_js';
	const ASSET_GROUP_ADENGINE_DESKTOP = 'adengine2_desktop_js';
	const ASSET_GROUP_ADENGINE_GCS = 'adengine2_gcs_js';
	const ASSET_GROUP_ADENGINE_MOBILE = 'wikiamobile_ads_js';
	const ASSET_GROUP_ADENGINE_OPENX_BIDDER = 'adengine2_ox_bidder_js';
	const ASSET_GROUP_ADENGINE_PREBID = 'adengine2_prebid_js';
	const ASSET_GROUP_ADENGINE_REVCONTENT = 'adengine2_revcontent_js';
	const ASSET_GROUP_ADENGINE_RUBICON_FASTLANE = 'adengine2_rubicon_fastlane_js';
	const ASSET_GROUP_ADENGINE_TABOOLA = 'adengine2_taboola_js';
	const ASSET_GROUP_ADENGINE_TRACKING = 'adengine2_tracking_js';

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
	public static function onInstantGlobalsGetVariables( array &$vars )
	{
		$vars[] = 'wgAdDriverAdsRecoveryMessageCountries';
		$vars[] = 'wgAdDriverDelayCountries';
		$vars[] = 'wgAdDriverDelayTimeout';
		$vars[] = 'wgAdDriverEvolve2Countries';
		$vars[] = 'wgAdDriverGoogleConsumerSurveysCountries';
		$vars[] = 'wgAdDriverHighImpactSlotCountries';
		$vars[] = 'wgAdDriverHighImpact2SlotCountries';
		$vars[] = 'wgAdDriverMobileTransitionInterstitialCountries';
		$vars[] = 'wgAdDriverIncontentLeaderboardSlotCountries';
		$vars[] = 'wgAdDriverIncontentLeaderboardOutOfPageSlotCountries';
		$vars[] = 'wgAdDriverIncontentPlayerSlotCountries';
		$vars[] = 'wgAdDriverKruxCountries';
		$vars[] = 'wgAdDriverOpenXBidderCountries';
		$vars[] = 'wgAdDriverPrebidBidderCountries';
		$vars[] = 'wgAdDriverAppNexusBidderCountries';
		$vars[] = 'wgAdDriverIndexBidderCountries';
		$vars[] = 'wgAdDriverOpenXBidderCountriesRemnant';
		$vars[] = 'wgAdDriverOverridePrefootersCountries';
		$vars[] = 'wgAdDriverPageFairDetectionCountries';
		$vars[] = 'wgAdDriverRevcontentCountries';
		$vars[] = 'wgAdDriverRubiconFastlaneCountries';
		$vars[] = 'wgAdDriverRubiconFastlaneProviderCountries';
		$vars[] = 'wgAdDriverRubiconFastlaneProviderSkipTier';
		$vars[] = 'wgAdDriverScrollHandlerConfig';
		$vars[] = 'wgAdDriverScrollHandlerCountries';
		$vars[] = 'wgAdDriverSourcePointDetectionCountries';
		$vars[] = 'wgAdDriverSourcePointDetectionMobileCountries';
		$vars[] = 'wgAdDriverSourcePointRecoveryCountries';
		$vars[] = 'wgAdDriverTaboolaConfig';
		$vars[] = 'wgAdDriverTurtleCountries';
		$vars[] = 'wgAdDriverYavliCountries';
		$vars[] = 'wgAmazonMatchCountries';
		$vars[] = 'wgAmazonMatchCountriesMobile';

		/**
		 * Disaster Recovery
		 * @link https://one.wikia-inc.com/wiki/Ads/Disaster_recovery
		 */
		$vars[] = 'wgSitewideDisableGpt';
		$vars[] = 'wgSitewideDisableKrux';
		$vars[] = 'wgSitewideDisableMonetizationService';
		$vars[] = 'wgSitewideDisableSevenOneMedia'; // TODO: ADEN-3314

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
		$vars['adslots2'] = [];                  // Queue for ads registration
		$vars['adDriverLastDARTCallNoAds'] = []; // Used to hop by DART ads
		$vars['adDriver2ForcedStatus'] = [];     // 3rd party code (eg. dart collapse slot template) can force AdDriver2 to respect unusual slot status

		// GA vars
		$vars['wgGaHasAds'] = isset( $adContext['opts']['showAds'] );

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

		global $wgAdDriverUseGoogleConsumerSurveys, $wgAdDriverUseTaboola, $wgAdDriverUseRevcontent;
		$isArticle = WikiaPageType::getPageType() === 'article';

		$jsAssets[] = self::ASSET_GROUP_ADENGINE_DESKTOP;

		if ( $wgAdDriverUseGoogleConsumerSurveys && $isArticle ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_GCS;
		}

		if ( $wgAdDriverUseTaboola && $isArticle ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_TABOOLA;
		}

		if ( $wgAdDriverUseRevcontent && $isArticle ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_REVCONTENT;
		}

		$jsAssets[] = 'adengine2_interactive_maps_js';

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
		$jsAssets[] = self::ASSET_GROUP_ADENGINE_TRACKING;

		if ( AnalyticsProviderAmazonMatch::isEnabled() ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_AMAZON_MATCH;
		}

		if ( AnalyticsProviderPrebid::isEnabled() ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_PREBID;
		}

		if ( AnalyticsProviderOpenXBidder::isEnabled() ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_OPENX_BIDDER;
		}

		if ( AnalyticsProviderRubiconFastlane::isEnabled() ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_RUBICON_FASTLANE;
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
			$text = $text . F::app()->renderView( 'AdEmptyContainer', 'Index', ['slotName' => 'NATIVE_TABOOLA_ARTICLE'] );
		}

		return true;
	}

}
