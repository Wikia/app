var AdProviderSevenOneMedia = function() {
	'use strict';

	var slotMap = {
		'HOME_TOP_LEADERBOARD': true,
		'HOME_TOP_RIGHT_BOXAD': true,
		'HUB_TOP_LEADERBOARD': true,
		'LEFT_SKYSCRAPER_2': true,
		'PREFOOTER_LEFT_BOXAD': true,
		'PREFOOTER_RIGHT_BOXAD': true,
		'TOP_LEADERBOARD': true,
		'TOP_RIGHT_BOXAD': true,
		'INVISIBLE_1': true,
		'INVISIBLE_2': true
	};

	function canHandleSlot(slot) {
		var slotname = slot[0];

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	}

	function fillInSlot(slot) {
		/*
		 * NOOP
		 *
		 * The real integration happens in SevenOneMedia/allinone.js called from the bottom
		 * of Oasis_Index.php
		 */
	}

	return {
		name: 'SevenOneMedia',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
