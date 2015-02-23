/*global define*/
/*jshint maxlen:140*/
define('ext.wikia.adEngine.provider.remnantGpt', [
	'wikia.log',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.wikiaGptHelper',
	'ext.wikia.adEngine.adLogicPageParams'
], function (log, slotTweaker, wikiaGpt, adLogicPageParams) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.remnantGpt',
		slotMap = {
			BOTTOM_LEADERBOARD:         {size: '728x90,300x250', loc: 'bottom'},
			EXIT_STITIAL_BOXAD_1:       {size: '300x250,600x400,800x450,550x480', loc: 'exit'},
			HOME_TOP_LEADERBOARD:       {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			HOME_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			INCONTENT_1A:               {size: '300x250', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_1B:               {size: '300x250,160x600', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_1C:               {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_2A:               {size: '300x250', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_2B:               {size: '300x250,160x600', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_2C:               {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_3A:               {size: '300x250', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_3B:               {size: '300x250,160x600', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_3C:               {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_BOXAD_1:          {size: '300x250', loc: 'middle'},
			INCONTENT_LEADERBOARD_1:    {size: '728x90,468x90', loc: 'middle'},
			INCONTENT_LEADERBOARD_2:    {size: '728x90,468x90', loc: 'middle'},
			INCONTENT_LEADERBOARD_3:    {size: '728x90,468x90', loc: 'middle'},
			LEFT_SKYSCRAPER_2:          {size: '160x600', loc: 'middle'},
			LEFT_SKYSCRAPER_3:          {size: '160x600', loc: 'footer'},
			PREFOOTER_LEFT_BOXAD:       {size: '300x250', loc: 'footer'},
			PREFOOTER_RIGHT_BOXAD:      {size: '300x250', loc: 'footer'},
			TOP_LEADERBOARD:            {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			TOP_RIGHT_BOXAD:            {size: '300x250,300x600,300x1050', loc: 'top'}
		};

	function canHandleSlot(slotName) {
		return !!slotMap[slotName];
	}

	function fillInSlot(slotName, success, hop) {
		log(['fillInSlot', slotName], 'debug', logGroup);

		var pageParams = adLogicPageParams.getPageLevelParams(),
			slotTargeting = slotMap[slotName],
			slotPath = '/5441/wka.' + pageParams.s0 + '/' + pageParams.s1 + '//' + pageParams.s2 + '/remnant/' + slotName;

		slotTargeting.src = 'remnant';
		slotTargeting.pos = slotTargeting.pos || slotName;

		lookups.extendSlotTargeting(slotName, slotTargeting);

		wikiaGpt.pushAd(
			slotName,
			slotPath,
			slotTargeting,
			function (adInfo) { // Success
				slotTweaker.removeDefaultHeight(slotName);
				slotTweaker.removeTopButtonIfNeeded(slotName);
				slotTweaker.adjustLeaderboardSize(slotName);

				success(adInfo);
			},
			function (adInfo) { // Hop
				log(slotName + ' was not filled by DART', 'info', logGroup);

				adInfo.method = 'hop';
				hop(adInfo);
			}
		);

		wikiaGpt.flushAds();
	}

	return {
		name: 'RemnantGpt',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
