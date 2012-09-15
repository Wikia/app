var AdConfig2 = function (
	// regular dependencies
	log, Wikia, window, Geo,

	// AdProviders
	AdProviderGamePro,
	AdProviderEvolve,
	AdProviderEvolveRS,
	AdProviderAdDriver2,
	AdProviderAdDriver,
	AdProviderLiftium2
) {
	'use strict';

	var country = Geo.getCountryCode()
		, defaultHighValueCountries, defaultHighValueSlots
		, highValueCountries, highValueSlots
		, evolveCountries
		, getProvider;

	defaultHighValueSlots = {
		'CORP_TOP_LEADERBOARD':true,
		'CORP_TOP_RIGHT_BOXAD':true,
		'EXIT_STITIAL_BOXAD_1':true,
		'HOME_INVISIBLE_TOP':true,
		'HOME_TOP_LEADERBOARD':true,
		'HOME_TOP_RIGHT_BOXAD':true,
		'HUB_TOP_LEADERBOARD':true,
		'INVISIBLE_MODAL':true,
		'INVISIBLE_TOP':true,
		'LEFT_SKYSCRAPER_2':true,
		'MIDDLE_RIGHT_BOXAD':true,
		'MODAL_RECTANGLE':true,
		'MODAL_INTERSTITIAL':true,
		'MODAL_VERTICAL_BANNER':true,
		'TEST_HOME_TOP_RIGHT_BOXAD':true,
		'TEST_TOP_RIGHT_BOXAD':true,
		'TOP_LEADERBOARD':true,
		'TOP_RIGHT_BOXAD':true
	};

	// copy of CommonSettings wgHighValueCountries
	defaultHighValueCountries = {
		'CA':true,
		'DE':true,
		'DK':true,
		'ES':true,
		'FI':true,
		'FR':true,
		'GB':true,
		'IT':true,
		'NL':true,
		'NO':true,
		'SE':true,
		'UK':true,
		'US':true
	};

	evolveCountries = {
		'AU': true,
		'NZ': true,
		'CA': true
	}

	highValueCountries = window.wgHighValueCountries2 || window.wgHighValueCountries;
	highValueCountries = highValueCountries || defaultHighValueCountries;

	highValueSlots = defaultHighValueSlots;

	getProvider = function(slot) {
		var slotname = slot[0];

		log('getProvider', 5, 'AdConfig2');
		log(slot, 5, 'AdConfig2');

		// To be removed later:
		if (slot[2] === 'GamePro') {
			return AdProviderGamePro;
		}
		if (slot[2] === 'Evolve') {
			return AdProviderEvolve;
		}
		if (slot[2] === 'AdDriver2') {
			return AdProviderAdDriver2;
		}
		if (slot[2] === 'Liftium2') {
			return AdProviderLiftium2;
		}

		// First ask GamePro
		if (AdProviderGamePro.canHandleSlot(slot)) {
			return AdProviderGamePro;
		}

		// Now, if in AU/NZ/CA ask Evolve and Evolve RS
		if (evolveCountries[country]) {
			if (AdProviderEvolve.canHandleSlot(slot)) {
				return AdProviderEvolve;
			}
			if (AdProviderEvolveRS.canHandleSlot(slot)) {
				return AdProviderEvolveRS;
			}
		}

		// Now if slot is high value in high value country,
		// ask AdDriver2 (DART->Liftium)
		if (
			highValueCountries[country] &&
			highValueSlots[slotname]
		) {
			return AdProviderAdDriver2;
		}

		// Now Liftium

		// TODO: should be AdProviderLiftium2 eventually
		return AdProviderAdDriver;
	};

	return {
		getProvider: getProvider
	};
};
