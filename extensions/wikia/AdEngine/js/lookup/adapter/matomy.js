/*global define*/
define('ext.wikia.adEngine.lookup.adapter.matomy', function () {
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

	function getAdUnits(skin) {
		var adUnits = [];

		if (!slots[skin]) {
			return [];
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
