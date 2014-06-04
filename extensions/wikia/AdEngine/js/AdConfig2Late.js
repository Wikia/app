/*global define*/
define('ext.wikia.adEngine.adConfigLate', [
	// regular dependencies
	'wikia.log',
	'wikia.window',
	'wikia.abTest',
	'wikia.geo',

	// adProviders
	'ext.wikia.adEngine.provider.evolve',
	'ext.wikia.adEngine.provider.liftium',
	'ext.wikia.adEngine.provider.remnantGpt',
	'ext.wikia.adEngine.provider.null',
	'ext.wikia.adEngine.provider.sevenOneMedia',
	'ext.wikia.adEngine.provider.ebay'
], function (
	// regular dependencies
	log,
	window,
	abTest,
	geo,

	// AdProviders
	adProviderEvolve,
	adProviderLiftium,
	adProviderRemnantGpt,
	adProviderNull,
	adProviderSevenOneMedia, // TODO: move this to the early queue (remove jQuery dependency first)
	adProviderEbay
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfigLate',
		country = geo.getCountryCode(),
		liftiumSlotsToShowWithSevenOneMedia = {
			'WIKIA_BAR_BOXAD_1': true,
			'TOP_BUTTON_WIDE': true,
			'TOP_BUTTON_WIDE.force': true
		},
		ie8 = window.navigator && window.navigator.userAgent && window.navigator.userAgent.match(/MSIE [6-8]\./),
		sevenOneMediaDisabled = abTest && abTest.inGroup('SEVENONEMEDIA_DR', 'DISABLED'),
		adProviderRemnant;

	if (window.wgEnableRHonDesktop) {
		adProviderRemnant = adProviderRemnantGpt;
	} else {
		adProviderRemnant = adProviderLiftium;
	}

	function getProvider(slot) {
		var slotname = slot[0];

		log('getProvider', 5, logGroup);
		log(slot, 5, logGroup);


		if (slot[2] === 'Evolve') {
			log(['getProvider', slot, 'Evolve'], 'info', logGroup);
			return adProviderEvolve;
		}

		if (slot[2] === 'Liftium' || window.wgAdDriverForceLiftiumAd) {
			if (adProviderRemnant.canHandleSlot(slotname)) {
				return adProviderRemnant;
			}
			log('#' + slotname + ' disabled. Forced Liftium, but it can\'t handle it', 7, logGroup);
			return adProviderNull;
		}

		if (country === 'AU' || country === 'CA' || country === 'NZ') {
			if (adProviderEvolve.canHandleSlot(slotname)) {
				log(['getProvider', slot, 'Evolve'], 'info', logGroup);
				return adProviderEvolve;
			}
		}

		// First ask SevenOne Media
		if (window.wgAdDriverUseSevenOneMedia) {
			if (adProviderSevenOneMedia.canHandleSlot(slotname)) {
				if (ie8) {
					log('SevenOneMedia not supported on IE8. Using Null provider instead', 'warn', logGroup);
					return adProviderNull;
				}

				if (sevenOneMediaDisabled) {
					log('SevenOneMedia disabled by A/B test. Using Null provider instead', 'warn', logGroup);
					return adProviderNull;
				}

				return adProviderSevenOneMedia;
			}

			if (!liftiumSlotsToShowWithSevenOneMedia[slot[0]]) {
				return adProviderNull;
			}
		}

		// Ebay integration
		if (window.wgAdDriverUseEbay) {
			if (slotname === 'PREFOOTER_LEFT_BOXAD') {
				return adProviderEbay;
			}
			if (slotname === 'PREFOOTER_RIGHT_BOXAD') {
				return adProviderNull;
			}
		}

		if (adProviderRemnant.canHandleSlot(slotname)) {
			return adProviderRemnant;
		}

		return adProviderNull;
	}

	return {
		getDecorators: function () {},
		getProvider: getProvider
	};
});
