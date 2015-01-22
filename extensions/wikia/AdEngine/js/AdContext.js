/*global define,require*/
/**
 * The AMD module to hold all the context needed for the client-side scripts to run.
 */
define('ext.wikia.adEngine.adContext', [
	'wikia.window',
	'wikia.document',
	'wikia.geo',
	'wikia.instantGlobals',
	require.optional('wikia.abTest')
], function (w, doc, geo, instantGlobals, abTest) {
	'use strict';

	instantGlobals = instantGlobals || {};

	var context;

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
		context = newContext;

		// Always have objects in all categories
		context.opts = context.opts || {};
		context.targeting = context.targeting || {};
		context.providers = context.providers || {};
		context.forceProviders = context.forceProviders || {};

		// Don't show ads when Sony requests the page
		if (doc && doc.referrer && doc.referrer.match(/info\.tvsideview\.sony\.net/)) {
			context.opts.showAds = false;
		}

		// Use PostScribe for ScriptWriter implementation when SevenOne Media ads are enabled
		context.opts.usePostScribe = context.opts.usePostScribe || context.providers.sevenOneMedia;

		// Targeting by page categories
		if (context.targeting.enablePageCategories) {
			context.targeting.pageCategories = w.wgCategories || getMercuryCategories();
		}

		// Always call DART in specific countries
		var alwaysCallDartInCountries = instantGlobals.wgAdDriverAlwaysCallDartInCountries || [];
		if (alwaysCallDartInCountries.indexOf(geo.getCountryCode()) > -1) {
			context.opts.alwaysCallDart = true;
		}

		// Taboola integration
		if (context.providers.taboola) {
			context.providers.taboola = abTest && abTest.inGroup('NATIVE_ADS_TABOOLA', 'YES') &&
				(context.targeting.pageType === 'article' || context.targeting.pageType === 'home');
		}

		// Export the context back to ads.context
		// Only used by Lightbox.js, WikiaBar.js and AdsInContext.js
		if (w.ads && w.ads.context) {
			w.ads.context = context;
		}
	}

	setContext(w.ads ? w.ads.context : {});

	return {
		getContext: getContext,
		setContext: setContext
	};
});
