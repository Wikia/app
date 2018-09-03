/*global define*/
define('ext.wikia.adEngine.context.slotsContext', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.video.videoFrequencyMonitor',
	'wikia.document',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, videoFrequencyMonitor, doc, instantGlobals, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.context.slotsContext',
		slots = {};

	function setStatus(slotName, status) {
		log(['setStatus', slotName, status], log.levels.info, logGroup);
		slots[slotName] = !!status;
	}

	function isInContentApplicable() {
		var header = doc.querySelectorAll('#mw-content-text > h2')[1];

		return header && header.offsetWidth >= header.parentNode.offsetWidth;
	}

	function setupSlots() {
		var context = adContext.getContext(),
			isHome = context.targeting.pageType === 'home',
			isOasis = context.targeting.skin === 'oasis',
			isIncontentEnabled =
				!isHome &&
				isOasis &&
				!context.targeting.hasFeaturedVideo &&
				isInContentApplicable() &&
				videoFrequencyMonitor.videoCanBeLaunched();

		// those slots exists on all pages
		setStatus('TOP_LEADERBOARD', true);
		setStatus('TOP_RIGHT_BOXAD', true);
		setStatus('BOTTOM_LEADERBOARD', context.targeting.skin === 'oasis');
		setStatus('INCONTENT_BOXAD_1', !isHome);
		setStatus('INVISIBLE_HIGH_IMPACT_2', context.slots.invisibleHighImpact2);
		setStatus('INCONTENT_PLAYER', isIncontentEnabled);
		setStatus('FEATURED', context.targeting.hasFeaturedVideo);

		log(['Slots:', slots], log.levels.info, logGroup);
	}

	function isApplicable(slotName) {
		return slots[slotName] !== false;
	}

	function filterSlotMap(slotMap) {
		var map = {};

		if (!slotMap) {
			return map;
		}

		Object.keys(slotMap).forEach(function (slotName) {
			if (isApplicable(slotName)) {
				map[slotName] = slotMap[slotName];
			}
		});

		return map;
	}

	function getNotApplicable() {
		var notApplicable = [];

		Object.keys(slots).forEach(function (slot) {
			if (slots[slot] === false) {
				notApplicable.push(slot);
			}
		});

		return notApplicable;
	}

	setupSlots();

	return {
		filterSlotMap: filterSlotMap,
		getNotApplicable: getNotApplicable,
		isApplicable: isApplicable,
		setStatus: setStatus
	};
});
