/*exported AdProviderLater*/
/*global setTimeout*/
var AdProviderLater = function (log, queueForLateAds) {
	'use strict';

	function fillInSlot(slotname, success) {
		log(['fillInSlot', slotname, success], 5, 'AdProviderLater');
		setTimeout(function () {
			queueForLateAds.push([slotname]);
		}, 0);
		success();
	}

	return {
		name: 'Later',
		fillInSlot: fillInSlot
	};
};
