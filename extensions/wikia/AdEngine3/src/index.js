import { biddersDelay } from './bidders/bidders-delay';
import { billTheLizardConfigurator } from './ml/configuration';
import { isAutoPlayDisabled } from './ml/executor';
import { context, events, eventService, utils } from '@wikia/ad-engine';
import { bidders } from '@wikia/ad-engine/dist/ad-bidders';
import { billTheLizard, krux, moatYi, moatYiEvents, nielsen } from '@wikia/ad-engine/dist/ad-services';
import { babDetection } from './wad/bab-detection';
import { recRunner } from './wad/rec-runner';
import { hmdLoader } from './wad/hmd-loader';
import ads from './setup';
import pageTracker from './tracking/page-tracker';
import slots from './slots';
import videoTracker from './tracking/video-tracking';

import './styles.scss';

const GPT_LIBRARY_URL = '//www.googletagservices.com/tag/js/gpt.js';

function setupAdEngine(isOptedIn, geoRequiresConsent) {
	const wikiContext = window.ads.context;

	ads.configure(wikiContext, isOptedIn, geoRequiresConsent);
	videoTracker.register();
	recRunner.init();

	context.push('delayModules', babDetection);
	context.push('delayModules', biddersDelay);

	eventService.on(events.AD_SLOT_CREATED, (slot) => {
		console.info(`Created ad slot ${slot.getSlotName()}`);
		bidders.updateSlotTargeting(slot.getSlotName());
	});
	eventService.on(moatYiEvents.MOAT_YI_READY, (data) => {
		pageTracker.trackProp('moat_yi', data);
	});

	billTheLizardConfigurator.configure();

	if (context.get('state.showAds')) {
		callExternals();
		startAdEngine();
	} else {
		window.wgAfterContentAndJS.push(hideAllAdSlots);
	}

	trackLabradorValues();
	trackLikhoToDW();
}

function startAdEngine() {
	if (context.get('wiki.opts.showAds')) {
		utils.scriptLoader.loadScript(GPT_LIBRARY_URL);

		ads.init();

		window.wgAfterContentAndJS.push(() => {
			slots.injectBottomLeaderboard();
			babDetection.run();
		});
		slots.injectHighImpact();

		context.push('listeners.slot', {
			onRenderEnded: (slot) => {
				slot.getElement().classList.remove('default-height');
			}
		});
	}
}

function trackLabradorValues() {
	const labradorPropValue = utils.geoService.getSamplingResults().join(';');

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

function callExternals() {
	const targeting = context.get('targeting');

	bidders.requestBids({
		responseListener: biddersDelay.markAsReady,
	});

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
	return Promise.all([
		waitForBiddersResolve()
	]);
}

function hideAllAdSlots() {
	Object.keys(context.get('slots')).forEach((slotName) => {
		const element = document.getElementById(slotName);

		if (element) {
			element.classList.add('hidden');
		}
	});
}

export {
	hmdLoader,
	isAutoPlayDisabled,
	run,
	slots,
	waitForAdStackResolve
}
