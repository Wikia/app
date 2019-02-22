import { AdEngine, context, events, templateService, utils } from '@wikia/ad-engine';
import { utils as adProductsUtils, BigFancyAdAbove, BigFancyAdBelow, PorvataTemplate, Roadblock, StickyTLB } from '@wikia/ad-engine/dist/ad-products';
import basicContext from './ad-context';
import instantGlobals from './instant-globals';
import slots, { hasLowerSlotNames } from './slots';
import slotTracker from './tracking/slot-tracker';
import targeting from './targeting';
import viewabilityTracker from './tracking/viewability-tracker';
import { templateRegistry } from './templates/templates-registry';

function setupPageLevelTargeting(adsContext) {
	const pageLevelParams = targeting.getPageLevelTargeting(adsContext);

	Object.keys(pageLevelParams).forEach((key) => {
		context.set(`targeting.${key}`, pageLevelParams[key]);
	});
}

function updateWadContext() {
	// BlockAdBlock detection
	context.set('options.wad.enabled', isGeoEnabled('wgAdDriverBabDetectionDesktopCountries'));

	// showAds is undefined by default
	var serviceCanBeEnabled = !context.get('custom.noExternals') &&
		context.get('opts.showAds') !== false &&
		!window.wgUserName &&
		!context.get('opts.delayBlocked');

	if (serviceCanBeEnabled) {
		// BT rec
		context.set('options.wad.btRec.enabled', isGeoEnabled('wgAdDriverWadBTCountries'));

		// HMD rec
		context.set('options.wad.hmdRec.enabled', context.get('custom.hasFeaturedVideo') && isGeoEnabled('wgAdDriverWadHMDCountries'));
	}

	// TODO: Remove me after 24h
	if (!hasLowerSlotNames) {
		const placementsMap = context.get('options.wad.btRec.placementsMap');

		Object.keys(placementsMap).forEach((slotName) => {
			placementsMap[slotName.toUpperCase()] = placementsMap[slotName];
			delete placementsMap[slotName];
		});
	}
}

function isGeoEnabled(key) {
	return utils.isProperGeo(instantGlobals.get(key), key);
}

