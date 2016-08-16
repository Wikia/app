/*global define*/
define('ext.wikia.adEngine.slot.slotTargeting', [
	'ext.wikia.adEngine.adContext'
], function (adContext) {
	'use strict';

	var skins = {
			mercury: 'm',
			oasis: 'o'
		},
		pageTypes = {
			article: 'a',
			home: 'h'
		},
		slotSources = {
			gpt: '1',
			mobile: '1',
			remnant: '2',
			mobile_remnant: '2'
		},
		wsiSlots = {
			TOP_LEADERBOARD: 'l',
			CORP_TOP_LEADERBOARD: 'l',
			HOME_TOP_LEADERBOARD: 'l',
			HUB_TOP_LEADERBOARD: 'l',
			TOP_RIGHT_BOXAD: 'm',
			CORP_TOP_RIGHT_BOXAD: 'm',
			HOME_TOP_RIGHT_BOXAD: 'm',
			INCONTENT_PLAYER: 'i',
			INCONTENT_LEADERBOARD: 'i',
			INCONTENT_BOXAD_1: 'f',
			BOTTOM_LEADERBOARD: 'b',

			MOBILE_TOP_LEADERBOARD: 'l',
			MOBILE_IN_CONTENT: 'i',
			MOBILE_PREFOOTER: 'p',
			MOBILE_BOTTOM_LEADERBOARD: 'b'
		};

	function valueOrX(map, key) {
		if (!key || !map[key]) {
			return 'x';
		}

		return map[key];
	}

	function getWikiaSlotId(slotName, slotSource) {
		var context = adContext.getContext(),

			skin = valueOrX(skins, context.targeting.skin),
			slot = valueOrX(wsiSlots, slotName),
			pageType = valueOrX(pageTypes, context.targeting.pageType),
			src = valueOrX(slotSources, slotSource);

		return skin + slot + pageType + src;
	}

	return {
		getWikiaSlotId: getWikiaSlotId
	};
});
