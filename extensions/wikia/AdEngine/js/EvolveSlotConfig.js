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
	},
	hoppedSlots = {},
	logGroup = 'ext.wikia.adEngine.evolveSlotConfig';

	function getConfig(src) {
		return slotMapConfig;
	}

	function canHandleSlot(slotname) {
		log(['canHandleSlot', slotname], 5, logGroup);

		if (slotMapConfig[slotname]) {
			return true;
		}

		return false;
	}


	function sanitizeSlotname(slotname) {
		log('sanitizeSlotname', 5, logGroup);
		log(slotname, 5, logGroup);

		var re = new RegExp('[A-Z1-9_]+'),
			out = re.exec(slotname),
			undef;

		log(out, 8, logGroup);

		if (out) {
			out = out[0];
		}

		if (slotMapConfig[out] === undef) {
			log('error, unknown slotname', 1, logGroup);
			out = '';
		}

		log(out, 7, logGroup);
		return out;
	}


	function hop(slotname) {
		slotname = sanitizeSlotname(slotname);
		log(['hop', slotname], 5, logGroup);
		hoppedSlots[slotname] = true;
	}

	function isHopped(slotname) {
		return hoppedSlots[slotname];
	}


	return {
		getConfig: getConfig,
		canHandleSlot: canHandleSlot,
		sanitizeSlotname: sanitizeSlotname,
		isHopped: isHopped,
		hop: hop
	};

});
