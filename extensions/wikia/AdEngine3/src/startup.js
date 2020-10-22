import { v4 as uuid } from 'uuid';
import { billTheLizardConfigurator } from './ml/configuration';
import { featuredVideoAutoPlayDisabled } from './ml/executor';
import {
	AdSlot,
	audigent,
	bidders,
	billTheLizard,
	confiant,
	context,
	durationMedia,
	events,
	eventService,
	facebookPixel,
	iasPublisherOptimization,
	InstantConfigCacheStorage,
	JWPlayerManager,
	nielsen,
	permutive,
	Runner,
	SlotTweaker,
	utils
} from '@wikia/ad-engine';
import { wadRunner } from './wad/wad-runner';
import ads from './setup';
import pageTracker from './tracking/page-tracker';
import slots from './slots';
import videoTracker from './tracking/video-tracking';
import { track } from "./tracking/tracker";
import { communicationService } from "./communication/communication-service";
import { ofType } from "./communication/of-type";

const GPT_LIBRARY_URL = '//www.googletagservices.com/tag/js/gpt.js';

export async function setupAdEngine(
	isOptedIn = false,
	geoRequiresConsent = true,
	isSaleOptOut = false,
	geoRequiresSignal = true,
) {
	const wikiContext = window.ads.context;

	await ads.configure(wikiContext, { isOptedIn, geoRequiresConsent, isSaleOptOut, geoRequiresSignal });

	slots.injectIncontentBoxad();
	videoTracker.register();

	eventService.on(events.AD_SLOT_CREATED, (slot) => {
		console.info(`Created ad slot ${slot.getSlotName()}`);
		bidders.updateSlotTargeting(slot.getSlotName());
	});

	await billTheLizardConfigurator.configure();

	if (context.get('state.showAds')) {
		const inhibitors = callExternals();

		setupJWPlayer(inhibitors);
		startAdEngine(inhibitors);
	} else {
		dispatchJWPlayerSetupAction(false);
		window.wgAfterContentAndJS.push(hideAllAdSlots);
	}

	trackLabradorValues();
	trackTabId();
	trackXClick();
	trackVideoPage();
}

async function setupJWPlayer(inhibitors = []) {
	new JWPlayerManager().manage();

	const maxTimeout = context.get('options.maxDelayTimeout');
	const runner = new Runner(inhibitors, maxTimeout, 'jwplayer-runner');

	runner.waitForInhibitors().then(() => {
		dispatchJWPlayerSetupAction();
	});
}

function dispatchJWPlayerSetupAction(showAds = true) {
	communicationService.dispatch({
		type: '[Ad Engine] Setup JWPlayer',
		showAds,
		autoplayDisabled: featuredVideoAutoPlayDisabled
	});
}

function startAdEngine(inhibitors) {
	if (context.get('state.showAds')) {
		utils.scriptLoader.loadScript(GPT_LIBRARY_URL);

		ads.init(inhibitors);

		window.wgAfterContentAndJS.push(() => {
			slots.injectBottomLeaderboard();
		});
		slots.injectHighImpact();
		slots.injectFloorAdhesion();
		slots.injectAffiliateSlot();

		eventService.on(AdSlot.SLOT_RENDERED_EVENT, (slot) => {
			slot.getElement().classList.remove('default-height');
		});

		communicationService.action$.pipe(
			ofType('[AdEngine] Audigent loaded')
		).subscribe((props) => {
			pageTracker.trackProp('audigent', 'loaded');
		});

		communicationService.action$.pipe(
			ofType('[AdEngine] LiveRamp Prebid ids loaded')
		).subscribe((props) => {
			pageTracker.trackProp('live_ramp_prebid_ids', props.userId);
		});
	}
}

function trackLabradorValues() {
	const cacheStorage = InstantConfigCacheStorage.make();
	const labradorPropValue = cacheStorage.getSamplingResults().join(';');

	if (labradorPropValue) {
		pageTracker.trackProp('labrador', labradorPropValue);
	}
}

/**
 * @private
 */
function trackTabId() {
	if (!context.get('options.tracking.tabId')) {
		return;
	}

	window.tabId = sessionStorage.tab_id ? sessionStorage.tab_id : sessionStorage.tab_id = uuid();

	pageTracker.trackProp('tab_id', window.tabId);
}

function callExternals() {
	const targeting = context.get('targeting');
	const inhibitors = [];

	inhibitors.push(bidders.requestBids());
	inhibitors.push(wadRunner.call());

	facebookPixel.call();
	permutive.call();
	iasPublisherOptimization.call();
	audigent.call();
	confiant.call();
	durationMedia.call();
	billTheLizard.call(['queen_of_hearts', 'vcr']);
	nielsen.call({
		type: 'static',
		assetid: `fandom.com/${targeting.s0v}/${targeting.s1}/${targeting.artid}`,
		section: `FANDOM ${targeting.s0v.toUpperCase()} NETWORK`,
	});

	return inhibitors;
}

function hideAllAdSlots() {
	Object.keys(context.get('slots')).forEach((slotName) => {
		const element = document.getElementById(slotName);

		if (element) {
			element.classList.add('hidden');
		}
	});
}

function trackXClick() {
	eventService.on(AdSlot.CUSTOM_EVENT, (adSlot, { status }) => {
		if (status === SlotTweaker.SLOT_CLOSE_IMMEDIATELY || status === 'force-unstick') {
			track({
				action: 'click',
				category: 'force_close',
				label: adSlot.getSlotName(),
				trackingMethod: 'analytics',
			});
		}
	});
}

function trackVideoPage() {
	const s2 = context.get('targeting.s2');

	if (['fv-article', 'wv-article'].includes(s2)) {
		track(Object.assign(
			{
				eventName: 'videoplayerevent',
				trackingMethod: 'internal',
			}, {
				category: 'featured-video',
				action: 'pageview',
				label: s2,
			},
		));
	}
}
