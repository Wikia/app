import {
	AdEngine, context, events, eventService, instantConfig, slotInjector, templateService, utils, setupNpaContext,
	BigFancyAdAbove, BigFancyAdBelow, PorvataTemplate, Roadblock, StickyTLB,
} from '@wikia/ad-engine';
import { get, set } from 'lodash';
import basicContext from './ad-context';
import instantGlobals from './instant-globals';
import pageTracker from './tracking/page-tracker';
import slots from './slots';
import slotTracker from './tracking/slot-tracker';
import targeting from './targeting';
import viewabilityTracker from './tracking/viewability-tracker';
import { templateRegistry } from './templates/templates-registry';

const fallbackInstantConfig = {
	wgAdDriverUnstickHiViLeaderboardTimeout: 3000,
};

async function getAppConfiguration() {
	const config = await instantConfig.getConfig();

	const appConfig = {
		getInstantGlobal(key, defaultValue = null) {
			return get(config, key, instantGlobals.get(key, defaultValue));
		},
		isGeoEnabled(key) {
			return utils.geoService.isProperGeo(appConfig.getInstantGlobal(key), key);
		}
	};

	return appConfig;
}

function setupPageLevelTargeting(adsContext) {
	const pageLevelParams = targeting.getPageLevelTargeting(adsContext);

	Object.keys(pageLevelParams).forEach((key) => {
		context.set(`targeting.${key}`, pageLevelParams[key]);
	});
}

async function updateWadContext() {
	// BlockAdBlock detection
	const appConfig = await getAppConfiguration();
	const { isGeoEnabled } = appConfig;

	context.set('options.wad.enabled', isGeoEnabled('wgAdDriverBabDetectionDesktopCountries'));

	// showAds is undefined by default
	var serviceCanBeEnabled = !context.get('custom.noExternals') &&
		context.get('opts.showAds') !== false &&
		!window.wgUserName;

	if (serviceCanBeEnabled) {
		// BT rec
		context.set('options.wad.btRec.enabled', isGeoEnabled('wgAdDriverWadBTCountries'));

		// HMD rec
		context.set(
			'options.wad.hmdRec.enabled',
			context.get('custom.hasFeaturedVideo') && isGeoEnabled('wgAdDriverWadHMDCountries'),
		);
	}
}

