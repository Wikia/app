var AdConfig2Late = function (
	// regular dependencies
	log

	// AdProviders
	, adProviderGamePro
	, adProviderLiftium2
	, adProviderLiftium2Dom
	, adProviderNull
) {
	'use strict';

	var log_group = 'AdConfig2Late'
		, getProvider;

	getProvider = function(slot) {
		var slotname = slot[0];

		log('getProvider', 5, log_group);
		log(slot, 5, log_group);

		if (slot[2] === 'Liftium2') {
			return adProviderLiftium2;
		}
		if (slot[2] === 'Liftium2Dom') {
			return adProviderLiftium2Dom;
		}

		// First ask GamePro (german lang wiki)
		if (adProviderGamePro.canHandleSlot(slot)) {
			return adProviderGamePro;
		}

		if (slotname == 'WIKIA_BAR_BOXAD_1' || slotname == 'INCONTENT_BOXAD_1') {
			if (adProviderLiftium2Dom.canHandleSlot(slot)) {
				return adProviderLiftium2Dom;
			}
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
