var AdConfigLate2 = function (
	// regular dependencies
	log,

	// AdProviders
	AdProviderAdDriver,
	AdProviderLiftium2
) {
	'use strict';

	var module = 'AdConfigLate2'
		, getProvider;

	getProvider = function(slot) {
		var slotname = slot[0];

		log('getProvider', 5, module);
		log(slot, 5, module);

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
