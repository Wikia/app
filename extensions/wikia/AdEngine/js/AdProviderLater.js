var AdProviderLater = function(log, queueForLateAds) {
	'use strict';

	var fillInSlot = function(slotname) {
		log('fillInSlot', 5, 'AdProviderLater');
		log(slotname, 5, 'AdProviderLater');

		queueForLateAds.push([slotname]);
	};

	return {
		name: 'Later',
		fillInSlot: fillInSlot
	};
};
