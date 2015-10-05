/*global define,require*/
/**
 * The AMD module to hold all the context needed for the client-side scripts to run.
 */
define('ext.wikia.adEngine.adContext', [
	'wikia.window',
	'wikia.document',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.querystring',
	require.optional('wikia.abTest')
], function (w, doc, geo, instantGlobals, Querystring, abTest) {
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

		// Don't show ads when Sony requests the page
		if (doc && doc.referrer && doc.referrer.match(/info\.tvsideview\.sony\.net/)) {
			context.opts.showAds = false;
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

		// SourcePoint integration
		if (context.opts.sourcePointDetection && context.opts.sourcePointUrl) {
			context.opts.sourcePoint = isUrlParamSet('sourcepoint') ||
				geo.isProperGeo(instantGlobals.wgAdDriverSourcePointCountries);
		}

		// Recoverable ads message
		if (context.opts.sourcePointDetection && !context.opts.sourcePoint) {
			context.opts.recoveredAdsMessage = geo.isProperGeo(instantGlobals.wgAdDriverAdsRecoveryMessageCountries);
		}

		// Showcase.*
		if (isUrlParamSet('showcase')) {
			context.opts.showcase = true;
		}

		// Targeting by page categories
		if (context.targeting.enablePageCategories) {
			context.targeting.pageCategories = w.wgCategories || getMercuryCategories();
		}

		// Taboola integration
		if (context.providers.taboola) {
			context.providers.taboola = abTest && abTest.inGroup('NATIVE_ADS_TABOOLA', 'YES') &&
				(context.targeting.pageType === 'article' || context.targeting.pageType === 'home');
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverTurtleCountries)) {
			context.providers.turtle = true;
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverOpenXCountries)) {
			context.providers.openX = true;
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
