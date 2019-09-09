import * as Cookies from 'js-cookie';
import {
	AdEngine,
	context,
	events,
	eventService,
	fillerService,
	geoCacheStorage,
	InstantConfigService,
	PorvataFiller,
	setupNpaContext,
	utils,
	setupBidders
} from '@wikia/ad-engine';
import { set } from 'lodash';
import basicContext from './ad-context';
import pageTracker from './tracking/page-tracker';
import slots from './slots';
import targeting from './targeting';
import { templateRegistry } from './templates/templates-registry';
import {registerPostmessageTrackingTracker, registerSlotTracker, registerViewabilityTracker} from './tracking/tracker';
import * as fallbackInstantConfig from './fallback-config.json';

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

		// HMD rec
		context.set(
			'options.wad.hmdRec.enabled',
			context.get('custom.hasFeaturedVideo') && instantConfig.isGeoEnabled('wgAdDriverWadHMDCountries'),
		);
	}
}

async function setupAdContext(wikiContext, isOptedIn = false, geoRequiresConsent = true) {
	const showAds = getReasonForNoAds() === null;

	utils.geoService.setUpGeoData();

	context.extend(basicContext);

	set(window, context.get('services.instantConfig.fallbackConfigKey'), fallbackInstantConfig);

	const instantConfig =  await InstantConfigService.init(window.Wikia.InstantGlobals);

	context.set('wiki', wikiContext);
	context.set('state.showAds', showAds);
	context.set('custom.noExternals', window.wgNoExternals || utils.queryString.isUrlParamSet('noexternals'));
	context.set('custom.hasFeaturedVideo', !!context.get('wiki.targeting.hasFeaturedVideo'));
	context.set('custom.hiviLeaderboard', instantConfig.isGeoEnabled('wgAdDriverOasisHiviLeaderboardCountries'));

	if (context.get('wiki.opts.isAdTestWiki') && context.get('wiki.targeting.testSrc')) {
		// TODO: ADEN-8318 remove originalSrc and leave one value (testSrc)
		const originalSrc = context.get('src');
		context.set('src', [originalSrc, context.get('wiki.targeting.testSrc')]);
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

	context.set('state.isSteam', false);
	context.set('state.deviceType', utils.client.getDeviceType());

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
	context.set('options.tracking.postmessage', true);
	context.set('options.trackingOptIn', isOptedIn);
	context.set('options.geoRequiresConsent', geoRequiresConsent);
	context.set('options.slotRepeater', true);

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
		fillerService.register(new PorvataFiller());
	}

	context.set('services.confiant.enabled', instantConfig.get('icConfiant'));
	context.set('services.krux.enabled', context.get('wiki.targeting.enableKruxTargeting')
		&& instantConfig.isGeoEnabled('wgAdDriverKruxCountries') && !instantConfig.get('wgSitewideDisableKrux'));
	context.set('services.moatYi.enabled', instantConfig.isGeoEnabled('wgAdDriverMoatYieldIntelligenceCountries'));
	context.set('services.nielsen.enabled', instantConfig.isGeoEnabled('wgAdDriverNielsenCountries'));

	const moatSampling = instantConfig.get('wgAdDriverMoatTrackingForFeaturedVideoAdSampling');
	const isMoatTrackingEnabledForVideo = instantConfig.isGeoEnabled('wgAdDriverMoatTrackingForFeaturedVideoAdCountries')
		&& utils.sampler.sample('moat_video_tracking', moatSampling);
	context.set('options.video.moatTracking.enabledForArticleVideos', isMoatTrackingEnabledForVideo);
	context.set(
		'options.video.moatTracking.additonalParamsEnabled',
		instantConfig.isGeoEnabled('wgAdDriverMoatTrackingForFeaturedVideoAdditionalParamsCountries'),
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
	context.set('custom.fmrRotatorDelay', instantConfig.get('wgAdDriverFMRRotatorDelay', 10000));
	context.set('custom.fmrDelayDisabled', instantConfig.get('wgAdDriverDisableFMRDelayOasisCountries'));

	setupBidders(context, instantConfig);

	if (context.get('custom.isIncontentPlayerDisabled')) {
		const s1 = context.get('wiki.targeting.wikiIsTop1000') ? context.get('targeting.s1') : 'not a top1k wiki';

		context.set('bidders.prebid.targeting', {
			src: ['gpt'],
			s0: [context.get('targeting.s0') || ''],
			s1: [s1],
			s2: [context.get('targeting.s2') || ''],
			lang: [context.get('targeting.wikiLanguage') || 'en'],
		});
		context.set('custom.isCMPEnabled', true);
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

	context.set('services.netzathleten.enabled', instantConfig.isGeoEnabled('wgAdDriverNetzAthletenCountries'));

	// Need to be placed always after all lABrador wgVars checks
	context.set('targeting.labrador', geoCacheStorage.mapSamplingResults(instantConfig.get('wgAdDriverLABradorDfpKeyvals')));

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

async function configure(adsContext, isOptedIn) {
	await setupAdContext(adsContext, isOptedIn);
	setupNpaContext();

	templateRegistry.registerTemplates();

	registerSlotTracker();
	registerViewabilityTracker();
	registerPostmessageTrackingTracker();
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
