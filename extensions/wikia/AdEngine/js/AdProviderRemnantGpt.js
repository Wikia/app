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
		slotMap = gptSlotConfig.getConfig(srcName);

	function canHandleSlot(slotname) {

		if (!slotMap[slotname]) {
			return false;
		}

		return true;
	}

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 5, logGroup);

		wikiaGpt.pushAd(
			slotname,
			function (adInfo) { // Success
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
				slotTweaker.adjustLeaderboardSize(slotname);

				success(adInfo);
			},
			function (adInfo) { // Hop
				log(slotname + ' was not filled by DART', 'info', logGroup);

				adInfo.method = 'hop';
				hop(adInfo);
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
