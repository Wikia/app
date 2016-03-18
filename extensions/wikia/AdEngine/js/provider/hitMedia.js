/*global define*/
define('ext.wikia.adEngine.provider.hitMedia', [
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.log'
], function (gptHelper, slotTweaker, zoneParams, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.provider.hitMedia',
		slotMap = {
			HITMEDIA_FLUSH:         {flushOnly: true},

			HOME_TOP_LEADERBOARD:   {size: '728x90,970x250'},
			HOME_TOP_RIGHT_BOXAD:   {size: '300x250,300x600'},
			INVISIBLE_SKIN:         {size: '1000x1000'},
			LEFT_SKYSCRAPER_2:      {size: '160x600'},
			LEFT_SKYSCRAPER_3:      {size: '160x600'},
			TOP_LEADERBOARD:        {size: '728x90,970x250'},
			TOP_RIGHT_BOXAD:        {size: '300x250,300x600'},
			PREFOOTER_LEFT_BOXAD:   {size: '300x250'},
			PREFOOTER_MIDDLE_BOXAD: {size: '300x250'},
			PREFOOTER_RIGHT_BOXAD:  {size: '300x250'},

			MOBILE_TOP_LEADERBOARD: {size: '320x50'},
			MOBILE_IN_CONTENT:      {size: '300x250'},
			MOBILE_PREFOOTER:       {size: '300x250'}
		};

	function getMappedVertical() {
		switch (zoneParams.getSite()) {
			case 'ent':
				return 'entertainment';
			case 'gaming':
				return 'gaming';
			case 'life':
				return 'lifestyle';
			default:
				return 'wikia';
		}
	}

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		var res = !!slotMap[slotName];
		log(['canHandleSlot', slotName, res], 'debug', logGroup);

		return res;
	}

	function fillInSlot(slot) {
		log(['fillInSlot', slot.name], 'debug', logGroup);

		slot.pre('success', function () {
			slotTweaker.removeDefaultHeight(slot.name);
			slotTweaker.removeTopButtonIfNeeded(slot.name);
			slotTweaker.adjustLeaderboardSize(slot.name);
		});

		gptHelper.pushAd(
			slot,
			'/35020072/ru_wikia//' + getMappedVertical(),
			slotMap[slot.name],
			{
				forcedAdType: 'partner/HitMedia',
				sraEnabled: true
			}
		);

		log(['fillInSlot', slot, 'done'], 'debug', logGroup);
	}

	return {
		name: 'HitMedia',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
