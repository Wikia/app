<?php
/**
 * AdEngine II Hooks
 */
class AdEngine2Hooks {
	const ASSET_GROUP_ADENGINE_DESKTOP = 'adengine2_desktop_js';
	const ASSET_GROUP_OASIS_IN_CONTENT_ADS = 'adengine2_oasis_in_content_ads_js';
	const ASSET_GROUP_ADENGINE_AMAZON_MATCH = 'adengine2_amazon_match_js';
	const ASSET_GROUP_ADENGINE_OPENX_BIDDER = 'adengine2_ox_bidder_js';
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
		global $wgAdDriverUseSevenOneMedia,
			$wgNoExternals,
			$wgUsePostScribe;

		// TODO: we shouldn't have it in AdEngine - ticket for Platform: PLATFORM-1296
		$wgNoExternals = $request->getBool( 'noexternals', $wgNoExternals );

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
		$vars[] = 'wgAdDriverAdsRecoveryMessageCountries';
		$vars[] = 'wgAdDriverHighImpactSlotCountries';
		$vars[] = 'wgAdDriverIncontentPlayerSlotCountries';
		$vars[] = 'wgAdDriverKruxCountries';
		$vars[] = 'wgAdDriverOpenXBidderCountries';
		$vars[] = 'wgAdDriverOpenXBidderCountriesMobile';
		$vars[] = 'wgAdDriverSourcePointCountries'; // @TODO ADEN-2578 - cleanup
		$vars[] = 'wgAdDriverSourcePointDetectionCountries';
		$vars[] = 'wgAdDriverSourcePointDetectionMobileCountries';
		$vars[] = 'wgAdDriverSourcePointRecoveryCountries';
		$vars[] = 'wgAdDriverScrollHandlerConfig';
		$vars[] = 'wgAdDriverScrollHandlerCountries';
		$vars[] = 'wgAdDriverTurtleCountries';
		$vars[] = 'wgAmazonMatchCountries';
		$vars[] = 'wgAmazonMatchCountriesMobile';
		$vars[] = 'wgHighValueCountries'; // Used by Liftium only

		/**
		 * Disaster Recovery
		 * @link https://one.wikia-inc.com/wiki/Ads/Disaster_recovery
		 */
		$vars[] = 'wgSitewideDisableGpt';
		$vars[] = 'wgSitewideDisableKrux';
		$vars[] = 'wgSitewideDisableLiftium';
		$vars[] = 'wgSitewideDisableMonetizationService';
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

		$vars['ads'] = [
			'context' => $adContext,
			'runtime' => [
				'sp' => []
			],
		];

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

