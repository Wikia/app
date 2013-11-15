var AdConfig2 = function (
	// regular dependencies
	log,
	window,
	document,
	Geo,
	adLogicPageDimensions,
	abTest,

	// adProviders
	adProviderGpt,
	adProviderEvolve,
	adProviderGamePro,
	adProviderLater,
	adProviderNull
) {
	'use strict';

	var logGroup = 'AdConfig2',
		cityLang = window.wgContentLanguage,
		country = Geo.getCountryCode(),
		defaultHighValueSlots,
		highValueSlots,
		useSevenOneMedia = window.wgAdDriverUseSevenOneMedia;

	defaultHighValueSlots = {
		'CORP_TOP_LEADERBOARD': true,
		'CORP_TOP_RIGHT_BOXAD': true,
		'EXIT_STITIAL_BOXAD_1': true,
		'HOME_TOP_LEADERBOARD': true,
		'HOME_TOP_RIGHT_BOXAD': true,
		'HUB_TOP_LEADERBOARD': true,
		'INVISIBLE_SKIN': true,
		'LEFT_SKYSCRAPER_2': true,
		'MIDDLE_RIGHT_BOXAD': true,
		'MODAL_RECTANGLE': true,
		'MODAL_INTERSTITIAL': true,
		'MODAL_INTERSTITIAL_1': true,
		'MODAL_INTERSTITIAL_2': true,
		'MODAL_INTERSTITIAL_3': true,
		'MODAL_INTERSTITIAL_4': true,
		'TEST_HOME_TOP_RIGHT_BOXAD': true,
		'TEST_TOP_RIGHT_BOXAD': true,
		'TOP_LEADERBOARD': true,
		'TOP_RIGHT_BOXAD': true,
		'WIKIA_BAR_BOXAD_1': true,
		'GPT_FLUSH': true
	};

	highValueSlots = defaultHighValueSlots;

	function getBackEndProvider(slot) {
		var slotname = slot[0];

		log('getProvider', 5, logGroup);
		log(slot, 5, logGroup);

		// Force providers:
		if (slot[2] === 'GamePro') {
			return adProviderGamePro;
		}
		if (slot[2] === 'Evolve') {
			return adProviderEvolve;
		}
		if (slot[2] === 'AdDriver2') {
			return adProviderGpt;
		}
		if (slot[2] === 'AdDriver') {
			return adProviderGpt;
		}
		if (slot[2] === 'Liftium2') {
			return adProviderLater;
		}
		if (slot[2] === 'Liftium2Dom') {
			return adProviderLater;
		}

		if (useSevenOneMedia) {
			// All SevenOne Media ads are handled in the Later queue
			return adProviderLater;
		}

		// TODO refactor highValueSlots check to the top of the whole config
		if (highValueSlots[slotname]) {
			// First ask GamePro (german lang wiki)
			if (cityLang === 'de') {
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
		if (highValueSlots[slotname] && adProviderGpt.canHandleSlot(slot)) {
			return adProviderGpt;
		}

		return adProviderLater;
	}

	function getProvider(slot) {
		var provider = getBackEndProvider(slot);

		// No page length checking logic for Null provider
		if (provider === adProviderNull) {
			return provider;
		}

		// Check if we should apply page length checking for that slot
		if (provider !== adProviderNull && adLogicPageDimensions.isApplicable(slot)) {
			return adLogicPageDimensions.getProxy(provider);
		}

		return provider;
	}

	return {
		getProvider: getProvider
	};
};
