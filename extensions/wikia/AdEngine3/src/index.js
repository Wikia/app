import { v4 as uuid } from 'uuid';
import { biddersDelay } from './bidders/bidders-delay';
import { billTheLizardConfigurator } from './ml/configuration';
import { isAutoPlayDisabled } from './ml/executor';
import {
	AdSlot,
	bidders,
	billTheLizard,
	confiant,
	context,
	events,
	eventService,
	InstantConfigCacheStorage,
	jwplayerAdsFactory,
	krux,
	moatYi,
	moatYiEvents,
	nielsen,
	SlotTweaker,
	utils
} from '@wikia/ad-engine';
import { babDetection } from './wad/bab-detection';
import { recRunner } from './wad/rec-runner';
import { hmdLoader } from './wad/hmd-loader';
import ads from './setup';
import pageTracker from './tracking/page-tracker';
import slots from './slots';
import videoTracker from './tracking/video-tracking';
import { contextReadyResolver } from "./utils/context-ready";
import { track } from "./tracking/tracker";

const GPT_LIBRARY_URL = '//www.googletagservices.com/tag/js/gpt.js';

let contextConfiguredTrigger;
/**
 * Resolves with ad-engine context once it's been configured.
 * @type {Promise}
 */
const contextConfigured = new Promise((resolve) => {
	contextConfiguredTrigger = resolve;
});

async function setupAdEngine(isOptedIn, geoRequiresConsent) {
	const wikiContext = window.ads.context;

	await ads.configure(wikiContext, isOptedIn, geoRequiresConsent);
	contextReadyResolver();

	videoTracker.register();
	recRunner.init();

	context.push('delayModules', babDetection);
	context.push('delayModules', biddersDelay);

	contextConfiguredTrigger(context);

	eventService.on(events.AD_SLOT_CREATED, (slot) => {
		console.info(`Created ad slot ${slot.getSlotName()}`);
		bidders.updateSlotTargeting(slot.getSlotName());
	});
	eventService.on(moatYiEvents.MOAT_YI_READY, (data) => {
		pageTracker.trackProp('moat_yi', data);
	});


	await billTheLizardConfigurator.configure();

	if (context.get('state.showAds')) {
		callExternals();
		startAdEngine();
	} else {
		window.wgAfterContentAndJS.push(hideAllAdSlots);
	}

	trackLabradorValues();
	trackLikhoToDW();
	trackTabId();
	trackXClick();
}

function startAdEngine() {
	if (context.get('state.showAds')) {
		utils.scriptLoader.loadScript(GPT_LIBRARY_URL);

		ads.init();

		window.wgAfterContentAndJS.push(() => {
			slots.injectBottomLeaderboard();
			babDetection.run();
		});
		slots.injectHighImpact();
		slots.injectFloorAdhesion();

		eventService.on(AdSlot.SLOT_RENDERED_EVENT, (slot) => {
			slot.getElement().classList.remove('default-height');
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
function trackLikhoToDW() {
	const likhoPropValue = context.get('targeting.likho') || [];

	if (likhoPropValue.length) {
		pageTracker.trackProp('likho', likhoPropValue.join(';'));
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

	bidders.requestBids({
		responseListener: biddersDelay.markAsReady,
	});

	confiant.call();
	krux.call();
	moatYi.call();
	billTheLizard.call(['queen_of_hearts', 'vcr']);
	nielsen.call({
		type: 'static',
		assetid: `fandom.com/${targeting.s0v}/${targeting.s1}/${targeting.artid}`,
		section: `FANDOM ${targeting.s0v.toUpperCase()} NETWORK`,
	});
}

function run() {
	window.Wikia.consentQueue = window.Wikia.consentQueue || [];
	window.Wikia.consentQueue.push(setupAdEngine);
}

function waitForBiddersResolve() {
	if (!context.get('state.showAds')) {
		return Promise.resolve();
	}

	const timeout = new Promise((resolve) => {
		setTimeout(resolve, context.get('options.maxDelayTimeout'));
	});

	return Promise.race([ timeout, biddersDelay.getPromise() ]);
}

function waitForAdStackResolve() {
	return contextConfigured.then(waitForBiddersResolve);
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

export {
	context,
	contextConfigured,
	hmdLoader,
	jwplayerAdsFactory,
	krux,
	isAutoPlayDisabled,
	run,
	slots,
	waitForAdStackResolve,
}
