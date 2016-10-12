/*global define*/
define('ext.wikia.adEngine.context.slotsContext', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, params, geo, instantGlobals, log) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.context.slotsContext',
		slots = null;

	function setStatus(slotName, status) {
		slots[slotName] = !!status;
	}

	function setupSlots() {
		var isHome = params.getPageType() === 'home';

		slots = {};

		setStatus('HOME_TOP_LEADERBOARD', isHome);
		setStatus('HOME_TOP_RIGHT_BOXAD', isHome);
		setStatus('PREFOOTER_MIDDLE_BOXAD', isHome);

		setStatus('TOP_LEADERBOARD', !isHome);
		setStatus('TOP_RIGHT_BOXAD', !isHome);

		setStatus('INVISIBLE_HIGH_IMPACT_2', geo.isProperGeo(instantGlobals.wgAdDriverHighImpact2SlotCountries));
		setStatus('INCONTENT_LEADERBOARD', geo.isProperGeo(instantGlobals.wgAdDriverIncontentLeaderboardSlotCountries));
		setStatus('INCONTENT_PLAYER', geo.isProperGeo(instantGlobals.wgAdDriverIncontentPlayerSlotCountries));

		setStatus('PREFOOTER_RIGHT_BOXAD', !context.opts.overridePrefootersSizes);

		log(['Disabled slots:', slots], 'info', logGroup);
	}

	function isApplicable(slotName) {
		if (slots === null) {
			setupSlots();
		}

		return slots[slotName] !== false;
	}

	function filterSlotMap(slotMap) {
		var map = {};

		Object.keys(slotMap).forEach(function (slotName) {
			if (isApplicable(slotName)) {
				map[slotName] = slotMap[slotName];
			}
		});

		return map;
	}

	return {
		filterSlotMap: filterSlotMap,
		isApplicable: isApplicable
	};
});
