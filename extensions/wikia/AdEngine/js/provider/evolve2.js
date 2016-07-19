/*global define*/
define('ext.wikia.adEngine.provider.evolve2', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.log',
	'wikia.window'
], function (adContext, gptHelper, slotTweaker, zoneParams, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.evolve2',
		posTargetingValue,
		site = 'wikia_intl',
		slotMap = {
			EVOLVE_FLUSH:             {flushOnly: true},
			HOME_TOP_LEADERBOARD:     {size: '728x90,970x250,970x300,970x90', wloc: 'top'},
			HOME_TOP_RIGHT_BOXAD:     {size: '300x250,300x600', wloc: 'top'},
			HUB_TOP_LEADERBOARD:      {size: '728x90,970x250,970x300,970x90', wloc: 'top'},
			INVISIBLE_SKIN:           {size: '1000x1000,1x1', wloc: 'top'},
			LEFT_SKYSCRAPER_2:        {size: '160x600', wloc: 'middle'},
			TOP_LEADERBOARD:          {size: '728x90,970x250,970x300,970x90', wloc: 'top'},
			TOP_RIGHT_BOXAD:          {size: '300x250,300x600', wloc: 'top'},

			MOBILE_TOP_LEADERBOARD:   {size: '320x50,320x100,300x250', wsrc: 'mobile_evolve'},
			MOBILE_IN_CONTENT:        {size: '300x250', wsrc: 'mobile_evolve'},
			MOBILE_PREFOOTER:         {size: '300x250', wsrc: 'mobile_evolve'}
		};

	// TODO: ADEN-3542
	function dispatchNoUapEvent(slotName) {
		if (slotName === 'MOBILE_TOP_LEADERBOARD') {
			win.dispatchEvent(new Event('wikia.not_uap'));
		}
	}

	function resetPosTargeting() {
		posTargetingValue = {
			'728x90,970x250,970x300,970x90': 'a',
			'300x250,300x600': 'a',
			'1000x1000,1x1': 'a',
			'160x600': 'b',

			'320x50,320x100,300x250': 'a',
			'300x250': 'a'
		};
	}

	function getSection() {
		var vertical = zoneParams.getVertical(),
			mappedVertical = zoneParams.getSite();

		switch (vertical) {
			case 'movies':
			case 'tv':
				return vertical;
		}

		switch (mappedVertical) {
			case 'gaming':
				return 'gaming';
			case 'ent':
				return 'entertainment';
		}

		return 'ros';
	}

	function nextChar(char) {
		return String.fromCharCode(char.charCodeAt(0) + 1);
	}

	function setTargeting(slot) {
		var position = posTargetingValue[slot.size];

		slot.pos = position;
		if (!slot.wsrc) {
			slot.wsrc = 'evolve';
		}

		// Increment pos value
		posTargetingValue[slot.size] = nextChar(position);
	}

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		var ret = !!slotMap[slotName];
		log(['canHandleSlot', slotName, ret], 'debug', logGroup);

		return ret;
	}

	function fillInSlot(slot) {
		log(['fillInSlot', slot.name], 'debug', logGroup);
		var section = getSection(),
			slotCopy = JSON.parse(JSON.stringify(slotMap[slot.name]));

		if (!slotCopy.flushOnly) {
			slotCopy.wpos = slot.name;
			setTargeting(slotCopy);
		}
		slot.pre('success', function () {
			slotTweaker.removeDefaultHeight(slot.name);
			slotTweaker.removeTopButtonIfNeeded(slot.name);
			slotTweaker.adjustLeaderboardSize(slot.name);
			dispatchNoUapEvent(slot.name);
		});
		slot.pre('collapse', function() {
			dispatchNoUapEvent(slot.name);
		});
		slot.pre('hop', function() {
			dispatchNoUapEvent(slot.name);
		});
		gptHelper.pushAd(
			slot,
			'/4403/ev/' + site + '/' + section + '/' + slot.name,
			slotCopy,
			{
				forcedAdType: 'evolve2',
				sraEnabled: true
			}
		);

		log(['fillInSlot', slot.name, 'done'], 'debug', logGroup);
	}

	resetPosTargeting();
	adContext.addCallback(function () {
		resetPosTargeting();
	});

	return {
		name: 'Evolve2',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