		if ( AnalyticsProviderOpenXBidder::isEnabled() ) {
			$jsAssets[] = self::ASSET_GROUP_ADENGINE_OPENX_BIDDER;
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

	public static function onSkinAfterBottomScripts( $skin, &$bottomScriptsText ) {
		/* ADEN-2592 not meant for production START */
		$bottomScriptsText .= <<<CODE
<script src=“//www.changetip.com/public/changepay/changePay-sdk.js"></script>

<style>
.changepay-modal-inner {
    background: #005098;
    border: 4px solid #0b2443;
    color: #fff;
    text-align: center;
}
.changepay-modal header {
    background: #0b2443;
    margin: -20px -20px 0;
    padding: 10px;
}
.changepay-modal .changepay-close {
    display: none;
}
.changepay-modal a,
.changepay-modal a:hover,
.changepay-modal a:active {
    color: #fff;
}

.changepay-modal .muted {
    color: #7ca8cc;
}
.changepay-modal .changepay-facebook,
.changepay-modal .changepay-facebook:hover,
.changepay-modal .changepay-facebook:active {
    background: #fff;
    color: #005098;
    display: inline-block;
    margin-top: 20px;
    padding: 5px;
}
.changepay-alert a {
    text-decoration: underline;
}
.changepay-message .changepay-close {
    text-decoration: none;
}
</style>

<svg viewBox="0 0 430 42">
<defs>
<g id="changepay-wikia" fill="white">
<polygon points="364.3,33 364.3,0 371.7,0 371.7,18.5 373.7,16 377.9,11.1 388.4,11.1 379.7,19.7 388.9,33 379.3,33 374.3,24.6 371.7,27.1 371.7,33"/>
<polygon points="337,11.2 334.2,26 330.6,11.2 327.3,11.2 327.1,11.2 325.6,11.2 325.4,11.2 322,11.2 318.4,26 315.6,11.2 307.9,11.2 313.6,32.9 323.5,32.9 326.3,21.5 329.1,32.9 339,32.9 344.7,11.2"/>
<path d="M429.6,17.4l0.4-6.3h-6.8l-0.5,2.3c-1.6-1.6-3.5-3-6.9-3c-6.2,0-9.5,4-9.5,11.6c0,7.6,3.4,11.6,9.5,11.6c3.4,0,5.3-1.4,6.9-3l0.5,2.3h6.8l-0.4-6.3V17.4L429.6,17.4z M422.2,24.8c-0.9,1.2-2.4,2.1-4.4,2.1c-2.2,0-4-1.4-4-4.9s1.8-4.9,4-4.9c1.9,0,3.4,0.8,4.4,2.1V24.8z"/>
<path d="M352.7,0.1c-2.3,0-4.2,1.9-4.2,4.2s1.9,4.2,4.2,4.2c2.3,0,4.2-1.9,4.2-4.2S355,0.1,352.7,0.1z"/>
<polygon points="359.1,15.6 359.1,11 355.8,11 348.4,11 348.4,18.5 348.4,25.5 348.4,32.8 348.4,33 359.1,33 359.1,28.4 355.7,28.4 355.7,15.6"/>
<path d="M398.3,0.1c2.3,0,4.2,1.9,4.2,4.2s-1.9,4.2-4.2,4.2c-2.3,0-4.2-1.9-4.2-4.2C394.1,2,396,0.1,398.3,0.1z"/>
<polygon points="391.9,15.6 391.9,11 395.1,11 402.6,11 402.6,18.5 402.6,25.5 402.6,32.8 402.6,33 391.9,33 391.9,28.4
395.2,28.4 395.2,15.6"/>
<path d="M285,32.4c-1.5,0.8-3.2,1.2-5,1.2c-1.3,0-2.5-0.2-3.6-0.6c-1.1-0.4-2.1-0.9-2.9-1.6c-0.8-0.7-1.5-1.6-1.9-2.6s-0.7-2.3-0.7-3.7c0-1.1,0.2-2.1,0.7-3c0.5-0.9,1-1.7,1.8-2.5c0.7-0.7,1.5-1.4,2.4-2s1.7-1.1,2.6-1.6c-0.4-0.5-0.9-1.1-1.3-1.6s-0.8-1.1-1.2-1.7s-0.7-1.2-0.9-1.9c-0.2-0.7-0.4-1.3-0.4-2.1c0-0.9,0.2-1.8,0.5-2.5c0.4-0.8,0.8-1.4,1.4-1.9c0.6-0.5,1.3-1,2.1-1.3c0.8-0.3,1.7-0.4,2.6-0.4c0.9,0,1.8,0.1,2.6,0.4c0.8,0.3,1.5,0.7,2.1,1.3c0.6,0.5,1.1,1.2,1.4,1.9c0.4,0.8,0.5,1.6,0.5,2.5c0,0.9-0.2,1.8-0.5,2.6s-0.8,1.5-1.3,2.1s-1.2,1.2-1.9,1.7c-0.7,0.5-1.4,1-2.2,1.5l6.6,8c0.4-0.7,0.6-1.5,0.7-2.2c0.1-0.8,0.2-1.7,0.2-2.9h2.7c0,0.9-0.1,1.9-0.4,3.3c-0.2,1.3-0.7,2.7-1.4,4l5.1,6.2h-3.4l-3.2-4C287.8,30.5,286.5,31.6,285,32.4z M277.5,19.3c-0.7,0.5-1.4,1-2,1.7c-0.6,0.6-1.1,1.3-1.4,2.1c-0.4,0.8-0.6,1.6-0.6,2.5c0,0.9,0.2,1.7,0.6,2.4c0.4,0.7,0.9,1.4,1.5,1.9c0.6,0.5,1.3,0.9,2.1,1.2c0.8,0.3,1.6,0.4,2.5,0.4c1.5,0,2.9-0.4,4.1-1.3c1.2-0.8,2.2-1.9,3.1-3.1l-7.6-9.2C279,18.3,278.2,18.8,277.5,19.3z M278.4,6c-0.8,0.7-1.2,1.6-1.2,2.9c0,0.5,0.1,1.1,0.3,1.6c0.2,0.6,0.5,1.1,0.9,1.6c0.3,0.5,0.7,1,1.1,1.5c0.4,0.5,0.8,0.9,1.1,1.3c0.5-0.3,1.1-0.7,1.6-1.1c0.6-0.4,1.1-0.8,1.5-1.3c0.5-0.5,0.8-1,1.1-1.7c0.3-0.6,0.4-1.3,0.4-2c0-1.3-0.4-2.2-1.2-2.9c-0.8-0.7-1.7-1-2.8-1S279.2,5.3,278.4,6z"/>
<path d="M73.7,33.3c-8.6,0-12.9-5.7-12.9-14.4c0-9,4.5-14.4,13.4-14.4c3.4,0,6.2,0.8,8.3,2.5c2,1.8,3.1,4.2,3.4,7.2h-3.5c-1.2,0-2.1-0.6-2.7-1.7c-0.9-2-2.8-3-5.5-3c-5.3,0-7.6,3.7-7.6,9.4c0,5.5,2.3,9.3,7.5,9.3c3.6,0,5.6-2,6.2-5.1h5.5C85.3,29.7,80.8,33.3,73.7,33.3z"/>
<path d="M98.4,15.7c-3.2,0-4.6,2.7-4.6,6v11.1h-5.5V5h2.8c1.8,0,2.7,0.9,2.7,2.8v6.5c2.8-3.2,6.2-4.1,10.3-2.7c3,1.1,4.5,4,4.3,8.8v12.6H103V21.8C103,18.1,101.6,15.7,98.4,15.7z"/>
<path d="M116.6,16.9h-5.5c0.7-4,3.5-6,8.5-6c6,0,9,2,9.2,6v7.4c0,6-3.6,8.7-9.5,9.1c-5.2,0.4-8.8-2-8.8-6.8c0.1-5.2,3.9-6.6,9.4-7.1c2.3-0.3,3.5-1,3.5-2.2c-0.1-1.2-1.3-1.8-3.5-1.8C117.9,15.3,116.9,15.8,116.6,16.9z M123.5,24v-2c-1.3,0.5-2.8,1-4.4,1.3c-2.2,0.4-3.3,1.4-3.3,3c0.1,1.7,1,2.5,2.8,2.5C121.6,28.9,123.5,27.1,123.5,24z"/>
<path d="M146.9,32.9c-1.8-0.1-2.7-1-2.7-2.7V19c-0.1-2.3-1.4-3.4-3.8-3.4c-2.4,0-3.7,1.1-3.7,3.4v13.9h-5.5V20.1c0-6.2,3.1-9.3,9.3-9.3c6.2,0,9.2,3.1,9.2,9.3v12.8H146.9z"/>
<path d="M151.6,22.1c0-7.2,3.4-10.8,10.1-11c6.8,0,10.2,3.2,10.2,9.7v12.9c0,5.5-3.5,8.2-10.4,8.3c-4.9,0-8.1-2.3-9.3-6.9h6c0.4,1.6,1.6,2.3,3.9,2.3c2.9,0,4.4-1.7,4.4-5.1c0,0,0,0,0-2.2c-1.4,2.1-3.5,3.2-6.2,3.2C154.4,33.3,151.6,29.6,151.6,22.1zM166.4,22.2c0-4.4-1.5-6.6-4.6-6.6s-4.6,2.2-4.6,6.6c0.1,4.2,1.6,6.3,4.6,6.3C164.7,28.5,166.3,26.4,166.4,22.2z"/>
<path d="M183.9,33.4c-6.6-0.2-9.9-4-9.9-11.4c0-7.4,3.3-11.1,9.9-11.1c6.9,0,10.1,4.2,9.7,12.7h-14.1c0.2,3.3,1.6,5,4.3,5c1.3,0,2.5-0.5,3.5-1.6c0.5-0.5,1.1-0.8,1.8-0.8h4C192.2,30.9,189.2,33.4,183.9,33.4z M179.7,19.7h8.2c-0.3-2.9-1.7-4.4-4-4.4C181.5,15.3,180.1,16.8,179.7,19.7z"/>
<path d="M208.8,23h-7.1v9.9H196V8c0-1.6,1.3-3,2.9-3h9.5c5.9,0,9,3.2,9,9C217.4,19.5,214.4,23,208.8,23z M207.3,17.9c2.9,0,4.3-1.3,4.3-4c0-2.7-1.4-4.1-4-4.1h-5.8v8.1H207.3z"/>
<path d="M224.1,16.9h-5.5c0.7-4,3.5-6,8.5-6c6,0,9,2,9.2,6v7.4c0,6-3.6,8.7-9.5,9.1c-5.2,0.4-8.8-2-8.8-6.8c0.1-5.2,3.9-6.6,9.4-7.1c2.3-0.3,3.5-1,3.5-2.2c-0.1-1.2-1.3-1.8-3.5-1.8C225.5,15.3,224.4,15.8,224.1,16.9z M231,24v-2c-1.3,0.5-2.8,1-4.4,1.3c-2.2,0.4-3.3,1.4-3.3,3c0.1,1.7,1,2.5,2.8,2.5C229.2,28.9,231,27.1,231,24z"/>
<path d="M241.3,36.8c3,0,4.1-1.5,3.2-4.4l-7.4-21.2h6.2l4.3,15.1l3.8-13.1c0.3-1.3,1.2-1.9,2.6-1.9h3.8l-8.6,25.4c-1.3,3.6-2.6,4.8-7.1,4.8c-1.4,0-2.1,0-2.3-0.2v-4.5H241.3z"/>
<path d="M22.5,17.4c-0.2-0.8-0.1-1.7,0.4-2.3c0.3-0.4,0.7-0.8,1.3-1.1l0,0c0,0,0.1,0,0.1,0l0-1c-0.5,0.1-1,0.2-1.5,0.4c-0.8,0.3-1.4,0.8-2,1.3c-0.6,0.6-1,1.3-1.4,2C19.2,17.4,19,18.2,19,19c0,0.8,0.2,1.6,0.5,2.4c0.3,0.8,0.8,1.4,1.3,2c0.6,0.6,1.3,1,2,1.4c0.5,0.2,0.9,0.3,1.5,0.4l0-0.7c-0.4-0.1-0.7-0.2-1.1-0.4c-0.4-0.2-0.8-0.6-1.1-1c-0.2-0.4-0.2-0.9,0.2-1.2c0.2-0.2,0.4-0.3,0.7-0.3c0.2,0,0.4,0.1,0.6,0.2c0.3,0.3,0.5,0.6,0.9,0.7c0.1,0.1,0.3,0.1,0.4,0.1l0.2,0c0.3,0,0.5-0.1,0.8-0.3c0.2-0.2,0.4-0.4,0.5-0.7c0.3-1.1-0.6-1.5-1.5-2C23.9,19.1,22.8,18.6,22.5,17.4z"/>
<path d="M50.1,8.4l-0.7-0.7l0.7-0.7c-2,0-3.7-1.7-3.7-3.7H3.7c0,2.1-1.7,3.7-3.7,3.7l0.7,0.7L0,8.4v0l0.7,0.7L0,9.9v0l0.7,0.7L0,11.3v0L0.7,12L0,12.7v0l0.7,0.7L0,14.1v0l0.7,0.7L0,15.5v0l0.7,0.7L0,16.9v0l0.7,0.7L0,18.3v0L0.7,19L0,19.7v0l0.7,0.7L0,21.1v0l0.7,0.7L0,22.5v0l0.7,0.7L0,23.9v0l0.7,0.7L0,25.3v0l0.7,0.7L0,26.8v0l0.7,0.7L0,28.2v0l0.7,0.7L0,29.6v0l0.7,0.7L0,31v0c2.1,0,3.7,1.7,3.7,3.7h42.6c0-2.1,1.7-3.7,3.7-3.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0L49.4,19l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7l0.7-0.7v0L49.4,12l0.7-0.7v0l-0.7-0.7l0.7-0.7v0l-0.7-0.7L50.1,8.4L50.1,8.4z M27.1,14.2c0.3,0.2,0.7,0.5,0.9,0.9c0.2,0.3,0.1,0.9-0.2,1.1c-0.4,0.3-0.8,0.4-1.2,0.1c-0.2-0.1-0.3-0.3-0.5-0.5c-0.3-0.3-0.9-0.2-1.2,0c-0.4,0.3-0.4,0.6-0.4,0.9c0,0.7,0.8,1.1,1.6,1.4c1.1,0.5,2,1,2.3,2.2c0.1,0.3,0.1,0.6,0.1,0.8c0,0.6-0.1,1.1-0.4,1.5c-0.3,0.7-0.9,1.2-1.6,1.5c-0.1,0.1-0.2,0.1-0.3,0.1l0,0.8c0.2,0,0.4-0.1,0.6-0.1c0.5-0.1,1-0.3,1.5-0.6c0.1-0.1,0.2-0.1,0.3-0.2c0.1,0,0.1-0.1,0.2-0.1l0,0l0.1-0.1c0.1-0.1,0.3-0.2,0.4-0.3c0.1-0.1,0.2-0.2,0.4-0.3c0.3-0.3,0.5-0.5,0.7-0.8c0.2-0.3,0.4-0.6,0.5-0.9l0.1-0.1l0.1,0l2.8,0l0.3,0l-0.1,0.3c-0.1,0.4-0.2,0.7-0.4,1c-0.1,0.3-0.3,0.5-0.4,0.8l0,0l-0.1,0.2c-0.1,0.2-0.3,0.5-0.5,0.7c-0.2,0.2-0.3,0.4-0.5,0.7l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0c-0.1,0.1-0.1,0.1-0.2,0.2c-0.1,0.1-0.1,0.1-0.2,0.2c-0.4,0.4-0.8,0.7-1.3,1.1c-0.4,0.3-0.9,0.6-1.4,0.8l-0.3,0.1l0,0c-0.5,0.2-1,0.4-1.6,0.5c-0.6,0.1-1.3,0.2-2,0.2c-1.3,0-2.5-0.3-3.5-0.7c-1.1-0.5-2.2-1.2-3-2c-0.9-0.9-1.5-1.9-2-3c-0.4-1.1-0.7-2.3-0.7-3.5c0-1.3,0.3-2.5,0.7-3.5c0.5-1.1,1.2-2.2,2-3c0.9-0.9,1.9-1.5,3-2c1.1-0.4,2.3-0.7,3.5-0.7c0.7,0,1.3,0.1,2,0.2c0.5,0.1,1.1,0.3,1.6,0.5l0,0l0.3,0.2c0.5,0.2,1,0.5,1.4,0.8c0.5,0.3,0.9,0.7,1.3,1.1c0.1,0.1,0.2,0.2,0.3,0.3l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0c0.2,0.2,0.4,0.4,0.5,0.7c0.6,0.8,1.1,1.7,1.4,2.7l0.1,0.3l-0.3,0l-1.5,0c-2.5,0-1.6-1.6-4.1-2.9c-0.5-0.3-0.9-0.5-1.5-0.6c-0.2-0.1-0.4-0.1-0.6-0.1l0,0.9C26.5,13.8,26.8,14,27.1,14.2z"/>
</g>
</defs>
</svg>

<script>
changePay.init({
    autoPay: true,
    site_id: "f45ee2445f374835bfe45c863e405092",
    changepay_root: "http://www.changetip.com",
    ready: function(login_status) {
        console.log("login status: " + login_status);
        console.log("canonical is: " + changePay.get_canonical_url());
    },
    paid: function(status_code, msg) {
        console.log(status_code, "You are paid up, or no payment is required!");
    },
    unpaid: function(status_code, msg) {
        console.log(status_code, "Payment couldn't be made for some reason.");
    },
    listeners: {
        payment_already_made: function(msg) {
            // hide ads
            console.log("you already paid for this one");
        },
        payment_not_required: function(msg) {
            // hide ads
            console.log("this page is free!");
        },
        new_site_approval: function(msg) {
            changePay.UI.showMessage('Thanks a lot for supporting Wikia! <a href="http://www.changetip.com/changepay" target="_blank">Complete your setup now.</a>', 'alert');
        },
user_is_not_logged_in: function(msg) {
	changePay.UI.showMessage('<header><svg viewBox="0 0 430 42" width="240"><use xlink:href="#changepay-wikia"></svg></header>' +
		'<h1>No more ads. Made simple.</h1>' +
		'<p>Support Wikia for a few pennies and skip the ads. We\'ve partnered with <b>ChangePay</b>, a micropayments service that is helping us make your Wikia browsing experience even better!</p>' +
		'<p>The cost is 1&cent; per pageview with a 10&cent; maximum per day.</p>' +
		'<div id="changePay-auth"></div>' +
		'<p class="muted">Connect and ChangePay will help you quickly complete your setup</p>' +
		'<p><a href="" onclick="changePay.UI.closeMessage(event)">No thanks</a>'
		, 'modal');
},
site_not_approved: function(msg) {
	changePay.UI.showMessage('<header><svg viewBox="0 0 430 42" width="240"><use xlink:href="#changepay-wikia"></svg></header>' +
		'<h1>No more ads. Made simple.</h1>' +
		'<p>Support Wikia for a few pennies and skip the ads. The cost is 1&cent; per pageview with a 10&cent; maximum per day.</p>' +
		'<div id="changePay-auth"></div>' +
		'<p><a href="" onclick="changePay.UI.closeMessage(event)">No thanks</a>'
		, 'modal');
}
}
});
</script>
CODE;
		/* ADEN-2592 not meant for production END */
		return true;
	}

}
