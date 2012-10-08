var AdConfig2 = function (
	// regular dependencies
	log, window, document, Geo

	// adProviders
	, adProviderAdDriver
	, adProviderAdDriver2
	, adProviderEvolve
	, adProviderEvolveRS
	, adProviderGamePro
	, adProviderLater
	, adProviderNull
) {
	'use strict';

	var log_group = 'AdConfig2'
		, city_lang = window.wgContentLanguage
		, country = Geo.getCountryCode()
		, defaultHighValueCountries, defaultHighValueSlots
		, highValueCountries, highValueSlots
		, slotsOnlyOnLongPages
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

	// Map of slots present only on long pages
	// key: slot name
	// value: minimal height needed to show the ad (in pixels)
	slotsOnlyOnLongPages = {
		LEFT_SKYSCRAPER_2: 2400,
		LEFT_SKYSCRAPER_3: 4000,
		PREFOOTER_LEFT_BOXAD: 2400,
		PREFOOTER_RIGHT_BOXAD: 2400
	};

	highValueCountries = window.wgHighValueCountries2 || window.wgHighValueCountries;
	highValueCountries = highValueCountries || defaultHighValueCountries;

	highValueSlots = defaultHighValueSlots;

	getProvider = function(slot) {
		var slotname = slot[0]
			, pageHeight = document.documentElement.offsetHeight;

		log('getProvider', 5, log_group);
		log(slot, 5, log_group);

		// Check height of page for some slots
		if (slotsOnlyOnLongPages[slotname]) {
			if (pageHeight < slotsOnlyOnLongPages[slotname]) {
				log('#' + slotname + ' disabled. Page too short', 7, log_group);
				return adProviderNull;
			}
		}

		// Force providers:
		if (slot[2] === 'GamePro') {
			return adProviderGamePro;
		}
		if (slot[2] === 'Evolve') {
			return adProviderEvolve;
		}
		if (slot[2] === 'AdDriver2') {
			return adProviderAdDriver;
		}
		if (slot[2] === 'AdDriver') {
			return adProviderAdDriver;
		}
		if (slot[2] === 'Liftium2') {
			return adProviderLater;
		}
		if (slot[2] === 'Liftium2Dom') {
			return adProviderLater;
		}

		// TODO refactor highValueSlots check to the top of the whole config
		if (highValueSlots[slotname]) {

		// First ask GamePro (german lang wiki)
		if (city_lang == 'de') {
			if (adProviderGamePro.canHandleSlot(slot)) {
				return adProviderGamePro;
			}
		}

		}

		// Next Evolve (AU, CA, and NZ traffic)
		if ( /* country == 'AU' || country == 'CA' || */ country == 'NZ') {
			if (adProviderEvolve.canHandleSlot(slot)) {
				return adProviderEvolve;
			}
			if (adProviderEvolveRS.canHandleSlot(slot)) {
				return adProviderEvolveRS;
			}
		}

		// TODO refactor highValueSlots check to the top of the whole config
		if (highValueSlots[slotname]) {

		// Then our dart (high value traffic)
		if (highValueCountries[country]) {
			return adProviderAdDriver;
		}

		}

		return adProviderLater;
	};

	return {
		getProvider: getProvider
	};
};
