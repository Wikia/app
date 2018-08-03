/*global define*/
/**
 * The AMD module to hold all the context needed for the client-side scripts to run.
 */
define('ext.wikia.adEngine.adContext', [
	'wikia.browserDetect',
	'wikia.cookies',
	'wikia.geo',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.geo',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.window',
	'wikia.querystring'
], function (browserDetect, cookies, geo, instantGlobals, adsGeo, sampler, w, Querystring) {
	'use strict';

	instantGlobals = instantGlobals || {};

	var context,
		callbacks = [],
		qs = new Querystring(),
		useNewGeo = geo.isProperGeo(instantGlobals.wgAdDriverNewGeoCountries);

	function getContext() {
		return context;
	}

	function getMercuryCategories() {
		if (!context.targeting.mercuryPageCategories) {
			return;
		}

		return context.targeting.mercuryPageCategories.map(function (item) {
			return item.title;
		});
	}

	function isUrlParamSet(param) {
		return !!parseInt(qs.getVal(param, '0'), 10);
	}

	function isPageType(pageType) {
		return context.targeting.pageType === pageType;
	}

	function isBabDetectionDesktopEnabled() {
		return isEnabled('wgAdDriverBabDetectionDesktopCountries');
	}

	function isBabDetectionMobileEnabled() {
		return isEnabled('wgAdDriverBabDetectionMobileCountries');
	}

	function updateDetectionServicesAdContext(context, noExternals) {
		// BlockAdBlock detection
		context.opts.babDetectionDesktop = !noExternals && isBabDetectionDesktopEnabled();
		context.opts.babDetectionMobile = !noExternals && isBabDetectionMobileEnabled();
	}

	function isILSupportedBrowser() {
		return browserDetect.isChrome() && browserDetect.getBrowserVersion() > 45;
	}

	function updateAdContextRecServices(context, noExternals) {
		// showAds is undefined by default
		var serviceCanBeEnabled = !noExternals &&
			context.opts.showAds !== false &&
			!w.wgUserName &&
			context.targeting.skin === 'oasis' &&
			!areDelayServicesBlocked();

		// BT rec
		context.opts.wadBT = serviceCanBeEnabled &&
			isEnabled('wgAdDriverWadBTCountries');

		// IL rec
		context.opts.wadIL = serviceCanBeEnabled &&
			isEnabled('wgAdDriverWadILCountries') &&
			isILSupportedBrowser();
	}

	function isEnabled(name) {
		var geos = instantGlobals[name] || [];

		if (useNewGeo) {
			return isProperGeoAds(name);
		}

		return geo.isProperGeo(geos);
	}

	function isProperGeoAds(name) {
		var geos = instantGlobals[name] || [];
		return adsGeo.isProperGeo(geos, name);
	}

	function updateAdContextRabbitExperiments(context) {
		context.rabbits.ctpDesktop = isProperGeoAds('wgAdDriverCTPDesktopRabbitCountries');
		context.rabbits.ctpMobile = isProperGeoAds('wgAdDriverCTPMobileRabbitCountries');
		context.rabbits.queenDesktop = isProperGeoAds('wgAdDriverCTPDesktopQueenCountries');
	}

	function areDelayServicesBlocked() {
		return context.targeting.skin === 'mercury' && isProperGeoAds('wgAdDriverBlockDelayServicesCountries');
	}

	function updateAdContextBidders(context) {
		var hasFeaturedVideo = context.targeting.hasFeaturedVideo;

		context.bidders.prebid = !areDelayServicesBlocked() && isProperGeoAds('wgAdDriverPrebidBidderCountries');
		context.bidders.a9 = !areDelayServicesBlocked() && isProperGeoAds('wgAdDriverA9BidderCountries');
		context.bidders.a9Video = !areDelayServicesBlocked() && isProperGeoAds('wgAdDriverA9VideoBidderCountries');
		context.bidders.rubiconDisplay = isProperGeoAds('wgAdDriverRubiconDisplayPrebidCountries');
		context.bidders.rubicon = isProperGeoAds('wgAdDriverRubiconPrebidCountries');
		context.bidders.rubiconDfp = isProperGeoAds('wgAdDriverRubiconDfpCountries');
		context.bidders.rubiconInFV = isProperGeoAds('wgAdDriverRubiconVideoInFeaturedVideoCountries') && hasFeaturedVideo;
		context.bidders.beachfront = isProperGeoAds('wgAdDriverBeachfrontBidderCountries') && !hasFeaturedVideo;
		context.bidders.appnexusAst = isProperGeoAds('wgAdDriverAppNexusAstBidderCountries');
		context.bidders.aol = isProperGeoAds('wgAdDriverAolBidderCountries');
		context.bidders.appnexus = isProperGeoAds('wgAdDriverAppNexusBidderCountries');
		context.bidders.appnexusDfp = isProperGeoAds('wgAdDriverAppNexusDfpCountries');
		context.bidders.appnexusWebAds = isProperGeoAds('wgAdDriverAppNexusWebAdsBidderCountries');
		context.bidders.audienceNetwork = isProperGeoAds('wgAdDriverAudienceNetworkBidderCountries');
		context.bidders.indexExchange = isProperGeoAds('wgAdDriverIndexExchangeBidderCountries');
		context.bidders.kargo = isProperGeoAds('wgAdDriverKargoBidderCountries');
		context.bidders.onemobile = isProperGeoAds('wgAdDriverAolOneMobileBidderCountries');
		context.bidders.openx = isProperGeoAds('wgAdDriverOpenXPrebidBidderCountries');
		context.bidders.pubmatic = isProperGeoAds('wgAdDriverPubMaticBidderCountries');
	}

	function isMOATTrackingForFVEnabled() {
		var samplingForMoatFV = instantGlobals.wgAdDriverMoatTrackingForFeaturedVideoAdSampling || 1;

		return sampler.sample('moatTrackingForFeaturedVideo', samplingForMoatFV, 100) &&
			isEnabled('wgAdDriverMoatTrackingForFeaturedVideoAdCountries');
	}

	function setContext(newContext) {
		var i,
			len,
			fvAdsFrequency = instantGlobals.wgAdDriverPlayAdsOnNextFVFrequency,
			noExternals = w.wgNoExternals || isUrlParamSet('noexternals');

		// Note: consider copying the value, not the reference
		context = newContext;

		// Always have objects in all categories
		context.opts = context.opts || {};
		context.slots = context.slots || {};
		context.targeting = context.targeting || {};
		context.providers = context.providers || {};
		context.bidders = context.bidders || {};
		context.rabbits = context.rabbits || {};
		context.forcedProvider = qs.getVal('forcead', null) || context.forcedProvider || null;
		context.opts.noExternals = noExternals;

		context.opts.delayEngine = true;
		context.opts.overwriteDelayEngine = isProperGeoAds('wgAdDriverDelayCountries');

		context.opts.premiumOnly = context.targeting.hasFeaturedVideo && isEnabled('wgAdDriverSrcPremiumCountries');

		context.opts.isMoatTrackingForFeaturedVideoEnabled = isMOATTrackingForFVEnabled();
		updateDetectionServicesAdContext(context, noExternals);
		updateAdContextRecServices(context, noExternals);

		updateAdContextBidders(context);
		updateAdContextRabbitExperiments(context);

		// showcase.*
		if (cookies.get('mock-ads') === 'NlfdjR5xC0') {
			context.opts.showcase = true;
		}

		// Targeting by page categories
		if (context.targeting.enablePageCategories) {
			context.targeting.pageCategories = w.wgCategories || getMercuryCategories();
		}

		// Evolve2 integration
		if (context.providers.evolve2) {
			context.providers.evolve2 = isEnabled('wgAdDriverEvolve2Countries');
		}

		context.providers.turtle = isProperGeoAds('wgAdDriverTurtleCountries');

		context.opts.enableRemnantNewAdUnit = isEnabled('wgAdDriverMEGACountries');

		// INVISIBLE_HIGH_IMPACT slot
		context.slots.invisibleHighImpact = (
				context.slots.invisibleHighImpact && isEnabled('wgAdDriverHighImpactSlotCountries')
			) || isUrlParamSet('highimpactslot');

		context.slots.invisibleHighImpact2 = !context.targeting.hasFeaturedVideo &&
			isEnabled('wgAdDriverHighImpact2SlotCountries');

		// AdInfo warehouse logging
		context.opts.kikimoraViewabilityTracking = isEnabled('wgAdDriverKikimoraViewabilityTrackingCountries');
		context.opts.enableAdInfoLog = isEnabled('wgAdDriverKikimoraTrackingCountries');
		context.opts.playerTracking = isEnabled('wgAdDriverKikimoraPlayerTrackingCountries');

		// CMP module
		context.opts.isCMPEnabled = isEnabled('wgEnableCMPCountries');

		// Krux integration
		context.targeting.enableKruxTargeting = !!(
			context.targeting.enableKruxTargeting &&
			isProperGeoAds('wgAdDriverKruxCountries') && !instantGlobals.wgSitewideDisableKrux
		);
		context.opts.kruxNewParams = isProperGeoAds('wgAdDriverKruxNewParamsCountries');

		// Floating medrec
		context.opts.floatingMedrec = !!(
			context.opts.showAds && context.opts.adsInContent &&
			(isPageType('article') || isPageType('search')) && !context.targeting.wikiIsCorporate
		);

		context.opts.outstreamVideoFrequencyCapping = instantGlobals.wgAdDriverOutstreamVideoFrequencyCapping;
		context.opts.porvataMoatTrackingEnabled = isEnabled('wgAdDriverPorvataMoatTrackingCountries');
		context.opts.porvataMoatTrackingSampling = instantGlobals.wgAdDriverPorvataMoatTrackingSampling || 0;

		context.opts.megaAdUnitBuilderEnabled = context.targeting.hasFeaturedVideo &&
			isEnabled('wgAdDriverMegaAdUnitBuilderForFVCountries');

		context.opts.isScrollDepthTrackingEnabled = isEnabled('wgAdDriverScrollDepthTrackingCountries');
		context.opts.isBfabStickinessEnabled = isEnabled('wgAdDriverBfabStickinessCountries') &&
			context.targeting.skin !== 'oasis';

		context.opts.isFVDelayEnabled = !areDelayServicesBlocked() && isEnabled('wgAdDriverFVDelayCountries');
		context.opts.isFVUapKeyValueEnabled = isEnabled('wgAdDriverFVAsUapKeyValueCountries');
		context.opts.isFVMidrollEnabled = isEnabled('wgAdDriverFVMidrollCountries');
		context.opts.isFVPostrollEnabled = isEnabled('wgAdDriverFVPostrollCountries');
		context.opts.replayAdsForFV = isEnabled('wgAdDriverPlayAdsOnNextFVCountries');
		context.opts.fvAdsFrequency = fvAdsFrequency !== undefined ? fvAdsFrequency : 3;
		context.opts.disableSra = isEnabled('wgAdDriverDisableSraCountries');
		context.opts.isBLBLazyPrebidEnabled = context.targeting.skin === 'oasis' &&
			isEnabled('wgAdDriverBottomLeaderBoardLazyPrebidCountries');
		context.opts.isBLBMegaEnabled = isEnabled('wgAdDriverBottomLeaderBoardMegaCountries');
		context.opts.isBLBViewportEnabled = isEnabled('wgAdDriverBottomLeaderBoardViewportCountries');
		context.opts.additionalBLBSizes = isEnabled('wgAdDriverBottomLeaderBoardAdditionalSizesCountries');
		context.opts.isBLBSingleSizeForUAPEnabled = isProperGeoAds('wgAdDriverSingleBLBSizeForUAPCountries');
		context.opts.preFooterAndBLBSwitched = isProperGeoAds('wgAdDriverPreFooterAndBLBSwitchedCountries');

		context.opts.labradorTest = isProperGeoAds('wgAdDriverLABradorTestCountries');
		context.opts.labradorTestGroup = context.opts.labradorTest ? 'B' : 'A';
		context.opts.mobileSectionsCollapse = isProperGeoAds('wgAdDriverMobileSectionsCollapseCountries');
		context.opts.netzathleten = isProperGeoAds('wgAdDriverNetzAthletenCountries');
		context.opts.additionalVastSize = isProperGeoAds('wgAdDriverAdditionalVastSizeCountries');

		// Need to be placed always after all lABrador wgVars checks
		context.opts.labradorDfp = getDfpLabradorKeyvals(instantGlobals.wgAdDriverLABradorDfpKeyvals);

		// Export the context back to ads.context
		// Only used by Lightbox.js, WikiaBar.js and AdsInContext.js
		if (w.ads && w.ads.context) {
			w.ads.context = context;
		}

		for (i = 0, len = callbacks.length; i < len; i += 1) {
			callbacks[i](context);
		}
	}

	function getDfpLabradorKeyvals(wfKeyvals) {
		if (!wfKeyvals || !wfKeyvals.length) {
			return '';
		}

		var labradorDfpKeys = [],
			labradorVariables = adsGeo.getSamplingResults();

		wfKeyvals.forEach(function (keyval) {
			keyval = keyval.split(':');

			if (labradorVariables.indexOf(keyval[0]) !== -1) {
				labradorDfpKeys.push(keyval[1])
			}
		});

		return labradorDfpKeys.join(',');
	}

	function addCallback(callback) {
		callbacks.push(callback);
	}

	function get(path) {
		var isPathValid = path !== undefined && path !== '',
			nextElement = getContext(),
			nodes = (path || '').split('.');

		while (isPathValid && nodes.length > 0 && typeof nextElement === 'object') {
			nextElement = nextElement[nodes.shift()];
		}

		return nextElement;
	}

	setContext((w.ads && w.ads.context) ? w.ads.context : {});

	return {
		get: get,
		addCallback: addCallback,
		getContext: getContext,
		setContext: setContext,
		isEnabled: isEnabled
	};
});
