/*global define*/
define('ext.wikia.adEngine.provider.turtle', [
	'wikia.log',
	'ext.wikia.adEngine.gptHelper',
	'ext.wikia.adEngine.slotTweaker'
], function (log, gptHelper, slotTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.turtle',
		slotMap = {
			HOME_TOP_LEADERBOARD:    {size: '728x90,970x250,970x90'},
			HOME_TOP_RIGHT_BOXAD:    {size: '300x250,300x600'},
			INVISIBLE_SKIN:          {size: '1x1'},
			LEFT_SKYSCRAPER_2:       {size: '160x600'},
			TOP_LEADERBOARD:         {size: '728x90,970x250,970x90'},
			TOP_RIGHT_BOXAD:         {size: '300x250,300x600'}
		};

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		var ret = !!slotMap[slotName];
		log(['canHandleSlot', slotName, ret], 'debug', logGroup);

		return ret;
	}

	function fillInSlot(slotName, success, hop) {
		log(['fillInSlot', slotName, success, hop], 'debug', logGroup);

		gptHelper.pushAd(
			slotName,
			'/98544404/Wikia/Nordics_RoN/' + slotName,
			slotMap[slotName],
			function (adInfo) {
				// Success
				// TODO: find a better place for operation below
				slotTweaker.removeDefaultHeight(slotName);
				slotTweaker.removeTopButtonIfNeeded(slotName);
				slotTweaker.adjustLeaderboardSize(slotName);

				success(adInfo);
			},
			hop,
			'turtle'
		);
		gptHelper.flushAds();

		log(['fillInSlot', slotName, success, hop, 'done'], 'debug', logGroup);
	}

	return {
		name: 'Turtle',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
