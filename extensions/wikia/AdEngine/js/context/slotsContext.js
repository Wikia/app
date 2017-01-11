/*global define*/
define('ext.wikia.adEngine.context.slotsContext', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, params, geo, instantGlobals, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.context.slotsContext',
		slots = {};

	function setStatus(slotName, status) {
		slots[slotName] = !!status;
	}

	function setupSlots() {
		var context = adContext.getContext(),
			isHome = params.getPageType() === 'home';

		setStatus('HOME_TOP_LEADERBOARD', isHome);
		setStatus('HOME_TOP_RIGHT_BOXAD', isHome);
		setStatus('PREFOOTER_MIDDLE_BOXAD', isHome);

		setStatus('TOP_LEADERBOARD', !isHome);
		setStatus('TOP_RIGHT_BOXAD', !isHome);
		setStatus('LEFT_SKYSCRAPER_2', !isHome);
		setStatus('LEFT_SKYSCRAPER_3', !isHome);
		setStatus('INCONTENT_BOXAD_1', !isHome);

		setStatus('INVISIBLE_HIGH_IMPACT_2', geo.isProperGeo(instantGlobals.wgAdDriverHighImpact2SlotCountries));
		setStatus('INCONTENT_LEADERBOARD', geo.isProperGeo(instantGlobals.wgAdDriverIncontentLeaderboardSlotCountries));
		setStatus('INCONTENT_PLAYER', geo.isProperGeo(instantGlobals.wgAdDriverIncontentPlayerSlotCountries));

		setStatus('PREFOOTER_RIGHT_BOXAD', !context.opts.overridePrefootersSizes);

		log(['Disabled slots:', slots], 'info', logGroup);
	}

	function isApplicable(slotName) {
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

	setupSlots();
	adContext.addCallback(function () {
		setupSlots();
	});

	return {
		filterSlotMap: filterSlotMap,
		isApplicable: isApplicable
	};
});
