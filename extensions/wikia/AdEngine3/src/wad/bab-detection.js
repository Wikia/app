import { context, utils } from '@wikia/ad-engine';
import { track } from '../tracking/tracker';

const logGroup = 'bab-detection';

let delayPromise = null;
let detectionCompleted = false;
let resolvePromise = null;

/**
 * Creates and dispatches WAD result event on document object
 * @param {boolean} isBabDetected
 * @returns {void}
 */
function dispatchDetectionEvent(isBabDetected) {
	const event = document.createEvent('Event');
	const name = isBabDetected ? 'bab.blocking' : 'bab.not_blocking';

	event.initEvent(name, true, false);
	document.dispatchEvent(event);
}

/**
 * Marks detection as completed and resolves delay promise
 * @returns {void}
 */
function markAsReady() {
	detectionCompleted = true;

	if (resolvePromise) {
		resolvePromise();
		resolvePromise = null;
	}
}

/**
 * Updates global window WAD detection params
 * @param {boolean} isBabDetected
 * @returns {void}
 */
function setRuntimeParams(isBabDetected) {
	window.ads.runtime = window.ads.runtime || {};
	window.ads.runtime.bab = window.ads.runtime.bab || {};
	window.ads.runtime.bab.blocking = isBabDetected;

	context.set('options.wad.blocking', isBabDetected);
}

/**
 * Updates application src value
 * @param {boolean} isBabDetected
 * @returns {void}
 */
function updateSrcParameter(isBabDetected) {
	if (isBabDetected) {
		context.set('src', 'rec');
	}
}

/**
 * Tracks WAD rec detection result to GA and DW
 * @param {boolean} isBabDetected
 * @returns {void}
 */
function trackDetection(isBabDetected) {
	markAsReady();

	utils.logger(logGroup, 'BAB detection, AB detected:', isBabDetected);

	setRuntimeParams(isBabDetected);
	updateSrcParameter(isBabDetected);
	dispatchDetectionEvent(isBabDetected);

	track({
		category: 'ads-babdetector-detection',
		action: 'impression',
		label: isBabDetected ? 'Yes' : 'No',
		value: 0,
		trackingMethod: 'internal',
	});
}

/**
 * Holds AdEngine run until AB detection is completed
 */
export const babDetection = {
	/**
	 * Returns module name
	 * @returns {string}
	 */
	getName() {
		return logGroup;
	},

	/**
	 * Creates and returns delay promise if available
	 * @returns {Promise}
	 */
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

	/**
	 * Checks whether WAD detection is positive
	 * @returns {boolean}
	 */
	isBlocking() {
		if (window.ads && window.ads.runtime && window.ads.runtime.bab) {
			return window.ads.runtime.bab.blocking;
		}

		return undefined;
	},

	/**
	 * Checks whether module is enabled via Instant Global
	 * @returns {boolean}
	 */
	isEnabled() {
		return context.get('options.wad.enabled');
	},

	/**
	 * Starts WAD rec detection
	 * @returns {void}
	 */
	async run() {
		if (this.isEnabled()) {
			return await utils.client.checkBlocking(
				() => trackDetection(true),
				() => trackDetection(false),
			);
		}

		return Promise.resolve();
	},
};
