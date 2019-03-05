import { utils } from '@wikia/ad-engine';
import { jwplayerAdsFactory } from '@wikia/ad-engine/dist/ad-products';
import { recInjector } from './rec-injector';
import {babDetection} from "./bab-detection";

const isDebug = utils.queryString.isUrlParamSet('hmd-rec-debug');
const logGroup = 'hmd-loader';

let trackingStatus = {
	hmdSetuped: false,
	hmdReady: false,
	adRequested: false,
	adPlayed: false,
	hmdErrors: {
		mediaerror: 1001,
		malformattedXML: 1004,
		vastLoadingFailed: 1011,
		noCreative: 1012,
		wrapperLimitReached: 1014,
	},
	hmdCollapse: {
		emptyVast: 1003,
		emptyVastFromHomadServerEvent: 1013,
	},
	vastIds: {
		lineItemId: '',
		creativeId: '',
	},
};

const trackingEventsMap = {
	adRequest: () => {
		trackingStatus.adRequested = true;
		trackingStatus.vastIds.lineItemId = '';
		trackingStatus.vastIds.creativeId = '';
		trackEvent('hmd_request');
	},
	adImpression: (event) => {
		if (event.detail.adIds && event.detail.adIds[0]) {
			const adIds = event.detail.adIds[0];

			if (adIds.adID) {
				trackingStatus.vastIds.lineItemId = adIds.adID;
			}

			if (adIds.creativeID) {
				trackingStatus.vastIds.creativeId = adIds.creativeID;
			}
		}

		trackingStatus.adPlayed = true;

		trackEvent('hmd_impression', {
			statusName: 'success',
			vastParams: trackingStatus.vastIds,
		});
	},
	adStart: 'hmd_started',
	adFirstQuartile: 'hmd_first_quartile',
	adMidPoint: 'hmd_midpoint',
	adThirdQuartile: 'hmd_third_quartile',
	adComplete: 'hmd_completed',
	adClick: 'hmd_clicked',
	adSkipped: 'hmd_skipped',
	contentPlayerPause: (event) => {
		if (event.detail.state === 'setup') {
			trackingStatus.hmdSetuped = true;
			trackEvent('hmd_setup');
			return;
		}

		if (!trackingStatus.hmdSetuped) {
			return;
		}

		if (!trackingStatus.hmdReady) {
			trackingStatus.hmdReady = true;
			trackEvent('hmd_ready');
			return;
		}

		if (trackingStatus.adRequested) {
			trackingStatus.adRequested = false;
			trackEvent('hmd_loading');
		}
	},
	contentPlayerPlay: () => {
		if (!trackingStatus.adPlayed) {
			trackEvent('hmd_noad');
		}

		trackingStatus.hmdReady = false;
		trackingStatus.adRequested = false;
		trackingStatus.adPlayed = false;
	},
	viewable: 'hmd_viewable_impression',
	penalty: 'hmd_blocked',
	adError: (event) => {
		const type = event.detail.type;

		trackingStatus.adRequested = false;

		if (trackingStatus.hmdErrors[type]) {
			trackEvent('hmd_error', null, trackingStatus.hmdErrors[type]);
		} else if (trackingStatus.hmdCollapse[type]) {
			trackEvent(null, {
				statusName: 'collapse',
				vastParams: trackingStatus.vastIds,
			});
		}
	}
};
const configDev = {
	clientConfig: 'https://fabian-test-eu-fra.s3.amazonaws.com/homad/homadConfigTestHttps.json',
	adTag: 'https://fabian-test-eu-fra.s3.amazonaws.com/vast-test-area/vast2-default-5sec.xml'
};
const configClient = {
	alias: 'comwikiapubadsgdoubleclicknet',
	config: 'https://hgc-cf-cache-1.svonm.com/www.wikia.com/config.json',
	enabled: true,
	server: [
		'https://ssl.1.damoh.wikia.com/[hash]/',
		'https://ssl.2.damoh.wikia.com/[hash]/',
		'https://ssl.3.damoh.wikia.com/[hash]/',
		'https://ssl.4.damoh.wikia.com/[hash]/',
		'https://ssl.5.damoh.wikia.com/[hash]/',
		'https://ssl.6.damoh.wikia.com/[hash]/'
	]
};
const config = {
	globalConfig: 'https://s3.amazonaws.com/homad-global-configs.schneevonmorgen.com/global_config.json',
	clientConfig: isDebug ? configDev.clientConfig : configClient,
	admessage: 'The ad ends in [time] seconds',
	adjustAdVolumeToContentPlayer: true,
	adTag: false,
	prerollAdTag: () => {
		utils.logger(logGroup, 'Requesting preroll adTag');

		return isDebug ? configDev.adTag : jwplayerAdsFactory.getCurrentVast('preroll') || false;
	},
	midrollAdTag: () => {
		utils.logger(logGroup, 'Requesting midroll adTag');

		return jwplayerAdsFactory.getCurrentVast('midroll') || false;
	},
	postrollAdTag: () => {
		utils.logger(logGroup, 'Requesting postroll adTag');

		return jwplayerAdsFactory.getCurrentVast('postroll') || false;
	}
};

/**
 * Subscribes to HMD window event and pass tracking to DW
 * @returns {void}
 */
function initializeTracking() {
	window.addEventListener('hdEvent', (event) => {
		utils.logger(logGroup, 'HMD event registered', event, event.detail.name);

		if (
			event.detail && event.detail.name && event.detail.state &&
			['setup', 'preroll'].indexOf(event.detail.state) !== -1 &&
			trackingEventsMap[event.detail.name]
		) {
			const eventName = event.detail.name;
			const trackingMethod = trackingEventsMap[eventName];

			if (typeof trackingMethod === 'function') {
				trackingMethod(event);
			} else {
				trackEvent(trackingMethod);
			}
		}
	});
}

/**
 * Track single HMD event to DW
 * @param {string} name
 * @param {object} slotStatus
 * @param {string|int} errorCode
 * @returns {void}
 */
function trackEvent(name, slotStatus = null, errorCode = '') {
	const event = new CustomEvent('hdPlayerEvent', {
		detail: {
			name,
			slotStatus,
			errorCode
		}
	});

	document.dispatchEvent(event);
}

/**
 * Loads HMD rec service
 */
export const hmdLoader = {
	/**
	 * Returns HMD injected code config
	 * @returns {object}
	 */
	getConfig() {
		return config;
	},

	/**
	 * Runs HMD rec service and injects code
	 * @returns {void}
	 */
	run() {
		utils.logger(logGroup, 'Initialising HMD rec loader');

		initializeTracking();

		recInjector.inject('hmd');
	},

	/**
	 * Adds callback executed after HMD service initialisation
	 * @param {function} onReady
	 * @returns {void}
	 */
	setOnReady(onReady) {
		config.onReady = onReady;
	},
};
