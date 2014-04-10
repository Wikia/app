/*global define*/
define('ext.wikia.adEngine.adConfigLate', [
	// regular dependencies
	'wikia.log',
	'wikia.window',
	'wikia.abTest',

	// adProviders
	'ext.wikia.adEngine.provider.liftium',
	'ext.wikia.adEngine.provider.remnantGpt',
	'ext.wikia.adEngine.provider.null',
	'ext.wikia.adEngine.provider.71m'
], function (
	// regular dependencies
	log,
	window,
	abTest,

	// AdProviders
	adProviderLiftium,
	adProviderRemnantGpt,
	adProviderNull,
	adProviderSevenOneMedia // TODO: move this to the early queue (remove jQuery dependency first)
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adConfigLate',
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

		if (slot[2] === 'Liftium' || window.wgAdDriverForceLiftiumAd) {
			if (adProviderRemnant.canHandleSlot(slot)) {
				return adProviderRemnant;
			}
			log('#' + slotname + ' disabled. Forced Liftium, but it can\'t handle it', 7, logGroup);
			return adProviderNull;
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
