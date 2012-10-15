var AdProviderLater = function(log, queueForLateAds) {
	'use strict';

	var fillInSlot = function(slot) {
		log('fillInSlot', 5, 'AdProviderLater');
		log(slot, 5, 'AdProviderLater');

		queueForLateAds.push(slot);
	};

	return {
		name: 'Later',
		fillInSlot: fillInSlot
	};
};
