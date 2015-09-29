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

	function isProperCountry(countryList) {
		return !!(countryList && countryList.indexOf && countryList.indexOf(geo.getCountryCode()) > -1);
	}

	function isProperRegion(countryList) {
		return !!(
			countryList &&
			countryList.indexOf &&
			countryList.indexOf(geo.getCountryCode() + '-' + geo.getRegionCode()) > -1
		);
	}

	function isProperGeo(countryList) {
		return isProperCountry(countryList) || isProperRegion(countryList);
	}

	function isUrlParamSet(param) {
		return !!parseInt(qs.getVal(param, '0'), 10);
	}

	function setContext(newContext) {
		var i,
			len;

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

		// SourcePoint integration
		if (context.opts.sourcePointUrl) {
			context.opts.sourcePoint = isUrlParamSet('sourcepoint') ||
				isProperGeo(instantGlobals.wgAdDriverSourcePointCountries);
		}

		// SourcePoint detection integration
		if (context.opts.sourcePointDetectionUrl) {
			context.opts.sourcePointDetection = isUrlParamSet('sourcepointdetection') ||
				isProperCountry(instantGlobals.wgAdDriverSourcePointDetectionCountries);
		}

		// Recoverable ads message
		if (context.opts.sourcePointDetection && !context.opts.sourcePoint) {
			context.opts.recoveredAdsMessage = isProperGeo(instantGlobals.wgAdDriverAdsRecoveryMessageCountries);
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

		if (isProperCountry(instantGlobals.wgAdDriverTurtleCountries)) {
			context.providers.turtle = true;
		}

		if (isProperCountry(instantGlobals.wgAdDriverOpenXCountries)) {
			context.providers.openX = true;
		}

		// INVISIBLE_HIGH_IMPACT slot
		context.slots.invisibleHighImpact = (
			context.slots.invisibleHighImpact &&
			isProperCountry(instantGlobals.wgAdDriverHighImpactSlotCountries)
		) || isUrlParamSet('highimpactslot');

		// INCONTENT_PLAYER slot
		context.slots.incontentPlayer = isProperCountry(instantGlobals.wgAdDriverIncontentPlayerSlotCountries) ||
			isUrlParamSet('incontentplayer');

		context.opts.scrollHandlerConfig = instantGlobals.wgAdDriverScrollHandlerConfig;
		context.opts.enableScrollHandler = isProperCountry(instantGlobals.wgAdDriverScrollHandlerCountries) ||
			isUrlParamSet('scrollhandler');

		// Krux integration
		context.targeting.enableKruxTargeting = !!(
			context.targeting.enableKruxTargeting &&
			isProperCountry(instantGlobals.wgAdDriverKruxCountries) &&
			!instantGlobals.wgSitewideDisableKrux &&
			!context.targeting.wikiDirectedAtChildren
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
