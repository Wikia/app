/*global define*/
/**
 * The AMD module to hold all the context needed for the client-side scripts to run.
 */
define('ext.wikia.adEngine.adContext', [
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'wikia.cookies',
	'wikia.document',
	'wikia.geo',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.window',
	'wikia.querystring'
], function (pvCounter, cookies, doc, geo, instantGlobals, sampler, w, Querystring) {
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

		// PageFair recovery
		context.opts.pageFairRecovery = serviceCanBeEnabled && !isRecoveryServiceAlreadyEnabled &&
			context.opts.pageFairRecovery && geo.isProperGeo(instantGlobals.wgAdDriverPageFairRecoveryCountries);
		isRecoveryServiceAlreadyEnabled |= context.opts.pageFairRecovery;

		// SourcePoint recovery
		context.opts.sourcePointRecovery = serviceCanBeEnabled && !isRecoveryServiceAlreadyEnabled &&
			context.opts.sourcePointRecovery && geo.isProperGeo(instantGlobals.wgAdDriverSourcePointRecoveryCountries);
		isRecoveryServiceAlreadyEnabled |= context.opts.sourcePointRecovery;

		// SourcePoint MMS
		context.opts.sourcePointMMS = serviceCanBeEnabled && !isRecoveryServiceAlreadyEnabled && context.opts.sourcePointMMS;

		context.opts.sourcePointBootstrap = context.opts.sourcePointMMS || context.opts.sourcePointRecovery;
	}

	function enableAdMixExperiment(context) {
		context.opts.adMixExperimentEnabled = !!(
			isPageType('article') &&
			context.targeting.skin === 'oasis' &&
			context.targeting.hasFeaturedVideo &&
			geo.isProperGeo(instantGlobals.wgAdDriverAdMixCountries)
		);

		// TODO remove admix1 in ADEN-5443
		context.opts.adMix1Enabled = false;
		context.opts.adMix3Enabled = context.opts.adMixExperimentEnabled;

		context.slots.adMixToUnblock = ['INCONTENT_BOXAD_1'];

		if (context.opts.adMix3Enabled) {
			context.slots.adMixToUnblock.push('BOTTOM_LEADERBOARD');
		}
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
			noExternals = w.wgNoExternals || isUrlParamSet('noexternals');

		// Note: consider copying the value, not the reference
		context = newContext;

		// Always have objects in all categories
		context.opts = context.opts || {};
		context.slots = context.slots || {};
		context.targeting = context.targeting || {};
		context.providers = context.providers || {};
		context.forcedProvider = qs.getVal('forcead', null) || context.forcedProvider || null;
		context.opts.noExternals = noExternals;

		// Don't show ads when Sony requests the page
		if (referrerIsSonySite()) {
			context.opts.showAds = false;
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverDelayCountries)) {
			context.opts.delayEngine = true;
		}

		context.opts.premiumOnly = context.targeting.hasFeaturedVideo &&
			geo.isProperGeo(instantGlobals.wgAdDriverSrcPremiumCountries);

		context.opts.isMoatTrackingForFeaturedVideoEnabled = isMOATTrackingForFVEnabled();

		updateDetectionServicesAdContext(context, noExternals);
		updateAdContextRecoveryServices(context, noExternals);

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

		if (context.providers.rubiconFastlane) {
			context.providers.rubiconFastlane = geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneCountries) &&
				geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneProviderCountries);
		}

		context.opts.enableRemnantNewAdUnit = geo.isProperGeo(instantGlobals.wgAdDriverMEGACountries);
		context.opts.enableKILOAdUnit = geo.isProperGeo(instantGlobals.wgAdDriverKILOCountries);

		// INVISIBLE_HIGH_IMPACT slot
		context.slots.invisibleHighImpact = (
				context.slots.invisibleHighImpact &&
				geo.isProperGeo(instantGlobals.wgAdDriverHighImpactSlotCountries)
			) || isUrlParamSet('highimpactslot');

		// AdInfo warehouse logging
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

		// Override prefooters sizes
		context.opts.overridePrefootersSizes = !!(
			context.targeting.skin === 'oasis' &&
			geo.isProperGeo(instantGlobals.wgAdDriverOverridePrefootersCountries) && !isPageType('home')
		);

		context.opts.outstreamVideoFrequencyCapping = instantGlobals.wgAdDriverOutstreamVideoFrequencyCapping;

		enableAdMixExperiment(context);

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

	setContext(w.ads ? w.ads.context : {});

	if (context.targeting.skin && context.targeting.skin !== 'mercury') {
		pvCounter.increment();
	}

	return {
		addCallback: addCallback,
		getContext: getContext,
		setContext: setContext
	};
});
