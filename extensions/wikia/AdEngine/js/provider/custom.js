/*global define, require*/
define('ext.wikia.adEngine.provider.custom', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'wikia.log',
], function (adContext, gptHelper, slotTweaker, zoneParams, eventDispatcher, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.evolve2',
		site = 'wikia_intl',
		slotMap = {
			HOME_TOP_LEADERBOARD:     {size: '728x90,970x250,970x300,970x90'},
		};

	function canHandleSlot(slotName) {
		log(['canHandleSlot', slotName], 'debug', logGroup);
		var ret = !!slotMap[slotName];
		log(['canHandleSlot', slotName, ret], 'debug', logGroup);

		return ret;
	}

	function fillInSlot(slot) {
		log(['fillInSlot', slot.name], 'debug', logGroup);

		var img = new Image();
		img.src = 'https://placekitten.com/g/700/200';
		slot.container.appendChild(img);

		log(['fillInSlot', slot.name, 'done'], 'debug', logGroup);
	}

	return {
		name: 'custom',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
