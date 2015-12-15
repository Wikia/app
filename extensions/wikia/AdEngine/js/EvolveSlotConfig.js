/*global define*/
define('ext.wikia.adEngine.evolveSlotConfig', function () {
	'use strict';

	var slotMapConfig = {
		'HOME_TOP_LEADERBOARD': {'size': '728x90', 'dcopt': 'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'size': '300x250,300x600'},
		'HUB_TOP_LEADERBOARD': {'size': '728x90', 'dcopt': 'ist'},
		'LEFT_SKYSCRAPER_2': {'size': '160x600,300x600'},
		'TOP_LEADERBOARD': {'size': '728x90', 'dcopt': 'ist'},
		'TOP_RIGHT_BOXAD': {'size': '300x250,300x600'},
		'INVISIBLE_SKIN': {'size': '1000x1000'}
	};

	function getConfig() {
		return slotMapConfig;
	}

	function canHandleSlot(slotname) {
		return slotMapConfig[slotname];
	}

	return {
		getConfig: getConfig,
		canHandleSlot: canHandleSlot
	};

});
