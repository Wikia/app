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
	'ext.wikia.adEngine.geo',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.window',
	'wikia.querystring'
], function (browserDetect, cookies, doc, geo, instantGlobals, adsGeo, sampler, w, Querystring) {
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

	function isBabDetectionDesktopEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverBabDetectionDesktopCountries);
	}

	function isBabDetectionMobileEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverBabDetectionMobileCountries);
	}

	function updateDetectionServicesAdContext(context, noExternals) {
		// PageFair detection
		context.opts.pageFairDetection = !noExternals && isPageFairDetectionEnabled();

		// BlockAdBlock detection
		context.opts.babDetectionDesktop = !noExternals && isBabDetectionDesktopEnabled();
		context.opts.babDetectionMobile = !noExternals && isBabDetectionMobileEnabled();
	}

	function updateAdContextRecoveryServices(context, noExternals) {
		var isRecoveryServiceAlreadyEnabled = false,
			serviceCanBeEnabled = !noExternals && context.opts.showAds !== false && !areDelayServicesBlocked(); // showAds is undefined by default

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

		// BlockAdBlock recovery
		context.opts.babRecovery = serviceCanBeEnabled && geo.isProperGeo(instantGlobals.wgAdDriverBabRecoveryCountries);
	}

	function isProperGeo(name) {
		var geos = instantGlobals[name] || [];
		return adsGeo.isProperGeo(geos, name);
	}

	function updateAdContextRabbitExperiments(context) {
		context.rabbits.ctpDesktop = isProperGeo('wgAdDriverCTPDesktopRabbitCountries');
	}

	function areDelayServicesBlocked() {
		return context.targeting.skin === 'mercury' && isProperGeo('wgAdDriverBlockDelayServicesCountries');
	}

	function updateAdContextBidders(context) {
		var hasFeaturedVideo = context.targeting.hasFeaturedVideo;

		context.bidders.prebid = !areDelayServicesBlocked() && isProperGeo('wgAdDriverPrebidBidderCountries');
		context.bidders.a9 = !areDelayServicesBlocked() && isProperGeo('wgAdDriverA9BidderCountries');
		context.bidders.a9Video = !areDelayServicesBlocked() && isProperGeo('wgAdDriverA9VideoBidderCountries');
		context.bidders.rubiconDisplay = isProperGeo('wgAdDriverRubiconDisplayPrebidCountries');
		context.bidders.rubicon = isProperGeo('wgAdDriverRubiconPrebidCountries');
		context.bidders.rubiconInFV = isProperGeo('wgAdDriverRubiconVideoInFeaturedVideoCountries') && hasFeaturedVideo;
		context.bidders.beachfront = isProperGeo('wgAdDriverBeachfrontBidderCountries') && !hasFeaturedVideo;
		context.bidders.appnexusAst = isProperGeo('wgAdDriverAppNexusAstBidderCountries') && !hasFeaturedVideo;
		context.bidders.aol = isProperGeo('wgAdDriverAolBidderCountries');
		context.bidders.appnexus = isProperGeo('wgAdDriverAppNexusBidderCountries');
		context.bidders.appnexusWebAds = isProperGeo('wgAdDriverAppNexusWebAdsBidderCountries');
		context.bidders.audienceNetwork = isProperGeo('wgAdDriverAudienceNetworkBidderCountries');
		context.bidders.indexExchange = isProperGeo('wgAdDriverIndexExchangeBidderCountries');
		context.bidders.onemobile = isProperGeo('wgAdDriverAolOneMobileBidderCountries');
		context.bidders.openx = isProperGeo('wgAdDriverOpenXPrebidBidderCountries');
		context.bidders.pubmatic = isProperGeo('wgAdDriverPubMaticBidderCountries');
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
		context.rabbits = context.rabbits || {};
		context.forcedProvider = qs.getVal('forcead', null) || context.forcedProvider || null;
		context.opts.noExternals = noExternals;

		// Don't show ads when Sony requests the page
		if (referrerIsSonySite()) {
			context.opts.showAds = false;
		}

		context.opts.delayEngine = true;
		context.opts.overwriteDelayEngine = isProperGeo('wgAdDriverDelayCountries');

		context.opts.premiumOnly = context.targeting.hasFeaturedVideo &&
			geo.isProperGeo(instantGlobals.wgAdDriverSrcPremiumCountries);

		context.opts.isMoatTrackingForFeaturedVideoEnabled = isMOATTrackingForFVEnabled();
		updateDetectionServicesAdContext(context, noExternals);
		updateAdContextRecoveryServices(context, noExternals);

		updateAdContextBidders(context);
		updateAdContextRabbitExperiments(context);

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

		context.providers.turtle = isProperGeo('wgAdDriverTurtleCountries');

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

		context.opts.isNewPrebidEnabled = geo.isProperGeo(instantGlobals.wgAdDriverNewPrebidCountries);

		// Krux integration
		context.targeting.enableKruxTargeting = !!(
			context.targeting.enableKruxTargeting &&
			isProperGeo('wgAdDriverKruxCountries') && !instantGlobals.wgSitewideDisableKrux
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

		context.opts.isFVDelayEnabled = !areDelayServicesBlocked() && geo.isProperGeo(instantGlobals.wgAdDriverFVDelayCountries);
		context.opts.isFVUapKeyValueEnabled = geo.isProperGeo(instantGlobals.wgAdDriverFVAsUapKeyValueCountries);
		context.opts.isFVMidrollEnabled = geo.isProperGeo(instantGlobals.wgAdDriverFVMidrollCountries);
		context.opts.isFVPostrollEnabled = geo.isProperGeo(instantGlobals.wgAdDriverFVPostrollCountries);
		context.opts.replayAdsForFV = geo.isProperGeo(instantGlobals.wgAdDriverPlayAdsOnNextFVCountries);
		context.opts.fvAdsFrequency = fvAdsFrequency !== undefined ? fvAdsFrequency : 3;
		context.opts.disableSra = geo.isProperGeo(instantGlobals.wgAdDriverDisableSraCountries);
		context.opts.isBLBLazyPrebidEnabled = context.targeting.skin === 'oasis' &&
			geo.isProperGeo(instantGlobals.wgAdDriverBottomLeaderBoardLazyPrebidCountries);
		context.opts.isBLBMegaEnabled = geo.isProperGeo(instantGlobals.wgAdDriverBottomLeaderBoardMegaCountries);
		context.opts.isBLBViewportEnabled =
			geo.isProperGeo(instantGlobals.wgAdDriverBottomLeaderBoardViewportCountries);
		context.opts.additionalBLBSizes =
			geo.isProperGeo(instantGlobals.wgAdDriverBottomLeaderBoardAdditionalSizesCountries);

		context.opts.labradorTest = isProperGeo('wgAdDriverLABradorTestCountries');
		context.opts.labradorTestGroup = context.opts.labradorTest ? 'B' : 'A';
		context.opts.mobileSectionsCollapse = isProperGeo('wgAdDriverMobileSectionsCollapseCountries');
		context.opts.netzathleten = isProperGeo('wgAdDriverNetzAthletenCountries');

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

	setContext((w.ads && w.ads.context) ? w.ads.context : {});

	return {
		get: get,
		addCallback: addCallback,
		getContext: getContext,
		setContext: setContext
	};
});
