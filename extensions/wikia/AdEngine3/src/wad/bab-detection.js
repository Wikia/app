import { context, utils } from '@wikia/ad-engine';
import { track } from '../tracking/tracker';

const logGroup = 'bab-detection';

let delayPromise = null;
let detectionCompleted = false;
let resolvePromise;

function dispatchDetectionEvent(isBabDetected) {
	const event = document.createEvent('Event');
	const name = isBabDetected ? 'bab.blocking' : 'bab.not_blocking';

	event.initEvent(name, true, false);
	document.dispatchEvent(event);
}

function markAsReady() {
	detectionCompleted = true;

	if (resolvePromise) {
		resolvePromise();
		resolvePromise = null;
	}
}

function setRuntimeParams(isBabDetected) {
	window.ads.runtime = window.ads.runtime || {};
	window.ads.runtime.bab = window.ads.runtime.bab || {};
	window.ads.runtime.bab.blocking = isBabDetected;
}

function trackDetection(isBabDetected) {
	markAsReady();

	utils.logger(logGroup, 'BAB detection, AB detected:', isBabDetected);

	setRuntimeParams(isBabDetected);
	dispatchDetectionEvent(isBabDetected);

	track({
		category: 'ads-babdetector-detection',
		action: 'impression',
		label: isBabDetected ? 'Yes' : 'No',
		value: 0,
		trackingMethod: 'internal',
	});
}

export const babDetection = {
	getName() {
		return logGroup;
	},

	getPromise() {
		if (detectionCompleted) {
			return Promise.resolve();
		}

		if (delayPromise === null) {
			delayPromise = new Promise((resolve) => {
				resolvePromise = resolve;
			});
		}

		return delayPromise;
	},

	isBlocking() {
		return window.ads && window.ads.runtime && window.ads.runtime.bab && window.ads.runtime.bab.blocking;
	},

	isEnabled() {
		return context.get('opts.babDetectionDesktop');
	},

	run() {
		if (context.get('opts.babDetectionDesktop')) {
			utils.client.checkBlocking(
				() => trackDetection(true),
				() => trackDetection(false),
			);
		}
	},
};
