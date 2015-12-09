/*global define*/
define('ext.wikia.adEngine.provider.evolve2', [
	'ext.wikia.adEngine.evolveHelper',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.log'
], function (evolveHelper, gptHelper, slotTweaker, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.evolve2',
		posTargetingValue = {
			'728x90,970x250,970x300,970x90': 'a',
			'300x250,300x600': 'a',
			'1000x1000,1x1': 'a',
			'160x600': 'b',

			'320x50,320x100,300x250': 'a',
			'300x250': 'a'
		},
		section = evolveHelper.getSect(),
		site = 'wikia_intl',
		slotMap = {
			HOME_TOP_LEADERBOARD:     {size: '728x90,970x250,970x300,970x90'},
			HOME_TOP_RIGHT_BOXAD:     {size: '300x250,300x600'},
			HUB_TOP_LEADERBOARD:      {size: '728x90,970x250,970x300,970x90'},
			INVISIBLE_SKIN:           {size: '1000x1000,1x1'},
			LEFT_SKYSCRAPER_2:        {size: '160x600'},
			TOP_LEADERBOARD:          {size: '728x90,970x250,970x300,970x90'},
			TOP_RIGHT_BOXAD:          {size: '300x250,300x600'},

			MOBILE_TOP_LEADERBOARD:   {size: '320x50,320x100,300x250'},
			MOBILE_IN_CONTENT:        {size: '300x250'},
			MOBILE_PREFOOTER:         {size: '300x250'}
		};

	function nextChar(char) {
		return String.fromCharCode(char.charCodeAt(0) + 1);
	}

	function setTargeting(slot) {
		var position = posTargetingValue[slot.size];

		slot.pos = position;
		slot.sect = section;
		slot.site = site;

		// Increment pos value
		posTargetingValue[slot.size] = nextChar(position);
	}

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		var ret = !!slotMap[slotName];
		log(['canHandleSlot', slotName, ret], 'debug', logGroup);

		return ret;
	}

	function fillInSlot(slotName, slotElement, success, hop) {
		log(['fillInSlot', slotName, slotElement, success, hop], 'debug', logGroup);
		var slotCopy = JSON.parse(JSON.stringify(slotMap[slotName]));

		setTargeting(slotCopy);
		gptHelper.pushAd(
			slotName,
			slotElement,
			'/4403/ev/' + site + '/' + section + '/' + slotName,
			slotCopy,
			{
				success: function (adInfo) {
					slotTweaker.removeDefaultHeight(slotName);
					slotTweaker.removeTopButtonIfNeeded(slotName);
					slotTweaker.adjustLeaderboardSize(slotName);

					success(adInfo);
				},
				error: hop
			}
		);

		log(['fillInSlot', slotName, slotElement, success, hop, 'done'], 'debug', logGroup);
	}

	return {
		name: 'Evolve2',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
