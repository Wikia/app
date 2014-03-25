/*exported AdConfig2Late*/
var AdConfig2Late = function (
	// regular dependencies
	log,
	window,
	abTest,

	// AdProviders
	adProviderLiftium,
	adProviderNull,
	adProviderSevenOneMedia // TODO: move this to the early queue (remove jQuery dependency first)
) {
	'use strict';

	var logGroup = 'AdConfig2',
		liftiumSlotsToShowWithSevenOneMedia = {
			'WIKIA_BAR_BOXAD_1': true,
			'TOP_BUTTON_WIDE': true,
			'TOP_BUTTON_WIDE.force': true
		},
		ie8 = window.navigator && window.navigator.userAgent && window.navigator.userAgent.match(/MSIE [6-8]\./),
		sevenOneMediaDisabled = abTest && abTest.inGroup('SEVENONEMEDIA_DR', 'DISABLED');

	function getProvider(slot) {
		var slotname = slot[0];

		log('getProvider', 5, logGroup);
		log(slot, 5, logGroup);

		if (slot[2] === 'Liftium') {
			if (adProviderLiftium.canHandleSlot(slot)) {
				return adProviderLiftium;
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

		if (adProviderLiftium.canHandleSlot(slotname)) {
			return adProviderLiftium;
		}

		return adProviderNull;
	}

	return {
		getDecorators: function () {},
		getProvider: getProvider
	};
};
