import {
	AdEngine,
	context,
	events,
	eventService,
	fillerService,
	InstantConfigCacheStorage,
	InstantConfigService,
	PorvataFiller,
	setupNpaContext,
	setupRdpContext,
	utils,
	setupBidders
} from '@wikia/ad-engine';
import { set } from 'lodash';
import basicContext from './ad-context';
import pageTracker from './tracking/page-tracker';
import slots from './slots';
import targeting from './targeting';
import { templateRegistry } from './templates/templates-registry';
import {
	registerBidderTracker,
	registerPostmessageTrackingTracker,
	registerSlotTracker,
	registerViewabilityTracker
} from './tracking/tracker';
import * as fallbackInstantConfig from './fallback-config.json';
import { billTheLizardWrapper } from './bill-the-lizard-wrapper';

function setupPageLevelTargeting(adsContext) {
	const pageLevelParams = targeting.getPageLevelTargeting(adsContext);

	Object.keys(pageLevelParams).forEach((key) => {
		context.set(`targeting.${key}`, pageLevelParams[key]);
	});
}

async function updateWadContext() {
	// BlockAdBlock detection
	const instantConfig = await InstantConfigService.init(window.Wikia.InstantGlobals);

	context.set('options.wad.enabled', instantConfig.get('icBabDetection'));

	// showAds is undefined by default
	var serviceCanBeEnabled = !context.get('custom.noExternals') &&
		context.get('state.showAds') !== false &&
		!window.wgUserName;

	if (serviceCanBeEnabled) {
		// BT rec
		context.set('options.wad.btRec.enabled', instantConfig.get('icBTRec'));
	}
}

