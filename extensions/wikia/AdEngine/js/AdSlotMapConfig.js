var AdSlotMapConfig = function() {
	"use strict";


	var slotMapConfig = {
		'gpt': {
			'CORP_TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x180', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
			'CORP_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
			'EXIT_STITIAL_BOXAD_1': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'exit'},
			'HOME_TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x180', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
			'HOME_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
			'HUB_TOP_LEADERBOARD':  {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x180', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
			'INVISIBLE_SKIN': {'size': '1000x1000,1x1', 'loc': 'top', 'gptOnly': true},
			'LEFT_SKYSCRAPER_2': {'size': '160x600', 'tile': 3, 'loc': 'middle'},
			'LEFT_SKYSCRAPER_3': {'size': '160x600', 'tile': 6, 'loc': 'footer'},
			'MODAL_INTERSTITIAL':   {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
			'MODAL_INTERSTITIAL_1': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
			'MODAL_INTERSTITIAL_2': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
			'MODAL_INTERSTITIAL_3': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
			'MODAL_INTERSTITIAL_4': {'size': '300x250,600x400,800x450,550x480', 'tile': 2, 'loc': 'modal'},
			'MODAL_RECTANGLE': {'size': '300x100', 'tile': 2, 'loc': 'modal'},
			'TEST_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
			'TEST_HOME_TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
			'TOP_LEADERBOARD': {'size': '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x180', 'tile': 2, 'loc': 'top', 'dcopt': 'ist'},
			'TOP_RIGHT_BOXAD': {'size': '300x250,300x600,300x1050', 'tile': 1, 'loc': 'top'},
			'WIKIA_BAR_BOXAD_1': {'size': '320x50,320x70,320x100', 'tile': 4, 'loc': 'bottom'},
			'GPT_FLUSH': 'flushonly'
		}
	};

	function getConfig(src) {
		if (typeof src === 'undefined') {
			return slotMapConfig;
		}

		return slotMapConfig;
	}

	return {
		getConfig: getConfig
	};

};

