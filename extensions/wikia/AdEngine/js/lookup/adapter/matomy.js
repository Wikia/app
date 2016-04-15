/*global define*/
define('ext.wikia.adEngine.lookup.adapter.matomy', [
	'ext.wikia.adEngine.adContext'
], function (adContext) {
	'use strict';

	var bidderName = 'appnexus',
		placementId = '7071682',
		slots = {
			oasis: [
				'TOP_RIGHT_BOXAD',
				'LEFT_SKYSCRAPER_2',
				'LEFT_SKYSCRAPER_3',
				'INCONTENT_BOXAD_1',
				'PREFOOTER_LEFT_BOXAD',
				'PREFOOTER_RIGHT_BOXAD'
			],
			mercury: [
				'MOBILE_TOP_LEADERBOARD',
				'MOBILE_IN_CONTENT',
				'MOBILE_PREFOOTER'
			]
		};

	function isEnabled() {
		// TODO: enable with wgCountries
		return true;
	}

	function prepareAdUnit(slotName) {
		return {
			code: slotName,
			sizes: [
				[300, 250]
			],
			bids: [
				{
					bidder: bidderName,
					params: {
						placementId: placementId
					}
				}
			]
		};
	}

	function configureOasisSlots() {
		var context = adContext.getContext(),
			i,
			slotName;

		if (context.targeting.pageType === 'home') {
			for (i = 0; i < slots.oasis.length; i++) {
				slotName = slots.oasis[i];
				if (slotName.indexOf('TOP') > -1) {
					slots.oasis.push('HOME_' + slotName);
					slots.oasis.splice(i, 1);
				}
			}
			slots.oasis.push('PREFOOTER_MIDDLE_BOXAD');
		}
		if (context.slots.incontentLeaderboard) {
			slots.oasis.push('INCONTENT_LEADERBOARD');
		}
	}

	function getAdUnits(skin) {
		var adUnits = [];

		if (!slots[skin]) {
			return [];
		}
		if (skin === 'oasis') {
			configureOasisSlots();
		}

		slots[skin].forEach(function (slotName) {
			adUnits.push(prepareAdUnit(slotName));
		});

		return adUnits;
	}

	return {
		getAdUnits: getAdUnits,
		isEnabled: isEnabled
	};
});