async function setupAdContext(wikiContext, consents) {
	utils.geoService.setUpGeoData();

	context.extend(basicContext);

	set(window, context.get('services.instantConfig.fallbackConfigKey'), fallbackInstantConfig);

	const instantConfig =  await InstantConfigService.init(window.Wikia.InstantGlobals);

	context.set('wiki', wikiContext);
	context.set('options.disableAdStack', instantConfig.get('icDisableAdStack'));
	context.set('state.isSteam', utils.client.isSteamPlatform());

	const showAds = getReasonForNoAds() === null;

	context.set('state.showAds', showAds);
	context.set('custom.noExternals', window.wgNoExternals || utils.queryString.isUrlParamSet('noexternals'));
	context.set('custom.hasFeaturedVideo', !!context.get('wiki.targeting.hasFeaturedVideo'));
	context.set('custom.hiviLeaderboard', instantConfig.isGeoEnabled('wgAdDriverOasisHiviLeaderboardCountries'));

	if (context.get('wiki.opts.isAdTestWiki') && context.get('wiki.targeting.testSrc')) {
		context.set('src', context.get('wiki.targeting.testSrc'));
	} else if (context.get('wiki.opts.isAdTestWiki')) {
		context.set('src', 'test');
	}

	instantConfig.isGeoEnabled('wgAdDriverLABradorTestCountries');

	context.set('slots', slots.getContext());

	context.set('wiki.targeting.hasIncontentPlayer', slots.injectIncontentPlayer());

	if (wikiContext.targeting.hasFeaturedVideo) {
		context.set('slots.incontent_boxad_1.defaultSizes', [300, 250]);
	} else {
		slots.addSlotSize(context.get('custom.hiviLeaderboard') ? 'hivi_leaderboard' : 'top_leaderboard', [3, 3]);
	}

	const stickySlotsLines = instantConfig.get('wgAdDriverStickySlotsLines');

	if (stickySlotsLines && stickySlotsLines.length) {
		context.set('templates.stickyTLB.lineItemIds', stickySlotsLines);
		context.push(`slots.${context.get('custom.hiviLeaderboard') ? 'hivi_leaderboard' : 'top_leaderboard'}.defaultTemplates`, 'stickyTLB');
	}

	context.set('state.deviceType', utils.client.getDeviceType());

	context.set('options.billTheLizard.garfield', context.get('services.billTheLizard.enabled'));

	context.set('options.video.moatTracking.enabled', instantConfig.isGeoEnabled('wgAdDriverPorvataMoatTrackingCountries'));
	context.set('options.video.moatTracking.sampling', instantConfig.get('wgAdDriverPorvataMoatTrackingSampling'));

	context.set('options.video.playAdsOnNextVideo', instantConfig.isGeoEnabled('wgAdDriverPlayAdsOnNextFVCountries'));
	context.set('options.video.adsOnNextVideoFrequency', instantConfig.get('wgAdDriverPlayAdsOnNextFVFrequency') || 3);
	context.set('options.video.isMidrollEnabled', instantConfig.isGeoEnabled('wgAdDriverFVMidrollCountries'));
	context.set('options.video.isPostrollEnabled', instantConfig.isGeoEnabled('wgAdDriverFVPostrollCountries'));

	context.set('options.maxDelayTimeout', instantConfig.get('wgAdDriverDelayTimeout', 2000));
	context.set('options.tracking.kikimora.player', instantConfig.isGeoEnabled('wgAdDriverKikimoraPlayerTrackingCountries'));
	context.set('options.tracking.slot.status', instantConfig.isGeoEnabled('wgAdDriverKikimoraTrackingCountries'));
	context.set('options.tracking.slot.viewability', instantConfig.isGeoEnabled('wgAdDriverKikimoraViewabilityTrackingCountries'));
	context.set('options.tracking.slot.bidder', instantConfig.get('icBidsTracking'));
	context.set('options.tracking.postmessage', true);
	context.set('options.tracking.tabId', instantConfig.get('icTabIdTracking'));

	context.set('options.trackingOptIn', consents.isOptedIn);
	context.set('options.geoRequiresConsent', consents.geoRequiresConsent);
	context.set('options.optOutSale', consents.isSaleOptOut);
	context.set('options.geoRequiresSignal', consents.geoRequiresSignal);

	if (instantConfig.get('icHiViLeaderboardUnstickTimeout')) {
		context.set(
			'options.unstickHiViLeaderboardAfterTimeout',
			true,
		);
		context.set(
			'options.unstickHiViLeaderboardTimeout',
			instantConfig.get('icHiViLeaderboardUnstickTimeout'),
		);
	}

	if (instantConfig.get('icPorvataDirect')) {
		context.set('slots.incontent_player.customFiller', 'porvata');
		context.set('slots.incontent_player.customFillerOptions', {
			enableInContentFloating: true,
		});
		fillerService.register(new PorvataFiller());
	}

	context.set('services.confiant.enabled', instantConfig.get('icConfiant'));
	context.set('services.durationMedia.enabled', instantConfig.get('icDurationMedia'));
	context.set('services.krux.enabled', context.get('wiki.targeting.enableKruxTargeting')
		&& instantConfig.isGeoEnabled('wgAdDriverKruxCountries') && !instantConfig.get('wgSitewideDisableKrux'));
	context.set('services.krux.trackedSegments', instantConfig.get('icKruxSegmentsTracking'));
	context.set('services.moatYi.enabled', instantConfig.isGeoEnabled('wgAdDriverMoatYieldIntelligenceCountries'));
	context.set('services.nielsen.enabled', instantConfig.isGeoEnabled('wgAdDriverNielsenCountries'));
	context.set('services.permutive.enabled', instantConfig.get('icPermutive'));

	if(instantConfig.get('icTaxonomyComicsTag')) {
		context.set('services.taxonomy.comics.enabled', true);
		context.set('services.taxonomy.communityId', context.get('wiki.targeting.wikiId'));
		context.set('services.taxonomy.pageArticleId', context.get('wiki.targeting.pageArticleId'));
	}

	const moatSampling = instantConfig.get('wgAdDriverMoatTrackingForFeaturedVideoAdSampling');
	const isMoatTrackingEnabledForVideo = instantConfig.isGeoEnabled('wgAdDriverMoatTrackingForFeaturedVideoAdCountries')
		&& utils.sampler.sample('moat_video_tracking', moatSampling);
	context.set('options.video.moatTracking.enabledForArticleVideos', isMoatTrackingEnabledForVideo);
	context.set(
		'options.video.moatTracking.additonalParamsEnabled',
		instantConfig.isGeoEnabled('wgAdDriverMoatTrackingForFeaturedVideoAdditionalParamsCountries'),
	);

	context.set('options.video.iasTracking.enabled', instantConfig.get('icIASVideoTracking'));

	setupPageLevelTargeting(context.get('wiki'));

	if (context.get('wiki.targeting.wikiIsTop1000')) {
		context.set('custom.wikiIdentifier', '_top1k_wiki');
		context.set('custom.dbNameForAdUnit', context.get('targeting.s1'));
	}

	context.set('custom.hasPortableInfobox', !!context.get('wiki.targeting.hasPortableInfobox'));
	context.set('custom.pageType', context.get('wiki.targeting.pageType') || null);
	context.set('custom.isAuthenticated', !!context.get('wiki.user.isAuthenticated'));
	context.set('custom.isIncontentPlayerDisabled', context.get('wiki.opts.isIncontentPlayerDisabled'));
	context.set('custom.fmrRotatorDelay', instantConfig.get('wgAdDriverFMRRotatorDelay', 10000));
	context.set('custom.fmrDelayDisabled', instantConfig.get('wgAdDriverDisableFMRDelayOasisCountries'));

	context.set('templates.stickyTLB.enabled', !context.get('custom.hasFeaturedVideo'));

	setupBidders(context, instantConfig);

	if (context.get('bidders.prebid.enabled')) {
		const s1 = context.get('wiki.targeting.wikiIsTop1000') ? context.get('targeting.s1') : 'not a top1k wiki';

		context.set('bidders.prebid.targeting', {
			src: ['gpt'],
			s0: [context.get('targeting.s0') || ''],
			s1: [s1],
			s2: [context.get('targeting.s2') || ''],
			lang: [context.get('targeting.wikiLanguage') || 'en'],
		});

		if (!instantConfig.get('icPrebidLkqdOutstream')) {
			context.remove('bidders.prebid.lkqd.slots.INCONTENT_PLAYER');
		}

		if (!instantConfig.get('icPrebidPubmaticOutstream')) {
			context.remove('bidders.prebid.pubmatic.slots.INCONTENT_PLAYER');
		}

		const priceFloorRule = instantConfig.get('icPrebidSizePriceFloorRule');
		context.set('bidders.prebid.priceFloor', priceFloorRule || null);
	}

	if (instantConfig.isGeoEnabled('wgAdDriverAdditionalVastSizeCountries')) {
		context.push('slots.featured.videoSizes', [480, 360]);
	}
	context.set('slots.featured.videoAdUnit', context.get('vast.adUnitIdWithDbName'));
	context.set('slots.incontent_player.videoAdUnit', context.get('vast.adUnitIdWithDbName'));
	context.set('slots.floor_adhesion.disabled', !instantConfig.isGeoEnabled('wgAdDriverOasisFloorAdhesionCountries'));

	if (utils.geoService.isProperGeo(['AU', 'NZ'])) {
		context.set('custom.serverPrefix', 'vm1b');
	}

	const cacheStorage = InstantConfigCacheStorage.make();
	// Need to be placed always after all lABrador wgVars checks
	context.set('targeting.labrador', cacheStorage.mapSamplingResults(instantConfig.get('wgAdDriverLABradorDfpKeyvals')));

	slots.setupIdentificators();
	slots.setupStates();
	slots.setupSizesAvailability();
	slots.setupTopLeaderboard();

	await updateWadContext();

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

async function configure(adsContext, consents) {
	await setupAdContext(adsContext, consents);
	setupNpaContext();
	setupRdpContext();

	templateRegistry.registerTemplates();

	registerSlotTracker();
	registerBidderTracker();
	registerViewabilityTracker();
	registerPostmessageTrackingTracker();

	const instantConfig = await InstantConfigService.init(window.Wikia.InstantGlobals);

	billTheLizardWrapper.configureBillTheLizard(instantConfig.get('wgAdDriverBillTheLizardConfig', {}));
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
		'steam_browser': context.get('state.isSteam'),
		'ad_stack_disabled': context.get('options.disableAdStack'),
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
