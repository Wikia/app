/*global define*/
define('ext.wikia.adEngine.provider.turtle', [
	'wikia.log',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slotTweaker'
], function (log, btfBlocker, gptHelper, slotTweaker) {
	'use strict';

	var atfSlots = [
			'INVISIBLE_SKIN',
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD',
			'TURTLE_FLUSH'
		],
		logGroup = 'ext.wikia.adEngine.provider.turtle',
		slotMap = {
			INVISIBLE_SKIN:          {size: '1000x1000,1x1'},
			TOP_LEADERBOARD:         {size: '728x90,970x250,970x90'},
			TOP_RIGHT_BOXAD:         {size: '300x250,300x600'},
			TURTLE_FLUSH:            {flushOnly: true}
		};

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		var ret = !!slotMap[slotName];
		log(['canHandleSlot', slotName, ret], 'debug', logGroup);

		return ret;
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
			'/98544404/Wikia/Nordics_RoN/' + slot.name,
			slotMap[slot.name],
			{
				forcedAdType: 'turtle',
				sraEnabled: true
			}
		);

		log(['fillInSlot', slot, 'done'], 'debug', logGroup);
	}

	return {
		name: 'Turtle',
		canHandleSlot: canHandleSlot,
		fillInSlot: btfBlocker.decorate(fillInSlot, {
			atfSlots: atfSlots
		})
	};
});
