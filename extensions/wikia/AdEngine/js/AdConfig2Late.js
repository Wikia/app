var AdConfig2Late = function (
	// regular dependencies
	log, window

	// AdProviders
	, adProviderGamePro
	, adProviderLiftium2Dom
	, adProviderNull
) {
	'use strict';

	var logGroup = 'AdConfig2'
		, cityLang = window.wgContentLanguage
		, getProvider
		, fakeLiftium = {}
	;

	getProvider = function(slot) {
		var slotname = slot[0];

		log('getProvider', 5, logGroup);
		log(slot, 5, logGroup);

		if (slot[2] === 'Liftium2' || slot[2] === 'Liftium2Dom') {
			if (adProviderLiftium2Dom.canHandleSlot(slot)) {
				return adProviderLiftium2Dom;
			} else {
				log('#' + slotname + ' disabled. Forced Liftium2, but it can\'t handle it', 7, logGroup);
				return adProviderNull;
			}
		}

		// First ask GamePro (german lang wiki)
		if (cityLang === 'de') {
			if (slotname === 'PREFOOTER_RIGHT_BOXAD' || slotname === 'LEFT_SKYSCRAPER_3' || slotname === 'TOP_RIGHT_BUTTON') {
				return adProviderNull;
			}
			if (adProviderGamePro.canHandleSlot(slot)) {
				return adProviderGamePro;
			}
		}

		if (adProviderLiftium2Dom.canHandleSlot(slot)) {
			return adProviderLiftium2Dom;
		}

		return adProviderNull;
	};

	return {
		getProvider: getProvider
	};
};
