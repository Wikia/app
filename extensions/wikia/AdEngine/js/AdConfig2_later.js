var AdConfig2_later = function (
	// regular dependencies
	log, window,

	// AdProviders
	AdProviderAdDriver,
	AdProviderLiftium2
) {
	'use strict';

	var getProvider;

	getProvider = function(slot) {
		var slotname = slot[0];

		log('getProvider', 5, 'AdConfig2');
		log(slot, 5, 'AdConfig2');

		if (slot[2] === 'Liftium2') {
			return AdProviderLiftium2;
		}

		// TODO: should be AdProviderLiftium2 eventually
		return AdProviderAdDriver;
	};

	return {
		getProvider: getProvider
	};
};
