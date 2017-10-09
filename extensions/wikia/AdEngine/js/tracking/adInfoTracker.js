/*global define*/
define('ext.wikia.adEngine.tracking.adInfoTracker',  [
	'ext.wikia.adEngine.tracking.adInfoTrackerHelper',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.window'
], function (adInfoTrackerHelper, adTracker, adContext, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.tracking.adInfoTracker',
		enabledSlots = {
			TOP_LEADERBOARD: true,
			TOP_RIGHT_BOXAD: true,
			PREFOOTER_LEFT_BOXAD: true,
			PREFOOTER_MIDDLE_BOXAD: true,
			PREFOOTER_RIGHT_BOXAD: true,
			LEFT_SKYSCRAPER_2: true,
			LEFT_SKYSCRAPER_3: true,
			INCONTENT_BOXAD_1: true,
			INCONTENT_PLAYER: true,
			BOTTOM_LEADERBOARD: true,
			MOBILE_TOP_LEADERBOARD: true,
			MOBILE_BOTTOM_LEADERBOARD: true,
			MOBILE_IN_CONTENT: true,
			MOBILE_PREFOOTER: true
		};

	function logSlotInfo(data) {
		log(['logSlotInfo', data], log.levels.debug, logGroup);

		adTracker.trackDW(data, 'adengadinfo');
	}

	function isEnabled() {
		return adContext.getContext().opts.enableAdInfoLog;
	}

	function run() {
		if (isEnabled()) {
			log('run', log.levels.debug, logGroup);

			win.addEventListener('adengine.slot.status', function (event) {
				var adInfo = event.detail.adInfo || {},
					adType = adInfo && adInfo.adType,
					data,
					slot = event.detail.slot,
					status = adType === 'blocked' ? 'blocked' : event.detail.status;

				if (adInfoTrackerHelper.shouldHandleSlot(slot, enabledSlots)) {
					data = adInfoTrackerHelper.prepareData(slot, status, adInfo);

					log(['adengine.slot.status', event], log.levels.debug, logGroup);
					if (data) {
						logSlotInfo(data);
					}
				}
			});
		}
	}

	return {
		run: run
	};

});
