/*global setTimeout, define*/
define('ext.wikia.adEngine.provider.later', [
	'wikia.log',
	'ext.wikia.adEngine.lateAdsQueue'
], function (log, lateAdsQueue) {
	'use strict';

	function fillInSlot(slotname, success) {
		log(['fillInSlot', slotname, success], 5, 'ext.wikia.adEngine.provider.later');
		setTimeout(function () {
			lateAdsQueue.push([slotname]);
		}, 0);
		success();
	}

	return {
		name: 'Later',
		fillInSlot: fillInSlot
	};
});
