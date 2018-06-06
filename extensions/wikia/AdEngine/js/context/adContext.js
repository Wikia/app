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
		qs = new Querystring(),
		useNewGeo = geo.isProperGeo(instantGlobals.wgAdDriverNewGeoCountries);

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

	function isBabDetectionDesktopEnabled() {
		return isProperGeo('wgAdDriverBabDetectionDesktopCountries');
	}

	function isBabDetectionMobileEnabled() {
		return isProperGeo('wgAdDriverBabDetectionMobileCountries');
	}

	function updateDetectionServicesAdContext(context, noExternals) {
		// BlockAdBlock detection
		context.opts.babDetectionDesktop = !noExternals && isBabDetectionDesktopEnabled();
		context.opts.babDetectionMobile = !noExternals && isBabDetectionMobileEnabled();
	}

	function updateAdContextRecoveryServices(context, noExternals) {
		var serviceCanBeEnabled = !noExternals && context.opts.showAds !== false && !areDelayServicesBlocked(); // showAds is undefined by default

		// BlockAdBlock recovery
		context.opts.babRecovery = serviceCanBeEnabled && isProperGeo('wgAdDriverBabRecoveryCountries');
	}

	function isProperGeo(name) {
		var geos = instantGlobals[name] || [];

		if (useNewGeo) {
			return isProperGeoAds(name)
		}

		return geo.isProperGeo(geos);
	}

	function isProperGeoAds(name) {
		var geos = instantGlobals[name] || [];
		return adsGeo.isProperGeo(geos, name);
	}

	function updateAdContextRabbitExperiments(context) {
		context.rabbits.ctpDesktop = isProperGeoAds('wgAdDriverCTPDesktopRabbitCountries');
		context.rabbits.ctpMobile = isProperGeoAds('wgAdDriverCTPMobileRabbitCountries');
	}

	function areDelayServicesBlocked() {
		return context.targeting.skin === 'mercury' && isProperGeoAds('wgAdDriverBlockDelayServicesCountries');
	}

	function updateAdContextBidders(context) {
		var hasFeaturedVideo = context.targeting.hasFeaturedVideo;

		context.bidders.prebid = !areDelayServicesBlocked() && isProperGeoAds('wgAdDriverPrebidBidderCountries');
		context.bidders.a9 = !areDelayServicesBlocked() && isProperGeoAds('wgAdDriverA9BidderCountries');
		context.bidders.a9Video = !areDelayServicesBlocked() && isProperGeoAds('wgAdDriverA9VideoBidderCountries');
		context.bidders.rubiconDisplay = isProperGeoAds('wgAdDriverRubiconDisplayPrebidCountries');
		context.bidders.rubicon = isProperGeoAds('wgAdDriverRubiconPrebidCountries');
		context.bidders.rubiconInFV = isProperGeoAds('wgAdDriverRubiconVideoInFeaturedVideoCountries') && hasFeaturedVideo;
		context.bidders.beachfront = isProperGeoAds('wgAdDriverBeachfrontBidderCountries') && !hasFeaturedVideo;
		context.bidders.appnexusAst = isProperGeoAds('wgAdDriverAppNexusAstBidderCountries') && !hasFeaturedVideo;
		context.bidders.aol = isProperGeoAds('wgAdDriverAolBidderCountries');
		context.bidders.appnexus = isProperGeoAds('wgAdDriverAppNexusBidderCountries');
		context.bidders.appnexusWebAds = isProperGeoAds('wgAdDriverAppNexusWebAdsBidderCountries');
		context.bidders.audienceNetwork = isProperGeoAds('wgAdDriverAudienceNetworkBidderCountries');
		context.bidders.indexExchange = isProperGeoAds('wgAdDriverIndexExchangeBidderCountries');
		context.bidders.onemobile = isProperGeoAds('wgAdDriverAolOneMobileBidderCountries');
		context.bidders.openx = isProperGeoAds('wgAdDriverOpenXPrebidBidderCountries');
		context.bidders.pubmatic = isProperGeoAds('wgAdDriverPubMaticBidderCountries');
	}

	function referrerIsSonySite() {
		return doc && doc.referrer && doc.referrer.match(/info\.tvsideview\.sony\.net/);
	}

	function isMOATTrackingForFVEnabled() {
		var samplingForMoatFV = instantGlobals.wgAdDriverMoatTrackingForFeaturedVideoAdSampling || 1;

		return sampler.sample('moatTrackingForFeaturedVideo', samplingForMoatFV, 100) &&
			isProperGeo('wgAdDriverMoatTrackingForFeaturedVideoAdCountries');
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
		context.opts.overwriteDelayEngine = isProperGeoAds('wgAdDriverDelayCountries');

		context.opts.premiumOnly = context.targeting.hasFeaturedVideo && isProperGeo('wgAdDriverSrcPremiumCountries');

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
			context.providers.evolve2 = isProperGeo('wgAdDriverEvolve2Countries');
		}

		context.providers.turtle = isProperGeoAds('wgAdDriverTurtleCountries');

		context.opts.enableRemnantNewAdUnit = isProperGeo('wgAdDriverMEGACountries');

		// INVISIBLE_HIGH_IMPACT slot
		context.slots.invisibleHighImpact = (
				context.slots.invisibleHighImpact &&
				isProperGeo('wgAdDriverHighImpactSlotCountries')
			) || isUrlParamSet('highimpactslot');

		// AdInfo warehouse logging
		context.opts.kikimoraViewabilityTracking =
			isProperGeo('wgAdDriverKikimoraViewabilityTrackingCountries');
		context.opts.enableAdInfoLog = isProperGeo('wgAdDriverKikimoraTrackingCountries');
		context.opts.playerTracking = isProperGeo('wgAdDriverKikimoraPlayerTrackingCountries');

		// New Prebid and CMP
		context.opts.isNewPrebidEnabled = isProperGeo('wgAdDriverNewPrebidCountries');
		context.opts.isConsentStringEnabled = isProperGeo('wgAdDriverConsentStringCountries');

		// Krux integration
		context.targeting.enableKruxTargeting = !!(
			context.targeting.enableKruxTargeting &&
			isProperGeoAds('wgAdDriverKruxCountries') && !instantGlobals.wgSitewideDisableKrux
		);

		// Floating medrec
		context.opts.floatingMedrec = !!(
			context.opts.showAds && context.opts.adsInContent &&
			(isPageType('article') || isPageType('search')) && !context.targeting.wikiIsCorporate
		);

		context.opts.outstreamVideoFrequencyCapping = instantGlobals.wgAdDriverOutstreamVideoFrequencyCapping;
		context.opts.porvataMoatTrackingEnabled = isProperGeo('wgAdDriverPorvataMoatTrackingCountries');
		context.opts.porvataMoatTrackingSampling = instantGlobals.wgAdDriverPorvataMoatTrackingSampling || 0;

		context.opts.megaAdUnitBuilderEnabled = context.targeting.hasFeaturedVideo && isProperGeo('wgAdDriverMegaAdUnitBuilderForFVCountries');

		context.opts.isFVDelayEnabled = !areDelayServicesBlocked() && isProperGeo('wgAdDriverFVDelayCountries');
		context.opts.isFVUapKeyValueEnabled = isProperGeo('wgAdDriverFVAsUapKeyValueCountries');
		context.opts.isFVMidrollEnabled = isProperGeo('wgAdDriverFVMidrollCountries');
		context.opts.isFVPostrollEnabled = isProperGeo('wgAdDriverFVPostrollCountries');
		context.opts.replayAdsForFV = isProperGeo('wgAdDriverPlayAdsOnNextFVCountries');
		context.opts.fvAdsFrequency = fvAdsFrequency !== undefined ? fvAdsFrequency : 3;
		context.opts.disableSra = isProperGeo('wgAdDriverDisableSraCountries');
		context.opts.isBLBLazyPrebidEnabled = context.targeting.skin === 'oasis' &&
			isProperGeo('wgAdDriverBottomLeaderBoardLazyPrebidCountries');
		context.opts.isBLBMegaEnabled = isProperGeo('wgAdDriverBottomLeaderBoardMegaCountries');
		context.opts.isBLBViewportEnabled =
			isProperGeo('wgAdDriverBottomLeaderBoardViewportCountries');
		context.opts.additionalBLBSizes =
			isProperGeo('wgAdDriverBottomLeaderBoardAdditionalSizesCountries');
		context.opts.isBLBSingleSizeForUAPEnabled = isProperGeoAds('wgAdDriverSingleBLBSizeForUAPCountries');

		context.opts.labradorTest = isProperGeoAds('wgAdDriverLABradorTestCountries');
		context.opts.labradorTestGroup = context.opts.labradorTest ? 'B' : 'A';
		context.opts.mobileSectionsCollapse = isProperGeoAds('wgAdDriverMobileSectionsCollapseCountries');
		context.opts.netzathleten = isProperGeoAds('wgAdDriverNetzAthletenCountries');

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
