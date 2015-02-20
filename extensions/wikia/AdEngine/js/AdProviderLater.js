/*global setTimeout, define*/
define('ext.wikia.adEngine.provider.later', [
	'wikia.log',
	'ext.wikia.adEngine.lateAdsQueue'
], function (log, lateAdsQueue) {
	'use strict';

	function fillInSlot(slotname, success, error) {
		log(['fillInSlot', slotname, success], 5, 'ext.wikia.adEngine.provider.later');
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
