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
	'wikia.window',
	'wikia.querystring'
], function (abTest, cookies, doc, geo, instantGlobals, w, Querystring) {
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

		return context.targeting.mercuryPageCategories.map(function (item) { return item.title; });
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
		if (doc && doc.referrer && doc.referrer.match(/info\.tvsideview\.sony\.net/)) {
			context.opts.showAds = false;
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverDelayCountries)) {
			context.opts.delayEngine = true;
		}

		// SourcePoint detection integration
		if (!noExternals && context.opts.sourcePointDetectionUrl) {
			context.opts.sourcePointDetection = isUrlParamSet('sourcepointdetection') ||
				(context.targeting.skin === 'oasis' &&
				geo.isProperGeo(instantGlobals.wgAdDriverSourcePointDetectionCountries));
			context.opts.sourcePointDetectionMobile = isUrlParamSet('sourcepointdetection') ||
				(context.targeting.skin === 'mercury' &&
				geo.isProperGeo(instantGlobals.wgAdDriverSourcePointDetectionMobileCountries));
		}

		// SourcePoint recovery integration
		if (!context.opts.delayEngine && context.opts.sourcePointDetection && context.opts.sourcePointRecoveryUrl) {
			context.opts.sourcePointRecovery = isUrlParamSet('sourcepointrecovery') ||
				geo.isProperGeo(instantGlobals.wgAdDriverSourcePointRecoveryCountries);
		}

		// Recoverable ads message
		if (context.opts.sourcePointDetection && !context.opts.sourcePointRecovery && context.opts.showAds) {
			context.opts.recoveredAdsMessage = isPageType('article') &&
				geo.isProperGeo(instantGlobals.wgAdDriverAdsRecoveryMessageCountries);
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

		// INVISIBLE_HIGH_IMPACT slot
		context.slots.invisibleHighImpact = (
			context.slots.invisibleHighImpact &&
			geo.isProperGeo(instantGlobals.wgAdDriverHighImpactSlotCountries)
		) || isUrlParamSet('highimpactslot');

		// INCONTENT_PLAYER slot
		context.slots.incontentPlayer = geo.isProperGeo(instantGlobals.wgAdDriverIncontentPlayerSlotCountries) ||
			isUrlParamSet('incontentplayer');

		context.opts.scrollHandlerConfig = instantGlobals.wgAdDriverScrollHandlerConfig;
		context.opts.enableScrollHandler = geo.isProperGeo(instantGlobals.wgAdDriverScrollHandlerCountries) ||
			isUrlParamSet('scrollhandler');

		// Krux integration
		context.targeting.enableKruxTargeting = !!(
			context.targeting.enableKruxTargeting &&
			geo.isProperGeo(instantGlobals.wgAdDriverKruxCountries) &&
			!instantGlobals.wgSitewideDisableKrux &&
			!context.targeting.wikiDirectedAtChildren &&
			!noExternals
		);

		// Floating medrec
		context.opts.floatingMedrec = !!(
			context.opts.showAds && context.opts.adsInContent &&
			(isPageType('article') || isPageType('search')) &&
			!context.targeting.wikiIsCorporate
		);

		// Override prefooters sizes
		context.opts.overridePrefootersSizes =  !!(
			context.targeting.skin === 'oasis' &&
			geo.isProperGeo(instantGlobals.wgAdDriverOverridePrefootersCountries) &&
			!isPageType('home')
		);

		// Override leaderboard sizes
		context.opts.overrideLeaderboardSizes = !!(
			context.targeting.skin === 'oasis' &&
			geo.isProperGeo(['JP'])
		);

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

	return {
		addCallback: addCallback,
		getContext: getContext,
		setContext: setContext
	};
});
