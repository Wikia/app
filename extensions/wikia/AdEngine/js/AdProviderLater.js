/*exported AdProviderLater*/
var AdProviderLater = function (log, queueForLateAds) {
	'use strict';

	function fillInSlot(slotname, success) {
		log(['fillInSlot', slotname, success], 5, 'AdProviderLater');
		queueForLateAds.push([slotname]);
		success();
	}

	return {
		name: 'Later',
		fillInSlot: fillInSlot
	};
};
