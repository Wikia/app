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
import { billTheLizardWrapper } from './bill-the-lizard-wrapper';

function setupPageLevelTargeting(adsContext) {
	const pageLevelParams = targeting.getPageLevelTargeting(adsContext);

	Object.keys(pageLevelParams).forEach((key) => {
		context.set(`targeting.${key}`, pageLevelParams[key]);
	});
}

async function updateWadContext() {
	// BlockAdBlock detection
	const instantConfig = await InstantConfigService.init();

	context.set('options.wad.enabled', instantConfig.get('icBabDetection'));

	// showAds is undefined by default
	const serviceCanBeEnabled = !context.get('custom.noExternals') &&
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

	const instantConfig =  await InstantConfigService.init();

	context.set('wiki', wikiContext);
	context.set('options.disableAdStack', instantConfig.get('icDisableAdStack'));
	context.set('state.isSteam', utils.client.isSteamPlatform());

	const showAds = getReasonForNoAds() === null;

	context.set('state.showAds', showAds);
	context.set('custom.noExternals', window.wgNoExternals || utils.queryString.isUrlParamSet('noexternals'));
	context.set('custom.hiviLeaderboard', instantConfig.get('icHiViLeaderboardSlot'));

	if (context.get('wiki.opts.isAdTestWiki') && context.get('wiki.targeting.testSrc')) {
		context.set('src', context.get('wiki.targeting.testSrc'));
	} else if (context.get('wiki.opts.isAdTestWiki')) {
		context.set('src', 'test');
	}

	instantConfig.get('icLABradorTest');

	context.set('slots', slots.getContext());
	context.set('custom.hasFeaturedVideo', !!targeting.getVideoStatus().hasVideoOnPage);

	context.set('services.distroScale.enabled', instantConfig.get('icDistroScale'));
	context.set('custom.hasIncontentPlayer', slots.injectIncontentPlayer());

	if (context.get('custom.hasFeaturedVideo')) {
		context.set('slots.incontent_boxad_1.defaultSizes', [300, 250]);
	} else {
		slots.addSlotSize(context.get('custom.hiviLeaderboard') ? 'hivi_leaderboard' : 'top_leaderboard', [3, 3]);
	}

	const stickySlotsLines = instantConfig.get('icStickySlotLineItemIds');

	if (stickySlotsLines && stickySlotsLines.length) {
		context.set('templates.stickyTLB.lineItemIds', stickySlotsLines);
		context.push(`slots.${context.get('custom.hiviLeaderboard') ? 'hivi_leaderboard' : 'top_leaderboard'}.defaultTemplates`, 'stickyTLB');
	}

	context.set(
		'templates.safeFanTakeoverElement.lineItemIds',
		instantConfig.get('icSafeFanTakeoverLineItemIds'),
	);
	context.set(
		'templates.safeFanTakeoverElement.unstickTimeout',
		instantConfig.get('icSafeFanTakeoverUnstickTimeout'),
	);

	context.set('state.deviceType', utils.client.getDeviceType());

	context.set('options.billTheLizard.garfield', context.get('services.billTheLizard.enabled'));

	context.set('options.video.moatTracking.enabled', instantConfig.get('icPorvataMoatTracking'));
	//  During moving variables from WikiFactory to ICBM, options.video.moatTracking.sampling
	//  was set to 100 since in ad-engine it's being used in getMoatTrackingStatus() function.
	context.set('options.video.moatTracking.sampling', 100);

	context.set('options.video.playAdsOnNextVideo', !!instantConfig.get('icFeaturedVideoAdsFrequency'));
	context.set('options.video.adsOnNextVideoFrequency', instantConfig.get('icFeaturedVideoAdsFrequency'));
	context.set('options.video.isMidrollEnabled', instantConfig.get('icFeaturedVideoMidroll'));
	context.set('options.video.isPostrollEnabled', instantConfig.get('icFeaturedVideoPostroll'));
	context.set('options.video.comscoreJwpTracking', instantConfig.get('icComscoreJwpTracking'));

	context.set('options.maxDelayTimeout', instantConfig.get('icAdEngineDelay', 2000));
	context.set('options.tracking.kikimora.player', instantConfig.get('icPlayerTracking'));
	context.set('options.tracking.slot.status', instantConfig.get('icSlotTracking'));
	context.set('options.tracking.slot.viewability', instantConfig.get('icViewabilityTracking'));
	context.set('options.tracking.slot.bidder', instantConfig.get('icBidsTracking'));
	context.set('options.tracking.postmessage', true);
	context.set('options.tracking.tabId', instantConfig.get('icTabIdTracking'));

	context.set('options.trackingOptIn', consents.isOptedIn);
	context.set('options.geoRequiresConsent', consents.geoRequiresConsent);
	context.set('options.optOutSale', consents.isSaleOptOut);
	context.set('options.geoRequiresSignal', consents.geoRequiresSignal);
	context.set('options.isSubjectToCcpa', !!window.wgUserIsSubjectToCcpa);

	context.set('options.floatingMedrecDestroyable', instantConfig.get('icFloatingMedrecDestroyable'));

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

	context.set('services.audigent.enabled', instantConfig.get('icAudigent'));
	context.set('services.confiant.enabled', instantConfig.get('icConfiant'));
	context.set('services.durationMedia.enabled', instantConfig.get('icDurationMedia'));
	context.set('services.durationMedia.libraryUrl', instantConfig.get('icDurationMediaLibraryUrl'));
	context.set('services.facebookPixel.enabled', instantConfig.get('icFacebookPixel'));
	context.set('services.nielsen.enabled', instantConfig.get('icNielsen'));
	context.set('services.permutive.enabled', instantConfig.get('icPermutive') && !context.get('wiki.targeting.directedAtChildren'));
	context.set('services.iasPublisherOptimization.enabled', instantConfig.get('icIASPublisherOptimization'));

	context.set('options.video.moatTracking.enabledForArticleVideos', instantConfig.get('icFeaturedVideoMoatTracking'));
	context.set('options.video.iasTracking.enabled', instantConfig.get('icIASVideoTracking'));

	context.set(
		'options.jwplayerA9LoggerErrorCodes',
		instantConfig.get('icA9LoggerErrorCodes'),
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

		if (!instantConfig.get('icPrebidPubmaticOutstream')) {
			context.remove('bidders.prebid.pubmatic.slots.INCONTENT_PLAYER');
		}

		if (!instantConfig.get('icPrebidIndexExchangeFeatured')) {
			context.remove('bidders.prebid.indexExchange.slots.featured');
		}

		const priceFloorRule = instantConfig.get('icPrebidSizePriceFloorRule');
		context.set('bidders.prebid.priceFloor', priceFloorRule || null);

		context.set('bidders.liveRampId.enabled', instantConfig.get('icLiveRampId'));
		context.set('bidders.liveRampATS.enabled', instantConfig.get('icLiveRampATS'));
		context.set('bidders.liveRampATSAnalytics.enabled', instantConfig.get('icLiveRampATSAnalytics'));
	}

	if (instantConfig.get('icA9HiviLeaderboard')) {
		context.set('bidders.a9.slots.hivi_leaderboard', {
			sizes: [
				[728, 90],
				[970, 90],
			],
		});
	}

	if (instantConfig.get('icAdditionalVastSize')) {
		context.push('slots.featured.videoSizes', [480, 360]);
	}
	context.set('slots.featured.videoAdUnit', context.get('vast.adUnitIdWithDbName'));
	context.set('slots.incontent_player.videoAdUnit', context.get('vast.adUnitIdWithDbName'));
	context.set('slots.floor_adhesion.disabled', !instantConfig.get('icFloorAdhesion'));

	if (utils.geoService.isProperGeo(['AU', 'NZ'])) {
		context.set('custom.serverPrefix', 'vm1b');
	}

	const cacheStorage = InstantConfigCacheStorage.make();
	// Need to be placed always after all lABrador wgVars checks
	context.set('targeting.labrador', cacheStorage.mapSamplingResults(instantConfig.get('icLABradorGamKeyValues')));

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

	const instantConfig = await InstantConfigService.init();

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

function init(inhibitors) {
	const engine = new AdEngine();

	eventService.on(events.AD_SLOT_CREATED, (slot) => {
		context.onChange(`slots.${slot.getSlotName()}.audio`, () => slots.setupSlotParameters(slot));
		context.onChange(`slots.${slot.getSlotName()}.videoDepth`, () => slots.setupSlotParameters(slot));
	});

	engine.init(inhibitors);

	return engine;
}

export default {
	configure,
	init,
};
