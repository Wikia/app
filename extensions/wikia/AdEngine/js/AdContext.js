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

	var context,
		callbacks = [];

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
		context.targeting = context.targeting || {};
		context.providers = context.providers || {};
		context.forceProviders = context.forceProviders || {};

		// Don't show ads when Sony requests the page
		if (doc && doc.referrer && doc.referrer.match(/info\.tvsideview\.sony\.net/)) {
			context.opts.showAds = false;
		}

		// Use PostScribe for ScriptWriter implementation when SevenOne Media ads are enabled
		if (context.providers.sevenOneMedia) {
			context.opts.usePostScribe = true;
		}

		// Always call DART
		// TODO: make mobile code compatible with desktop (currently one uses opts and the other providers)
		// TODO: clean up in ADEN-1785
		context.opts.alwaysCallDart = true;
		context.providers.remnantGptMobile = true;

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
		if (context.forceProviders.turtle) {
			context.providers.turtle = true;
		}

		if (instantGlobals.wgAdDriverUseTurtleInCountries &&
				instantGlobals.wgAdDriverUseTurtleInCountries.indexOf &&
				instantGlobals.wgAdDriverUseTurtleInCountries.indexOf(geo.getCountryCode()) > -1
					) {
			context.providers.turtle = true;
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
