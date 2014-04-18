/*global define*/
define('ext.wikia.adEngine.evolveSlotConfig', ['wikia.log'],function (log) {
	'use strict';

	var slotMapConfig = {
		'HOME_TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'tile': 2, 'size': '300x250,300x600'},
		'HUB_TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'LEFT_SKYSCRAPER_2': {'tile': 3, 'size': '160x600'},
		'TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'TOP_RIGHT_BOXAD': {'tile': 2, 'size': '300x250,300x600'},
		'INVISIBLE_SKIN': {'tile': 1, 'size': '1000x1000'}
	};

	function getConfig(src) {
		return slotMapConfig;
	}

	function canHandleSlot(slotname) {
		log(['canHandleSlot', slotname], 5, 'ext.wikia.adEngine.provider.evolve');

		if (slotMapConfig[slotname]) {
			return true;
		}

		return false;
	}

	return {
		getConfig: getConfig,
		canHandleSlot: canHandleSlot
	};

});
