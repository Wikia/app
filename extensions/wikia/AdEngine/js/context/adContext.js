/*global define*/
/**
 * The AMD module to hold all the context needed for the client-side scripts to run.
 */
define('ext.wikia.adEngine.adContext', [
	'wikia.browserDetect',
	'wikia.cookies',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.window',
	'wikia.querystring'
], function (browserDetect, cookies, instantGlobals, adEngineBridge, sampler, w, Querystring) {
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

	function isBabDetectionDesktopEnabled() {
		return isEnabled('wgAdDriverBabDetectionDesktopCountries');
	}

	function isBabDetectionMobileEnabled() {
		return isEnabled('wgAdDriverBabDetectionMobileCountries');
	}

	function updateDetectionServicesAdContext(context, noExternals) {
		// BlockAdBlock detection
		context.opts.babDetectionDesktop = !noExternals && isBabDetectionDesktopEnabled();
		context.opts.babDetectionMobile = !noExternals && isBabDetectionMobileEnabled();
	}

	function isILSupportedBrowser() {
		return browserDetect.isChrome() && browserDetect.getBrowserVersion() > 45;
	}

	function updateAdContextRecServices(context, noExternals) {
		// showAds is undefined by default
		var serviceCanBeEnabled = !noExternals &&
			context.opts.showAds !== false &&
			!w.wgUserName &&
			context.targeting.skin === 'oasis' &&
			!context.opts.delayBlocked;

		// BT rec
		context.opts.wadBT = serviceCanBeEnabled &&
			isEnabled('wgAdDriverWadBTCountries');

		// IL rec
		context.opts.wadIL = serviceCanBeEnabled &&
			isEnabled('wgAdDriverWadILCountries') &&
			isILSupportedBrowser();

		// HMD rec
		context.opts.wadHMD = serviceCanBeEnabled &&
			context.targeting.hasFeaturedVideo &&
			isEnabled('wgAdDriverWadHMDCountries');
	}

	function isEnabled(name) {
		var geos = instantGlobals[name] || [];
		return adEngineBridge.geo.isProperGeo(geos, name);
	}

	function updateAdContextRabbitExperiments(context) {
		context.rabbits.ctpDesktop = isEnabled('wgAdDriverCTPDesktopRabbitCountries');
		context.rabbits.ctpMobile = isEnabled('wgAdDriverCTPMobileRabbitCountries');
		context.rabbits.queenDesktop = isEnabled('wgAdDriverCTPDesktopQueenCountries');
	}

	function areDelayServicesBlocked() {
		return context.targeting.skin === 'mercury' && isEnabled('wgAdDriverBlockDelayServicesCountries');
	}

	function updateAdContextBidders(context) {
		var hasFeaturedVideo = context.targeting.hasFeaturedVideo;

		context.bidders.prebid = !areDelayServicesBlocked() && isEnabled('wgAdDriverPrebidBidderCountries');
		context.bidders.prebidOptOut = isEnabled('wgAdDriverPrebidOptOutCountries');
		context.bidders.a9 = !areDelayServicesBlocked() && isEnabled('wgAdDriverA9BidderCountries');
		context.bidders.a9Deals = isEnabled('wgAdDriverA9DealsCountries');
		context.bidders.a9OptOut = isEnabled('wgAdDriverA9OptOutCountries');
		context.bidders.a9Video = !areDelayServicesBlocked() && isEnabled('wgAdDriverA9VideoBidderCountries');
		context.bidders.rubiconDisplay = isEnabled('wgAdDriverRubiconDisplayPrebidCountries');
		context.bidders.rubicon = isEnabled('wgAdDriverRubiconPrebidCountries');
		context.bidders.rubiconDfp = isEnabled('wgAdDriverRubiconDfpCountries');
		context.bidders.rubiconInFV = isEnabled('wgAdDriverRubiconVideoInFeaturedVideoCountries') && hasFeaturedVideo;
		context.bidders.beachfront = isEnabled('wgAdDriverBeachfrontBidderCountries') && !hasFeaturedVideo;
		context.bidders.appnexusAst = isEnabled('wgAdDriverAppNexusAstBidderCountries');
		context.bidders.aol = isEnabled('wgAdDriverAolBidderCountries');
		context.bidders.appnexus = isEnabled('wgAdDriverAppNexusBidderCountries');
		context.bidders.appnexusDfp = isEnabled('wgAdDriverAppNexusDfpCountries');
		context.bidders.audienceNetwork = isEnabled('wgAdDriverAudienceNetworkBidderCountries');
		context.bidders.indexExchange = isEnabled('wgAdDriverIndexExchangeBidderCountries');
		context.bidders.kargo = isEnabled('wgAdDriverKargoBidderCountries');
		context.bidders.onemobile = isEnabled('wgAdDriverAolOneMobileBidderCountries');
		context.bidders.openx = isEnabled('wgAdDriverOpenXPrebidBidderCountries');
		context.bidders.pubmatic = isEnabled('wgAdDriverPubMaticBidderCountries');
		context.bidders.pubmaticDfp = isEnabled('wgAdDriverPubMaticDfpCountries');
	}

	function isMOATTrackingForFVEnabled() {
		var samplingForMoatFV = instantGlobals.wgAdDriverMoatTrackingForFeaturedVideoAdSampling || 1;

		return sampler.sample('moatTrackingForFeaturedVideo', samplingForMoatFV, 100) &&
			isEnabled('wgAdDriverMoatTrackingForFeaturedVideoAdCountries');
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
		context.templates = context.templates || {};
		context.opts.noExternals = noExternals;

		context.opts.delayEngine = true;
		context.opts.delayBlocked = areDelayServicesBlocked();
		context.opts.overwriteDelayEngine = isEnabled('wgAdDriverDelayCountries');

		context.opts.premiumOnly = context.targeting.hasFeaturedVideo;

		context.opts.isMoatTrackingForFeaturedVideoEnabled = isMOATTrackingForFVEnabled();
		context.opts.isMoatTrackingForFeaturedVideoAdditionalParamsEnabled = isEnabled(
			'wgAdDriverMoatTrackingForFeaturedVideoAdditionalParamsCountries'
		);

		updateDetectionServicesAdContext(context, noExternals);
		updateAdContextRecServices(context, noExternals);

		updateAdContextBidders(context);
		updateAdContextRabbitExperiments(context);

		// *.showcase.wikia.com
		if (cookies.get('mock-ads') === 'NlfdjR5xC0') {
			context.opts.showcase = true;
		}

		// Targeting by page categories
		if (context.targeting.enablePageCategories) {
			context.targeting.pageCategories = w.wgCategories || getMercuryCategories();
		}

		context.opts.enableRemnantNewAdUnit = isEnabled('wgAdDriverMEGACountries');

		// INVISIBLE_HIGH_IMPACT slot
		context.slots.invisibleHighImpact = (
				context.slots.invisibleHighImpact && isEnabled('wgAdDriverHighImpactSlotCountries')
			) || isUrlParamSet('highimpactslot');

		context.slots.invisibleHighImpact2 = !context.targeting.hasFeaturedVideo &&
			isEnabled('wgAdDriverHighImpact2SlotCountries');

		// AdInfo warehouse logging
		context.opts.kikimoraViewabilityTracking = isEnabled('wgAdDriverKikimoraViewabilityTrackingCountries');
		context.opts.enableAdInfoLog = isEnabled('wgAdDriverKikimoraTrackingCountries');
		context.opts.playerTracking = isEnabled('wgAdDriverKikimoraPlayerTrackingCountries');

		// Krux integration
		context.targeting.enableKruxTargeting = !!(
			context.targeting.enableKruxTargeting &&
			isEnabled('wgAdDriverKruxCountries') && !instantGlobals.wgSitewideDisableKrux
		);
		context.opts.kruxNewParams = isEnabled('wgAdDriverKruxNewParamsCountries');

		// Floating medrec
		context.opts.floatingMedrec = !!(
			context.opts.showAds && context.opts.adsInContent &&
			(isPageType('article') || isPageType('search')) && !context.targeting.wikiIsCorporate
		);

		context.opts.outstreamVideoFrequencyCapping = instantGlobals.wgAdDriverOutstreamVideoFrequencyCapping;
		context.opts.porvataMoatTrackingEnabled = isEnabled('wgAdDriverPorvataMoatTrackingCountries');
		context.opts.porvataMoatTrackingSampling = instantGlobals.wgAdDriverPorvataMoatTrackingSampling || 0;

		context.opts.megaAdUnitBuilderEnabled = context.targeting.hasFeaturedVideo &&
			isEnabled('wgAdDriverMegaAdUnitBuilderForFVCountries');

		context.opts.isScrollDepthTrackingEnabled = isEnabled('wgAdDriverScrollDepthTrackingCountries');

		context.opts.isFVDelayEnabled = !context.opts.delayBlocked && isEnabled('wgAdDriverFVDelayCountries');
		context.opts.isFVUapKeyValueEnabled = isEnabled('wgAdDriverFVAsUapKeyValueCountries');
		context.opts.isFVMidrollEnabled = isEnabled('wgAdDriverFVMidrollCountries');
		context.opts.isFVPostrollEnabled = isEnabled('wgAdDriverFVPostrollCountries');
		context.opts.replayAdsForFV = isEnabled('wgAdDriverPlayAdsOnNextFVCountries');
		context.opts.fvAdsFrequency = fvAdsFrequency !== undefined ? fvAdsFrequency : 3;
		context.opts.disableSra = true;
		context.opts.isBLBLazyPrebidEnabled = context.targeting.skin === 'oasis' &&
			isEnabled('wgAdDriverBottomLeaderBoardLazyPrebidCountries');
		context.opts.additionalBLBSizes = isEnabled('wgAdDriverBottomLeaderBoardAdditionalSizesCountries');
		context.opts.isBLBSingleSizeForUAPEnabled = isEnabled('wgAdDriverSingleBLBSizeForUAPCountries');
		context.opts.isDesktopBfabStickinessEnabled = isEnabled('wgAdDriverBfabStickinessOasisCountries') &&
			context.targeting.skin === 'oasis';

		context.opts.isSteamBrowser = browserDetect.isSteam();
		context.opts.labradorTest = isEnabled('wgAdDriverLABradorTestCountries');
		context.opts.labradorTestGroup = context.opts.labradorTest ? 'B' : 'A';
		context.opts.mobileSectionsCollapse = isEnabled('wgAdDriverMobileSectionsCollapseCountries');
		context.opts.netzathleten = isEnabled('wgAdDriverNetzAthletenCountries');
		context.opts.additionalVastSize = isEnabled('wgAdDriverAdditionalVastSizeCountries');
		context.opts.incontentPlayerRail = {
			enabled: context.targeting.skin === 'oasis' && isEnabled('wgAdDriverIncontentPlayerRailCountries'),
			trackingAlias: 'INCONTENT_PLAYER_RAIL',
			conflictingSlots: [
				'TOP_BOXAD',
				'INCONTENT_BOXAD_1',
				'BOTTOM_LEADERBOARD'
			]
		};

		context.opts.stickySlotsLines = instantGlobals.wgAdDriverStickySlotsLines;

		context.opts.moatYi = isEnabled('wgAdDriverMoatYieldIntelligenceCountries');

		// Need to be placed always after all lABrador wgVars checks
		context.opts.labradorDfp = adEngineBridge.geo.mapSamplingResults(instantGlobals.wgAdDriverLABradorDfpKeyvals);

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
		setContext: setContext,
		isEnabled: isEnabled
	};
});
