/*global define*/
define('ext.wikia.adEngine.adConfig', [
	// regular dependencies
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'wikia.geo',
	'ext.wikia.abTest',

	'ext.wikia.adEngine.adDecoratorPageDimensions',

	// adProviders
	'ext.wikia.adEngine.provider.directGpt',
	'ext.wikia.adEngine.provider.evolve',
	'ext.wikia.adEngine.provider.later',
	'ext.wikia.adEngine.provider.null'
], function (
	// regular dependencies
	log,
	window,
	document,
	Geo,
	abTest,

	adDecoratorPageDimensions,

	// adProviders
	adProviderDirectGpt,
	adProviderEvolve,
	adProviderLater,
	adProviderNull
	) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfig',
		country = Geo.getCountryCode(),
		defaultHighValueSlots,
		highValueSlots,
		decorators = [adDecoratorPageDimensions];

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

	function getProvider(slot) {
		var slotname = slot[0];

		log(['getProvider', slot], 'info', logGroup);

		// If wgShowAds set to false, hide slots
		if (!window.wgShowAds) {
			return adProviderNull;
		}

		// Force providers:
		if (slot[2] === 'Evolve') {
			log(['getProvider', slot, 'Evolve'], 'info', logGroup);
			return adProviderEvolve;
		}
		if (slot[2] === 'AdDriver2') {
			log(['getProvider', slot, 'DirectGpt'], 'info', logGroup);
			return adProviderDirectGpt;
		}
		if (slot[2] === 'AdDriver') {
			log(['getProvider', slot, 'DirectGpt'], 'info', logGroup);
			return adProviderDirectGpt;
		}
		if (slot[2] === 'Liftium') {
			log(['getProvider', slot, 'Later (Liftium)'], 'info', logGroup);
			return adProviderLater;
		}


		// Force Liftium
		if (window.wgAdDriverForceLiftiumAd) {
			log(['getProvider', slot, 'Later (wgAdDriverForceLiftiumAd)'], 'info', logGroup);
			return adProviderLater;
		}

		// Force DirectGpt
		if (window.wgAdDriverForceDirectGptAd && adProviderDirectGpt.canHandleSlot(slotname)) {
			log(['getProvider', slot, 'DirectGpt (wgAdDriverForceDirectGptAd)'], 'info', logGroup);
			return adProviderDirectGpt;
		}


		// All SevenOne Media ads are handled in the Later queue
		// SevenOne Media gets all but WIKIA_BAR_BOXAD_1 and TOP_BUTTON
		// TOP_BUTTON is always handled in Later queue, so we need to exclude
		// only WIKIA_BAR_BOXAD_1.
		// Also we need to add an exception for GPT_FLUSH, so that WIKIA_BAR_BOXAD_1
		// is actually requested.
		if (window.wgAdDriverUseSevenOneMedia &&
				slotname !== 'WIKIA_BAR_BOXAD_1' &&
				slotname !== 'GPT_FLUSH'
				) {
			log(['getProvider', slot, 'Later (SevenOneMedia)'], 'info', logGroup);
			return adProviderLater;
		}

		// Next Evolve (AU, CA, and NZ traffic)
		if (country === 'AU' || country === 'CA' || country === 'NZ') {
			if (adProviderEvolve.canHandleSlot(slotname)) {
				log(['getProvider', slot, 'Evolve'], 'info', logGroup);
				return adProviderEvolve;
			}
		}

		if (highValueSlots[slotname] && adProviderDirectGpt.canHandleSlot(slotname)) {
			log(['getProvider', slot, 'Gpt'], 'info', logGroup);
			return adProviderDirectGpt;
		}

		// Non-high-value slots go to ad provider Later
		log(['getProvider', slot, 'Later (Liftium)'], 'info', logGroup);
		return adProviderLater;
	}

	return {
		getDecorators: function () { return decorators; },
		getProvider: getProvider
	};
});
