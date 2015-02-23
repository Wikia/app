/*global define*/
define('ext.wikia.adEngine.provider.remnantGptMobile', [
	'wikia.log',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.wikiaGptHelper'
], function (log, adLogicPageParams, wikiaGpt) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.remnantGptMobile',
		slotMap = {
			MOBILE_TOP_LEADERBOARD:     {size: '320x50,1x1'},
			MOBILE_IN_CONTENT:          {size: '300x250,1x1'},
			MOBILE_PREFOOTER:           {size: '300x250,1x1'}
		};

	function canHandleSlot(slotname) {
		return !!slotMap[slotname];
	}

	function fillInSlot(slotName, success, hop) {
		var pageParams = adLogicPageParams.getPageLevelParams(),
			slotTargeting = slotMap[slotName],
			slotPath = '/5441/' +
				'wka.' + pageParams.s0 + '/' + pageParams.s1 + '//' + pageParams.s2 + '/mobile_remnant/' + slotName;

		slotTargeting.pos = slotTargeting.pos || slotName;
		slotTargeting.src = 'mobile_remnant';

		log(['fillInSlot', slotName], 'debug', logGroup);

		wikiaGpt.pushAd(slotName, slotPath, slotTargeting, success, hop);
		wikiaGpt.flushAds();
	}

	return {
		name: 'RemnantGptMobile',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
