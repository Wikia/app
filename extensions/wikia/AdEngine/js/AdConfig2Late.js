var AdConfig2Late = function (
	// regular dependencies
	log,

	// AdProviders
	AdProviderLiftium2
) {
	'use strict';

	var module = 'AdConfig2Late'
		, getProvider;

	getProvider = function(slot) {
		var slotname = slot[0];

		log('getProvider', 5, module);
		log(slot, 5, module);

		if (slot[2] === 'Liftium2') {
			return AdProviderLiftium2;
		}

		return AdProviderLiftium2;
	};

	return {
		getProvider: getProvider
	};
};