async function setupAdContext(wikiContext, isOptedIn = false, geoRequiresConsent = true) {
	const showAds = getReasonForNoAds() === null;

	context.extend(basicContext);

	set(window, context.get('services.instantConfig.fallbackConfigKey'), fallbackInstantConfig);

	const appConfig =  await getAppConfiguration();
	const { getInstantGlobal, isGeoEnabled } = appConfig;

	context.set('wiki', wikiContext);
	context.set('state.showAds', showAds);
	context.set('custom.noExternals', window.wgNoExternals || utils.queryString.isUrlParamSet('noexternals'));
	context.set('custom.hasFeaturedVideo', !!context.get('wiki.targeting.hasFeaturedVideo'));
	context.set('custom.hiviLeaderboard', isGeoEnabled('wgAdDriverOasisHiviLeaderboardCountries'));

	if (context.get('wiki.opts.isAdTestWiki') && context.get('wiki.targeting.testSrc')) {
		// TODO: ADEN-8318 remove originalSrc and leave one value (testSrc)
		const originalSrc = context.get('src');
		context.set('src', [originalSrc, context.get('wiki.targeting.testSrc')]);
	} else if (context.get('wiki.opts.isAdTestWiki')) {
		context.set('src', 'test');
	}

	isGeoEnabled('wgAdDriverLABradorTestCountries');

	context.set('slots', slots.getContext());

	context.set('wiki.targeting.hasIncontentPlayer', slots.injectIncontentPlayer());

	if (wikiContext.targeting.hasFeaturedVideo) {
		context.set('slots.incontent_boxad_1.defaultSizes', [300, 250]);
	} else {
		slots.addSlotSize(context.get('custom.hiviLeaderboard') ? 'hivi_leaderboard' : 'top_leaderboard', [3, 3]);
	}

	/*
		ToDo: remove temporary stickyTLB prevention hack
		Original line:
		const stickySlotsLines = instantGlobals.get('wgAdDriverStickySlotsLines');
	*/
	const stickySlotsLines = utils.geoService.isProperGeo(['US', 'UK', 'GB', 'DE', 'PL']) ? getInstantGlobal('wgAdDriverStickySlotsLines') : [];

	if (stickySlotsLines && stickySlotsLines.length) {
		context.set('templates.stickyTLB.lineItemIds', stickySlotsLines);
		context.push(`slots.${context.get('custom.hiviLeaderboard') ? 'hivi_leaderboard' : 'top_leaderboard'}.defaultTemplates`, 'stickyTLB');
	}

	context.set('state.isSteam', false);
	context.set('state.deviceType', utils.client.getDeviceType());

	context.set('options.video.moatTracking.enabled', isGeoEnabled('wgAdDriverPorvataMoatTrackingCountries'));
	context.set('options.video.moatTracking.sampling', getInstantGlobal('wgAdDriverPorvataMoatTrackingSampling'));

	context.set('options.video.playAdsOnNextVideo', isGeoEnabled('wgAdDriverPlayAdsOnNextFVCountries'));
	context.set('options.video.adsOnNextVideoFrequency', getInstantGlobal('wgAdDriverPlayAdsOnNextFVFrequency') || 3);
	context.set('options.video.isMidrollEnabled', isGeoEnabled('wgAdDriverFVMidrollCountries'));
	context.set('options.video.isPostrollEnabled', isGeoEnabled('wgAdDriverFVPostrollCountries'));

	context.set('options.maxDelayTimeout', getInstantGlobal('wgAdDriverDelayTimeout', 2000));
	context.set('options.tracking.kikimora.player', isGeoEnabled('wgAdDriverKikimoraPlayerTrackingCountries'));
	context.set('options.tracking.kikimora.slot', isGeoEnabled('wgAdDriverKikimoraTrackingCountries'));
	context.set('options.tracking.kikimora.viewability', isGeoEnabled('wgAdDriverKikimoraViewabilityTrackingCountries'));
	context.set('options.trackingOptIn', isOptedIn);
	context.set('options.geoRequiresConsent', geoRequiresConsent);
	context.set('options.slotRepeater', true);

	context.set('options.incontentNative', isGeoEnabled('wgAdDriverNativeSearchDesktopCountries'));

	if (isGeoEnabled('wgAdDriverUnstickHiViLeaderboardAfterTimeoutCountries')) {
		context.set(
			'options.unstickHiViLeaderboardAfterTimeout',
			true,
		);
		context.set(
			'options.unstickHiViLeaderboardTimeout',
			true,
			getInstantGlobal('wgAdDriverUnstickHiViLeaderboardTimeout', 5000),
		);
	}

	context.set('services.confiant.enabled', isGeoEnabled('wgAdDriverConfiantDesktopCountries'));
	context.set('services.krux.enabled', context.get('wiki.targeting.enableKruxTargeting')
		&& isGeoEnabled('wgAdDriverKruxCountries') && !getInstantGlobal('wgSitewideDisableKrux'));
	context.set('services.moatYi.enabled', isGeoEnabled('wgAdDriverMoatYieldIntelligenceCountries'));
	context.set('services.nielsen.enabled', isGeoEnabled('wgAdDriverNielsenCountries'));

	const moatSampling = getInstantGlobal('wgAdDriverMoatTrackingForFeaturedVideoAdSampling');
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

	context.set('custom.hasPortableInfobox', !!context.get('wiki.targeting.hasPortableInfobox'));
	context.set('custom.pageType', context.get('wiki.targeting.pageType') || null);
	context.set('custom.isAuthenticated', !!context.get('wiki.user.isAuthenticated'));
	context.set('custom.isIncontentPlayerDisabled', context.get('wiki.opts.isIncontentPlayerDisabled'));
	context.set('custom.fmrRotatorDelay', getInstantGlobal('wgAdDriverFMRRotatorDelay', 10000));
	context.set('custom.fmrDelayDisabled', getInstantGlobal('wgAdDriverDisableFMRDelayOasisCountries'));
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
		context.set('bidders.prebid.beachfront.enabled', isGeoEnabled('wgAdDriverBeachfrontBidderCountries'));
		context.set('bidders.prebid.indexExchange.enabled', isGeoEnabled('wgAdDriverIndexExchangeBidderCountries'));
		context.set('bidders.prebid.kargo.enabled', isGeoEnabled('wgAdDriverKargoBidderCountries'));
		context.set('bidders.prebid.lkqd.enabled', isGeoEnabled('wgAdDriverLkqdBidderCountries'));
		context.set('bidders.prebid.onemobile.enabled', isGeoEnabled('wgAdDriverAolOneMobileBidderCountries'));
		context.set('bidders.prebid.openx.enabled', isGeoEnabled('wgAdDriverOpenXPrebidBidderCountries'));
		context.set('bidders.prebid.pubmatic.enabled', isGeoEnabled('wgAdDriverPubMaticBidderCountries'));
		context.set('bidders.prebid.rubicon_display.enabled', isGeoEnabled('wgAdDriverRubiconDisplayPrebidCountries'));
		context.set('bidders.prebid.vmg.enabled', isGeoEnabled('wgAdDriverVmgBidderCountries'));

		context.set('bidders.prebid.appnexusAst.enabled', isGeoEnabled('wgAdDriverAppNexusAstBidderCountries'));
		context.set('bidders.prebid.rubicon.enabled', isGeoEnabled('wgAdDriverRubiconPrebidCountries'));

		const s1 = context.get('wiki.targeting.wikiIsTop1000') ? context.get('targeting.s1') : 'not a top1k wiki';

		context.set('bidders.prebid.targeting', {
			src: ['gpt'],
			s0: [context.get('targeting.s0') || ''],
			s1: [s1],
			s2: [context.get('targeting.s2') || ''],
			lang: [context.get('targeting.wikiLanguage') || 'en'],
		});

		context.set('bidders.prebid.bidsRefreshing.enabled', context.get('options.slotRepeater'));
		context.set(
			'custom.rubiconInFV',
			isGeoEnabled('wgAdDriverRubiconPrebidCountries') && hasFeaturedVideo,
		);
		context.set('custom.isCMPEnabled', true);

		if (!isGeoEnabled('wgAdDriverLkqdOutstreamCountries')) {
			context.remove('bidders.prebid.lkqd.slots.INCONTENT_PLAYER');
		}

		if (!isGeoEnabled('wgAdDriverPubMaticOutstreamCountries')) {
			context.remove('bidders.prebid.pubmatic.slots.INCONTENT_PLAYER');
		}
	}

	if (isGeoEnabled('wgAdDriverAdditionalVastSizeCountries')) {
		context.push('slots.featured.videoSizes', [480, 360]);
	}
	context.set('slots.featured.videoAdUnit', context.get('vast.adUnitIdWithDbName'));
	context.set('slots.floor_adhesion.disabled', !isGeoEnabled('wgAdDriverOasisFloorAdhesionCountries'));

	if (utils.geoService.isProperGeo(['AU', 'NZ'])) {
		context.set('custom.serverPrefix', 'vm1b');
	}

	context.set('bidders.enabled', context.get('bidders.prebid.enabled') || context.get('bidders.a9.enabled'));
	context.set('services.netzathleten.enabled', isGeoEnabled('wgAdDriverNetzAthletenCountries'));

	// Need to be placed always after all lABrador wgVars checks
	context.set('targeting.labrador', utils.geoService.mapSamplingResults(getInstantGlobal('wgAdDriverLABradorDfpKeyvals')));

	slots.setupIdentificators();
	slots.setupStates();
	slots.setupSizesAvailability();
	slots.setupTopLeaderboard();

	updateWadContext();

	// TODO: Remove wrapper of window.adslots2 when we unify our push method
	utils.makeLazyQueue(window.adslots2, (slot) => {
		let slotName = slot;

		if (slot instanceof Array) {
			slotName = slot[0];
		} else if (typeof slot === 'object' && slot.slotName) {
			slotName = slot.slotName;
		}

		context.push('state.adStack', { id: slotName });
	});

	trackAdEngineStatus();

	window.adslots2.start();
}

