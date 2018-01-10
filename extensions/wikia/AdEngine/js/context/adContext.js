/*global define*/
/**
 * The AMD module to hold all the context needed for the client-side scripts to run.
 */
define('ext.wikia.adEngine.adContext', [
	'wikia.browserDetect',
	'wikia.cookies',
	'wikia.document',
	'wikia.geo',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.window',
	'wikia.querystring'
], function (browserDetect, cookies, doc, geo, instantGlobals, sampler, w, Querystring) {
	'use strict';

	instantGlobals = instantGlobals || {};

	var context,
		callbacks = [],
		qs = new Querystring();

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

	function isInstartLogicSupportedBrowser() {
		return browserDetect.isChrome() && browserDetect.getBrowserVersion() > 45;
	}

	function isPageFairDetectionEnabled() {
		var isSupportedGeo = geo.isProperGeo(instantGlobals.wgAdDriverPageFairDetectionCountries);
		return isUrlParamSet('pagefairdetection') || (isSupportedGeo && sampler.sample('pageFairDetection', 1, 10));
	}

	function isSourcePointDetectionDesktopEnabled(context) {
		return context.opts.sourcePointDetectionUrl && context.targeting.skin === 'oasis' &&
			geo.isProperGeo(instantGlobals.wgAdDriverSourcePointDetectionCountries);
	}

	function isSourcePointDetectionMobileEnabled(context) {
		return context.opts.sourcePointDetectionUrl && context.targeting.skin === 'mercury' &&
			geo.isProperGeo(instantGlobals.wgAdDriverSourcePointDetectionMobileCountries);
	}

	function updateDetectionServicesAdContext(context, noExternals) {
		// SourcePoint detection integration
		context.opts.sourcePointDetection = !noExternals && isSourcePointDetectionDesktopEnabled(context);
		context.opts.sourcePointDetectionMobile = !noExternals && isSourcePointDetectionMobileEnabled(context);

		// PageFair detection
		context.opts.pageFairDetection = !noExternals && isPageFairDetectionEnabled();
	}

	function updateAdContextRecoveryServices(context, noExternals) {
		var isRecoveryServiceAlreadyEnabled = false,
			serviceCanBeEnabled = !noExternals && context.opts.showAds !== false; // showAds is undefined by default

		// InstartLogic recovery
		context.opts.instartLogicRecovery = serviceCanBeEnabled &&
			!isRecoveryServiceAlreadyEnabled &&
			context.opts.instartLogicRecovery &&
			geo.isProperGeo(instantGlobals.wgAdDriverInstartLogicRecoveryCountries) &&
			isInstartLogicSupportedBrowser();
		isRecoveryServiceAlreadyEnabled |= context.opts.instartLogicRecovery;

		// PageFair recovery
		context.opts.pageFairRecovery = serviceCanBeEnabled && !isRecoveryServiceAlreadyEnabled &&
			context.opts.pageFairRecovery && geo.isProperGeo(instantGlobals.wgAdDriverPageFairRecoveryCountries) &&
			!browserDetect.isEdge();
		isRecoveryServiceAlreadyEnabled |= context.opts.pageFairRecovery;

		// SourcePoint recovery
		context.opts.sourcePointRecovery = serviceCanBeEnabled && !isRecoveryServiceAlreadyEnabled &&
			context.opts.sourcePointRecovery && geo.isProperGeo(instantGlobals.wgAdDriverSourcePointRecoveryCountries);
		isRecoveryServiceAlreadyEnabled |= context.opts.sourcePointRecovery;

		// SourcePoint MMS
		context.opts.sourcePointMMS = serviceCanBeEnabled && !isRecoveryServiceAlreadyEnabled && context.opts.sourcePointMMS;

		context.opts.sourcePointBootstrap = context.opts.sourcePointMMS || context.opts.sourcePointRecovery;
	}

	function updateAdContextBidders(context) {
		var hasFeaturedVideo = context.targeting.hasFeaturedVideo;

		context.bidders.rubiconDisplay = geo.isProperGeo(instantGlobals.wgAdDriverRubiconDisplayPrebidCountries);

		context.bidders.rubicon = geo.isProperGeo(instantGlobals.wgAdDriverRubiconPrebidCountries) &&
			!hasFeaturedVideo;

		context.bidders.appnexusAst = geo.isProperGeo(instantGlobals.wgAdDriverAppNexusAstBidderCountries) &&
			!hasFeaturedVideo;

		context.bidders.a9Video = geo.isProperGeo(instantGlobals.wgAdDriverA9VideoBidderCountries);
	}

	function referrerIsSonySite() {
		return doc && doc.referrer && doc.referrer.match(/info\.tvsideview\.sony\.net/);
	}

	function isMOATTrackingForFVEnabled() {
		var samplingForMoatFV = instantGlobals.wgAdDriverMoatTrackingForFeaturedVideoAdSampling || 1;

		return sampler.sample('moatTrackingForFeaturedVideo', samplingForMoatFV, 100) &&
			geo.isProperGeo(instantGlobals.wgAdDriverMoatTrackingForFeaturedVideoAdCountries);
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
		context.forcedProvider = qs.getVal('forcead', null) || context.forcedProvider || null;
		context.opts.noExternals = noExternals;

		// Don't show ads when Sony requests the page
		if (referrerIsSonySite()) {
			context.opts.showAds = false;
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverDelayCountries)) {
			context.opts.delayEngine = true;
		}

		context.opts.isAdProductsBridgeEnabled = geo.isProperGeo(instantGlobals.wgAdDriverAdProductsBridgeCountries);

		context.opts.premiumOnly = context.targeting.hasFeaturedVideo &&
			geo.isProperGeo(instantGlobals.wgAdDriverSrcPremiumCountries);

		context.opts.isMoatTrackingForFeaturedVideoEnabled = isMOATTrackingForFVEnabled();
		updateDetectionServicesAdContext(context, noExternals);
		updateAdContextRecoveryServices(context, noExternals);

		updateAdContextBidders(context);

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
			context.providers.evolve2 = geo.isProperGeo(instantGlobals.wgAdDriverEvolve2Countries);
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverTurtleCountries)) {
			context.providers.turtle = true;
		}

		context.opts.enableRemnantNewAdUnit = geo.isProperGeo(instantGlobals.wgAdDriverMEGACountries);

		// INVISIBLE_HIGH_IMPACT slot
		context.slots.invisibleHighImpact = (
				context.slots.invisibleHighImpact &&
				geo.isProperGeo(instantGlobals.wgAdDriverHighImpactSlotCountries)
			) || isUrlParamSet('highimpactslot');

		// AdInfo warehouse logging
		context.opts.kikimoraViewabilityTracking =
			geo.isProperGeo(instantGlobals.wgAdDriverKikimoraViewabilityTrackingCountries);
		context.opts.enableAdInfoLog = geo.isProperGeo(instantGlobals.wgAdDriverKikimoraTrackingCountries);
		context.opts.playerTracking = geo.isProperGeo(instantGlobals.wgAdDriverKikimoraPlayerTrackingCountries);

		// Krux integration
		context.targeting.enableKruxTargeting = !!(
			context.targeting.enableKruxTargeting &&
			geo.isProperGeo(instantGlobals.wgAdDriverKruxCountries) && !instantGlobals.wgSitewideDisableKrux
		);

		// Floating medrec
		context.opts.floatingMedrec = !!(
			context.opts.showAds && context.opts.adsInContent &&
			(isPageType('article') || isPageType('search')) && !context.targeting.wikiIsCorporate
		);

		context.opts.outstreamVideoFrequencyCapping = instantGlobals.wgAdDriverOutstreamVideoFrequencyCapping;
		context.opts.porvataMoatTrackingEnabled =
			geo.isProperGeo(instantGlobals.wgAdDriverPorvataMoatTrackingCountries);
		context.opts.porvataMoatTrackingSampling = instantGlobals.wgAdDriverPorvataMoatTrackingSampling || 0;

		context.opts.megaAdUnitBuilderEnabled = context.targeting.hasFeaturedVideo &&
			geo.isProperGeo(instantGlobals.wgAdDriverMegaAdUnitBuilderForFVCountries);

		context.opts.isFVMidrollEnabled = geo.isProperGeo(instantGlobals.wgAdDriverFVMidrollCountries);
		context.opts.isFVPostrollEnabled = geo.isProperGeo(instantGlobals.wgAdDriverFVPostrollCountries);
		context.opts.replayAdsForFV = geo.isProperGeo(instantGlobals.wgAdDriverPlayAdsOnNextFVCountries);
		context.opts.fvAdsFrequency = fvAdsFrequency !== undefined ? fvAdsFrequency : 3;
		context.opts.disableSra = geo.isProperGeo(instantGlobals.wgAdDriverDisableSraCountries);
		// Export the context back to ads.context
		// Only used by Lightbox.js, WikiaBar.js and AdsInContext.js
		if (w.ads && w.ads.context) {
			w.ads.context = context;
		}

		for (i = 0, len = callbacks.length; i < len; i += 1) {
			callbacks[i](context);
		}
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

	setContext(w.ads ? w.ads.context : {});

	return {
		get: get,
		addCallback: addCallback,
		getContext: getContext,
		setContext: setContext
	};
});