function setupAdContext(wikiContext, isOptedIn = false, geoRequiresConsent = true) {
	const showAds = window.ads.context.opts.showAds;

	context.extend(basicContext);
	context.set('wiki', wikiContext);
	context.set('state.showAds', showAds);
	context.set('custom.noExternals', window.wgNoExternals || utils.queryString.isUrlParamSet('noexternals'));

	if (context.get('wiki.opts.isAdTestWiki') && context.get('wiki.targeting.testSrc')) {
		// TODO: ADEN-8318 remove originalSrc and leave one value (testSrc)
		const originalSrc = context.get('src');
		context.set('src', [originalSrc, context.get('wiki.targeting.testSrc')]);
	} else if (context.get('wiki.opts.isAdTestWiki')) {
		context.set('src', 'test');
	}

	isGeoEnabled('wgAdDriverLABradorTestCountries');

	context.set('slots', slots.getContext());

	if (!wikiContext.targeting.hasFeaturedVideo && wikiContext.targeting.pageType !== 'search') {
		slots.addSlotSize('hivi_leaderboard', [3, 3]);
	}

	const stickySlotsLines = instantGlobals.get('wgAdDriverStickySlotsLines');

	if (stickySlotsLines && stickySlotsLines.length) {
		context.set('templates.stickyTLB.lineItemIds', stickySlotsLines);
		context.push('slots.hivi_leaderboard.defaultTemplates', 'stickyTLB');
	}

	context.set('state.isSteam', false);
	context.set('state.deviceType', utils.client.getDeviceType());

	if (context.get('state.isSteam')) {
		context.set('state.showAds', false);
	}

	context.set('options.video.moatTracking.enabled', isGeoEnabled('wgAdDriverPorvataMoatTrackingCountries'));
	context.set('options.video.moatTracking.sampling', instantGlobals.get('wgAdDriverPorvataMoatTrackingSampling'));

	context.set('options.video.playAdsOnNextVideo', isGeoEnabled('wgAdDriverPlayAdsOnNextFVCountries'));
	context.set('options.video.adsOnNextVideoFrequency', instantGlobals.get('wgAdDriverPlayAdsOnNextFVFrequency') || 3);
	context.set('options.video.isMidrollEnabled', isGeoEnabled('wgAdDriverFVMidrollCountries'));
	context.set('options.video.isPostrollEnabled', isGeoEnabled('wgAdDriverFVPostrollCountries'));

	context.set('options.maxDelayTimeout', instantGlobals.get('wgAdDriverDelayTimeout', 2000));
	context.set('options.tracking.kikimora.player', isGeoEnabled('wgAdDriverKikimoraPlayerTrackingCountries'));
	context.set('options.tracking.kikimora.slot', isGeoEnabled('wgAdDriverKikimoraTrackingCountries'));
	context.set('options.tracking.kikimora.viewability', isGeoEnabled('wgAdDriverKikimoraViewabilityTrackingCountries'));
	context.set('options.trackingOptIn', isOptedIn);
	context.set('options.geoRequiresConsent', geoRequiresConsent);

	context.set('services.geoEdge.enabled', isGeoEnabled('wgAdDriverGeoEdgeCountries'));
	context.set('services.krux.enabled', context.get('wiki.targeting.enableKruxTargeting')
		&& isGeoEnabled('wgAdDriverKruxCountries') && !instantGlobals.get('wgSitewideDisableKrux'));
	context.set('services.moatYi.enabled', isGeoEnabled('wgAdDriverMoatYieldIntelligenceCountries'));
	context.set('services.nielsen.enabled', isGeoEnabled('wgAdDriverNielsenCountries'));

	const moatSampling = instantGlobals.get('wgAdDriverMoatTrackingForFeaturedVideoAdSampling');
	const isMoatTrackingEnabledForVideo = isGeoEnabled('wgAdDriverMoatTrackingForFeaturedVideoAdCountries')
		&& utils.sampler.sample('moat_video_tracking', moatSampling);
	context.set('options.video.moatTracking.enabledForArticleVideos', isMoatTrackingEnabledForVideo);
	context.set(
		'options.video.moatTracking.additonalParamsEnabled',
		isGeoEnabled('wgAdDriverMoatTrackingForFeaturedVideoAdditionalParamsCountries'),
	);

	setupPageLevelTargeting(context.get('wiki'));

	if (context.get('wiki.targeting.wikiIsTop1000')) {
		context.set('custom.wikiIdentifier', '_top1k_wiki');
		context.set('custom.dbNameForAdUnit', context.get('targeting.s1'));
	}
	context.set('custom.hasFeaturedVideo', !!context.get('wiki.targeting.hasFeaturedVideo'));
	context.set('custom.hasPortableInfobox', !!context.get('wiki.targeting.hasPortableInfobox'));
	context.set('custom.pageType', context.get('wiki.targeting.pageType') || null);
	context.set('custom.isAuthenticated', !!context.get('wiki.user.isAuthenticated'));
	context.set('custom.isIncontentPlayerDisabled', context.get('wiki.opts.isIncontentPlayerDisabled'));
	context.set('custom.beachfrontDfp', isGeoEnabled('wgAdDriverBeachfrontDfpCountries'));
	context.set('custom.lkqdDfp', isGeoEnabled('wgAdDriverLkqdBidderCountries'));
	context.set('custom.pubmaticDfp', isGeoEnabled('wgAdDriverPubMaticDfpCountries'));

	const hasFeaturedVideo = context.get('custom.hasFeaturedVideo');
	context.set('bidders.a9.enabled', isGeoEnabled('wgAdDriverA9BidderCountries'));
	context.set('bidders.a9.dealsEnabled', isGeoEnabled('wgAdDriverA9DealsCountries'));
	context.set('bidders.a9.videoEnabled', isGeoEnabled('wgAdDriverA9VideoBidderCountries') && hasFeaturedVideo);

	if (hasFeaturedVideo) {
		context.set('templates.stickyTLB.enabled', false);
	}

	if (isGeoEnabled('wgAdDriverPrebidBidderCountries')) {
		context.set('bidders.prebid.enabled', true);
		context.set('bidders.prebid.aol.enabled', isGeoEnabled('wgAdDriverAolBidderCountries'));
		context.set('bidders.prebid.appnexus.enabled', isGeoEnabled('wgAdDriverAppNexusBidderCountries'));
		context.set('bidders.prebid.audienceNetwork.enabled', isGeoEnabled('wgAdDriverAudienceNetworkBidderCountries'));
		context.set('bidders.prebid.beachfront.enabled', isGeoEnabled('wgAdDriverBeachfrontBidderCountries'));
		context.set('bidders.prebid.indexExchange.enabled', isGeoEnabled('wgAdDriverIndexExchangeBidderCountries'));
		context.set('bidders.prebid.kargo.enabled', isGeoEnabled('wgAdDriverKargoBidderCountries'));
		context.set('bidders.prebid.lkqd.enabled', isGeoEnabled('wgAdDriverLkqdBidderCountries'));
		context.set('bidders.prebid.onemobile.enabled', isGeoEnabled('wgAdDriverAolOneMobileBidderCountries'));
		context.set('bidders.prebid.openx.enabled', isGeoEnabled('wgAdDriverOpenXPrebidBidderCountries'));
		context.set('bidders.prebid.pubmatic.enabled', isGeoEnabled('wgAdDriverPubMaticBidderCountries'));
		context.set('bidders.prebid.rubiconDisplay.enabled', isGeoEnabled('wgAdDriverRubiconDisplayPrebidCountries'));

		context.set('bidders.prebid.appnexusAst.enabled', isGeoEnabled('wgAdDriverAppNexusAstBidderCountries'));
		context.set('bidders.prebid.rubicon.enabled', isGeoEnabled('wgAdDriverRubiconPrebidCountries'));

		const s1 = context.get('wiki.targeting.wikiIsTop1000') ? context.get('targeting.s1') : 'not a top1k wiki';

		context.set('bidders.prebid.targeting', {
			src: ['mobile'],
			s0: [context.get('targeting.s0') || ''],
			s1: [s1],
			s2: [context.get('targeting.s2') || ''],
			lang: [context.get('targeting.wikiLanguage') || 'en'],
		});

		context.set('bidders.prebid.bidsRefreshing.enabled', context.get('options.slotRepeater'));
		context.set('custom.rubiconInFV',
			isGeoEnabled('wgAdDriverRubiconVideoInFeaturedVideoCountries') && hasFeaturedVideo);
		context.set('custom.isCMPEnabled', true);
	}

	if (isGeoEnabled('wgAdDriverAdditionalVastSizeCountries')) {
		context.push('slots.featured.videoSizes', [480, 360]);
	}
	context.set('slots.featured.videoAdUnit', context.get('vast.adUnitIdWithDbName'));

	if (utils.isProperGeo(['AU', 'NZ'])) {
		context.set('custom.serverPrefix', 'vm1b');
	}

	context.set('bidders.enabled', context.get('bidders.prebid.enabled') || context.get('bidders.a9.enabled'));
	context.set('services.netzathleten.enabled', isGeoEnabled('wgAdDriverNetzAthletenCountries'));

	// Need to be placed always after all lABrador wgVars checks
	context.set('targeting.labrador', utils.mapSamplingResults(instantGlobals.get('wgAdDriverLABradorDfpKeyvals')));

	slots.setupIdentificators();
	slots.setupStates();
	slots.setupSizesAvailability();
	slots.setupTopLeaderboard();

	updateWadContext();

	// TODO: Remove me after 24h
	if (!hasLowerSlotNames) {
		const slotsDefinition = context.get('slots');

		Object.keys(slotsDefinition).forEach((slotName) => {
			slotsDefinition[slotName.toUpperCase()] = slotsDefinition[slotName];
		});
	}

	// TODO: Remove wrapper of window.adslots2 when we unify our push method
	utils.makeLazyQueue(window.adslots2, (slot) => {
		let slotName = slot;

		if (slot instanceof Array) {
			slotName = slot[0];
		} else if (typeof slot === 'string') {
			slotName = slot.slotName;
		}

		context.push('state.adStack', { id: slotName })
	});
	window.adslots2.start();
}

function configure(adsContext, isOptedIn) {
	setupAdContext(adsContext, isOptedIn);
	adProductsUtils.setupNpaContext();

	templateRegistry.registerTemplates();

	context.push('listeners.slot', slotTracker);
	context.push('listeners.slot', viewabilityTracker);
}

function init() {
	const engine = new AdEngine();

	events.on(events.AD_SLOT_CREATED, (slot) => {
		context.onChange(`slots.${slot.getSlotName()}.audio`, () => slots.setupSlotParameters(slot));
		context.onChange(`slots.${slot.getSlotName()}.videoDepth`, () => slots.setupSlotParameters(slot));
	});

	engine.init();

	return engine;
}

export default {
	configure,
	init,
};
