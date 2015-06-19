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
		var categoryDict;

		try {
			categoryDict = w.Wikia.article.article.categories;
		} catch (e) {
			return;
		}

		return categoryDict.map(function (item) { return item.title; });
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
		context.forcedAdProvider = getForcedAdProvider(context);

		// Don't show ads when Sony requests the page
		if (doc && doc.referrer && doc.referrer.match(/info\.tvsideview\.sony\.net/)) {
			context.opts.showAds = false;
		}

		// Targeting by page categories
		if (context.targeting.enablePageCategories) {
			context.targeting.pageCategories = w.wgCategories || getMercuryCategories();
		}

		// Krux integration
		if (instantGlobals.wgSitewideDisableKrux) {
			context.targeting.enableKruxTargeting = false;
		}

		// Taboola integration
		if (context.providers.taboola) {
			context.providers.taboola = abTest && abTest.inGroup('NATIVE_ADS_TABOOLA', 'YES') &&
				(context.targeting.pageType === 'article' || context.targeting.pageType === 'home');
		}

		// Turtle
		if (context.forcedAdProvider === 'turtle') {
			context.providers.turtle = true;
		}

		if (instantGlobals.wgAdDriverTurtleCountries &&
				instantGlobals.wgAdDriverTurtleCountries.indexOf &&
				instantGlobals.wgAdDriverTurtleCountries.indexOf(geo.getCountryCode()) > -1
					) {
			context.providers.turtle = true;
		}

		if (instantGlobals.wgAdDriverOpenXCountries &&
			instantGlobals.wgAdDriverOpenXCountries.indexOf &&
			instantGlobals.wgAdDriverOpenXCountries.indexOf(geo.getCountryCode()) > -1
		) {
			context.providers.openX = true;
		}

		if (instantGlobals.wgAdDriverHighImpactSlotCountries &&
				instantGlobals.wgAdDriverHighImpactSlotCountries.indexOf &&
				instantGlobals.wgAdDriverHighImpactSlotCountries.indexOf(geo.getCountryCode()) > -1
					) {
			context.slots.invisibleHighImpact = true;
		}

		// Export the context back to ads.context
		// Only used by Lightbox.js, WikiaBar.js and AdsInContext.js
		if (w.ads && w.ads.context) {
			w.ads.context = context;
		}

		for (i = 0, len = callbacks.length; i < len; i += 1) {
			callbacks[i](context);
		}
	}

	function getForcedAdProvider (context) {
		var possibleForcedAdProviders = ['liftium', 'openx', 'turtle'],
			possibleForcedAdProvidersNo = possibleForcedAdProviders.length - 1,
			i, forced;

		for (i = possibleForcedAdProvidersNo; i >= 0; i--) {
			if (possibleForcedAdProviders.hasOwnProperty(i)) {
				forced = !!qs.getVal('force' + possibleForcedAdProviders[i], false);

				if (forced) {
					return possibleForcedAdProviders[i];
				}
			}
		}

		return context.forcedAdProvider || null;
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
