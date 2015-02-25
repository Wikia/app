/*global setTimeout, define*/
define('ext.wikia.adEngine.provider.later', [
	'wikia.log',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lateAdsQueue'
], function (log, adContext, lateAdsQueue) {
	'use strict';

	function fillInSlot(slotname, success, error) {
		log(['fillInSlot', slotname, success], 5, 'ext.wikia.adEngine.provider.later');
		if (adContext.getContext().opts.disableLateQueue) {
			error();
			return;
		}
		setTimeout(function () {
			lateAdsQueue.push({slotName: slotname, onSuccess: success, onError: error});
		}, 0);
	}

	function canHandleSlot() {
		return true;
	}

	return {
		name: 'Later',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
