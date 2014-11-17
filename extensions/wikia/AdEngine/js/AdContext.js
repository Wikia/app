/*global define,require*/
/**
 * The AMD module to hold all the context needed for the client-side scripts to run.
 */
define('ext.wikia.adEngine.adContext', [
	'wikia.document', 'wikia.geo', require.optional('wikia.instantGlobals'), 'wikia.window'
], function (doc, geo, instantGlobals, w) {
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

		// Export the context back to ads.context
		// Only used by Lightbox.js, WikiaBar.js and AdsInContext.js
		if (w.ads && w.ads.context) {
			w.ads.context = context;
		}
	}

	setContext(w.ads ? w.ads.context : {
		opts: {
			adsAfterInfobox: w.wgAdDriverUseAdsAfterInfobox,
			adsInHead: w.wgLoadAdsInHead,
			disableLateQueue: w.wgAdEngineDisableLateQueue,
			lateAdsAfterPageLoad: w.wgLoadLateAdsAfterPageLoad,
			pageType: w.adEnginePageType,
			showAds: w.wgShowAds,
			usePostScribe: w.wgUsePostScribe,
			trackSlotState: w.wgAdDriverTrackState
		},

		targeting: {
			enableKruxTargeting: w.wgEnableKruxTargeting,
			kruxCategoryId: w.wgKruxCategoryId,

			pageArticleId: w.wgArticleId,
			pageIsArticle: !!w.wgArticleId,
			pageIsHub: w.wikiaPageIsHub,
			pageName: w.wgPageName,
			pageType: w.wikiaPageType,

			sevenOneMediaSub2Site: w.wgAdDriverSevenOneMediaOverrideSub2Site,
			skin: w.skin,

			wikiCategory: w.cityShort,
			wikiCustomKeyValues: w.wgDartCustomKeyValues,
			wikiDbName: w.wgDBname,
			wikiDirectedAtChildren: w.wgWikiDirectedAtChildren,
			wikiIsTop1000: w.wgAdDriverWikiIsTop1000,
			wikiLanguage: w.wgContentLanguage,
			wikiVertical: w.cscoreCat
		},

		providers: {
			sevenOneMedia: w.wgAdDriverUseSevenOneMedia,
			sevenOneMediaCombinedUrl: w.wgAdDriverSevenOneMediaCombinedUrl,
			remnantGptMobile: w.wgAdDriverEnableRemnantGptMobile,
			taboola: w.wgAdDriverUseTaboola
		},

		slots: {
			bottomLeaderboardImpressionCapping: w.wgAdDriverBottomLeaderboardImpressionCapping
		},

		// TODO: make it like forceadprovider=liftium
		forceProviders: {
			directGpt: w.wgAdDriverForceDirectGptAd,
			liftium: w.wgAdDriverForceLiftiumAd
		}
	});

	return {
		getContext: getContext,
		setContext: setContext
	};
});