async function configure(adsContext, isOptedIn) {
	await setupAdContext(adsContext, isOptedIn);
	setupNpaContext();

	templateRegistry.registerTemplates();

	context.push('listeners.slot', slotTracker);
	context.push('listeners.slot', viewabilityTracker);
}

/**
 * Checks state.showAds and sends to DW information about AdEngine status
 */
function trackAdEngineStatus() {
	if (context.get('state.showAds')) {
		pageTracker.trackProp('adengine', 'on_' + window.ads.adEngineVersion);
	} else {
		pageTracker.trackProp('adengine', 'off_' + getReasonForNoAds());
	}
}

function getReasonForNoAds() {
	const reasonFromBackend = window.ads.context.opts.noAdsReason || null;
	const pageType = window.ads.context.opts.pageType || null;

	if (reasonFromBackend === 'no_ads_user' && pageType === 'homepage_logged') {
		return null;
	}

	if (reasonFromBackend !== null) {
		return reasonFromBackend;
	}

	const possibleFrontendReasons = {
		'noads_querystring': !!utils.queryString.get('noads'),
		'noexternals_querystring': !!utils.queryString.get('noexternals'),
		// two above are probably not needed but data QA will confirm 3:-)
		'steam_browser': context.get('state.isSteam') === true,
	};

	const reasons = Object.keys(possibleFrontendReasons).filter(function (key) {
		return possibleFrontendReasons[key] === true;
	});

	return reasons.length > 0 ? reasons[0] : null;
}

function init() {
	const engine = new AdEngine();

	eventService.on(events.AD_SLOT_CREATED, (slot) => {
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
