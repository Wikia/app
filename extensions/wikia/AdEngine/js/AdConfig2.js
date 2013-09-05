var AdConfig2 = function (
	// regular dependencies
	log,
	window,
	document,
	Geo,
	adLogicShortPage,
	abTest,

	// adProviders
	adProviderAdDriver2,
	adProviderGpt,
	adProviderEvolve,
	adProviderGamePro,
	adProviderLater,
	adProviderNull
) {
	'use strict';

	var log_group = 'AdConfig2',
		city_lang = window.wgContentLanguage,
		country = Geo.getCountryCode(),
		defaultHighValueSlots,
		highValueSlots,
		slotsOnlyOnLongPages,
		getProvider,
		dartProvider = window.wgAdDriverUseFullGpt ? adProviderGpt : adProviderAdDriver2;

	defaultHighValueSlots = {
		'CORP_TOP_LEADERBOARD':true,
		'CORP_TOP_RIGHT_BOXAD':true,
		'EXIT_STITIAL_BOXAD_1':true,
		'HOME_TOP_LEADERBOARD':true,
		'HOME_TOP_RIGHT_BOXAD':true,
		'HUB_TOP_LEADERBOARD':true,
		'INVISIBLE_SKIN':true,
		'LEFT_SKYSCRAPER_2':true,
		'MIDDLE_RIGHT_BOXAD':true,
		'MODAL_RECTANGLE':true,
		'MODAL_INTERSTITIAL':true,
		'MODAL_INTERSTITIAL_1':true,
		'MODAL_INTERSTITIAL_2':true,
		'MODAL_INTERSTITIAL_3':true,
		'MODAL_INTERSTITIAL_4':true,
		'TEST_HOME_TOP_RIGHT_BOXAD':true,
		'TEST_TOP_RIGHT_BOXAD':true,
		'TOP_LEADERBOARD':true,
		'TOP_RIGHT_BOXAD':true,
		'WIKIA_BAR_BOXAD_1':true,
		'GPT_FLUSH':true
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

	highValueSlots = defaultHighValueSlots;

	getProvider = function(slot) {
		var slotname = slot[0];

		log('getProvider', 5, log_group);
		log(slot, 5, log_group);

		// Check if page is too short for that slot
		if (adLogicShortPage.isPageTooShortForSlot(slotname)) {
			log('#' + slotname + ' disabled. Page too short', 7, log_group);
			return adProviderNull;
		}

		// Force providers:
		if (slot[2] === 'GamePro') {
			return adProviderGamePro;
		}
		if (slot[2] === 'Evolve') {
			return adProviderEvolve;
		}
		if (slot[2] === 'AdDriver2') {
			return dartProvider;
		}
		if (slot[2] === 'AdDriver') {
			return dartProvider;
		}
		if (slot[2] === 'Liftium2') {
			return adProviderLater;
		}
		if (slot[2] === 'Liftium2Dom') {
			return adProviderLater;
		}

		if (abTest && abTest.inGroup('PERFORMANCE_V_PREFOOTERS', 'PREFOOTERS_DISABLED')
			&& (slotname === 'PREFOOTER_LEFT_BOXAD' || slotname === 'PREFOOTER_RIGHT_BOXAD')
		) {
			log('AB experiment PERFORMANCE_V_PREFOOTERS, group PREFOOTERS_DISABLED: ' + slotname + ' disabled', 5, log_group);
			return adProviderNull;
		}

		// TODO refactor highValueSlots check to the top of the whole config
		if (highValueSlots[slotname]) {
			// First ask GamePro (german lang wiki)
			if (city_lang === 'de') {
				if (adProviderGamePro.canHandleSlot(slot)) {
					return adProviderGamePro;
				}
			}
		}

		// Next Evolve (AU, CA, and NZ traffic)
		if (country === 'AU' || country === 'CA' || country === 'NZ') {
			if (adProviderEvolve.canHandleSlot(slot)) {
				return adProviderEvolve;
			}
		}

		// Non-high-value slots goes to ad provider Later, so GamePro can grab them later
		if (highValueSlots[slotname] && dartProvider.canHandleSlot(slot)) {
			return dartProvider;
		}

		return adProviderLater;
	};

	return {
		getProvider: getProvider
	};
};
