/*global define*/
/**
 * The AMD module to hold all the context needed for the client-side scripts to run.
 */
define('ext.wikia.adEngine.adContext', [
	'wikia.abTest',
	'wikia.cookies',
	'wikia.document',
	'wikia.geo',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.window',
	'wikia.querystring'
], function (abTest, cookies, doc, geo, instantGlobals, sampler, w, Querystring) {
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

	function setContext(newContext) {
		var i,
			len,
			noExternals = w.wgNoExternals || isUrlParamSet('noexternals'),
			taboolaConfig = instantGlobals.wgAdDriverTaboolaConfig || {};

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
		if (doc && doc.referrer && doc.referrer.match(/info\.tvsideview\.sony\.net/)) {
			context.opts.showAds = false;
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverDelayCountries)) {
			context.opts.delayEngine = true;
		}

		// PageFair detection
		if (!noExternals) {
			var geoIsSupported = geo.isProperGeo(instantGlobals.wgAdDriverPageFairDetectionCountries),
				forcePageFairByURL = isUrlParamSet('pagefairdetection'),
				canBeSampled = sampler.sample('pageFairDetection',  1, 10);

			if (forcePageFairByURL || (geoIsSupported && canBeSampled)) {
				context.opts.pageFairDetection = true;
			}
		}

		context.opts.premiumOnly = context.targeting.hasFeaturedVideo &&
			geo.isProperGeo(instantGlobals.wgAdDriverSrcPremiumCountries);

		// PageFair recovery
		context.opts.pageFairRecovery = !noExternals &&
			context.opts.pageFairRecovery &&
			geo.isProperGeo(instantGlobals.wgAdDriverPageFairRecoveryCountries);

		// SourcePoint recovery
		context.opts.sourcePointRecovery = !noExternals &&
			context.opts.sourcePointRecovery &&
			geo.isProperGeo(instantGlobals.wgAdDriverSourcePointRecoveryCountries);

		// SourcePoint MMS
		context.opts.sourcePointMMS = !noExternals &&
			context.opts.sourcePointMMS;

		context.opts.sourcePointBootstrap = context.opts.sourcePointMMS || context.opts.sourcePointRecovery;

		// SourcePoint detection integration
		if (!noExternals && context.opts.sourcePointDetectionUrl) {
			context.opts.sourcePointDetection = (context.targeting.skin === 'oasis' &&
				geo.isProperGeo(instantGlobals.wgAdDriverSourcePointDetectionCountries));

			context.opts.sourcePointDetectionMobile = (context.targeting.skin === 'mercury' &&
				geo.isProperGeo(instantGlobals.wgAdDriverSourcePointDetectionMobileCountries));
		}

		// Taboola
		if (!noExternals) {
			if (shouldLoadTaboolaOnBlockingTraffic(taboolaConfig)) {
				context.opts.loadTaboolaLibrary = true;
			}
		}

		// Google Consumer Surveys
		if (context.opts.sourcePointDetection && !context.opts.sourcePointRecovery && context.opts.showAds) {
			context.opts.googleConsumerSurveys = abTest.getGroup('PROJECT_43') === 'GROUP_5' &&
				geo.isProperGeo(instantGlobals.wgAdDriverGoogleConsumerSurveysCountries);
		}

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

		// OpenX for remnant slot enabled
		context.opts.openXRemnantEnabled = geo.isProperGeo(instantGlobals.wgAdDriverOpenXBidderCountriesRemnant);

		// Export the context back to ads.context
		// Only used by Lightbox.js, WikiaBar.js and AdsInContext.js
		if (w.ads && w.ads.context) {
			w.ads.context = context;
		}

		for (i = 0, len = callbacks.length; i < len; i += 1) {
			callbacks[i](context);
		}
	}

	function shouldLoadTaboolaOnBlockingTraffic(taboolaConfig) {
		var i, taboolaSlot;

		for (taboolaSlot in taboolaConfig) {
			if (taboolaConfig.hasOwnProperty(taboolaSlot) && taboolaConfig[taboolaSlot].recovery) {
				for (i = 0; i < taboolaConfig[taboolaSlot].recovery.length; i++) {
					if (geo.isProperGeo(taboolaConfig[taboolaSlot].recovery[i])) {
						return true;
					}
				}
			}
		}
		return false;
	}

	function addCallback(callback) {
		callbacks.push(callback);
	}

	setContext(w.ads ? w.ads.context : {});

	return {
		addCallback: addCallback,
		getContext: getContext,
		setContext: setContext
	};
});
