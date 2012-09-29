var AdConfig2Late = function (
	// regular dependencies
	log,

	// AdProviders
	adProviderNull,
	adProviderLiftium2
) {
	'use strict';

	var module = 'AdConfig2Late'
		, getProvider;

	getProvider = function(slot) {
		var slotname = slot[0];

		log('getProvider', 5, module);
		log(slot, 5, module);

		if (slot[2] === 'Liftium2') {
			return adProviderLiftium2;
		}

		if (adProviderLiftium2.canHandleSlot(slot)) {
			return adProviderLiftium2;
		}

		return adProviderNull;
	};

	return {
		getProvider: getProvider
	};
};
