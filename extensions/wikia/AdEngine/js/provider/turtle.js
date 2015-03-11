/*global define*/
define('ext.wikia.adEngine.provider.turtle', [
	'wikia.log',
	'ext.wikia.adEngine.gptHelper'
], function (log, gptHelper) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.turtle',
		slotMap = {
			HOME_TOP_LEADERBOARD: {size: '728x90,970x250,970x90'},
			HOME_TOP_RIGHT_BOXAD: {size: '300x250'},
			LEFT_SKYSCRAPER_2:    {size: '160x600,300x600'},
			TOP_LEADERBOARD:      {size: '728x90,970x250,970x90'},
			TOP_RIGHT_BOXAD:      {size: '300x250'}
		};

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		var ret = !!slotMap[slotName];
		log(['canHandleSlot', slotName, ret], 'debug', logGroup);

		return ret;
	}

	function fillInSlot(slotName, success, hop) {
		log(['fillInSlot', slotName, success, hop], 'debug', logGroup);

		gptHelper.pushAd(slotName, '/98544404/Wikia/Testing/' + slotName, slotMap[slotName], success, hop, 'async');
		gptHelper.flushAds();

		log(['fillInSlot', slotName, success, hop, 'done'], 'debug', logGroup);
	}

	return {
		name: 'Turtle',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
