/*global define*/
define('ext.wikia.adEngine.provider.remnantGpt', [
	'wikia.log',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.wikiaGptHelper',
	'ext.wikia.adEngine.gptSlotConfig'
], function (log, slotTweaker, wikiaGpt, gptSlotConfig) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.remnantGpt',
		srcName = 'remnant',
		slotMap = gptSlotConfig.getConfig(srcName),
		slotsCalled = {};

	function canHandleSlot(slotname) {

		if (!slotMap[slotname] || slotsCalled[slotname]) {
			return false;
		}

		return true;
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 5, logGroup);

		slotsCalled[slotname] = true;

		wikiaGpt.pushAd(
			slotname,
			function () { // Success
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
				slotTweaker.adjustLeaderboardSize(slotname);

				success();
			},
			function (adInfo) { // Hop
				log(slotname + ' was not filled by DART', 'info', logGroup);

				adInfo.method = 'hop';
				hop(adInfo, 'Liftium');
			},
			srcName
		);

		wikiaGpt.flushAds();
	}

	return {
		name: 'RemnantGpt',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
