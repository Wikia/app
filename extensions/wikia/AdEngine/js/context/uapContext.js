/*global define*/
define('ext.wikia.adEngine.context.uapContext', [
	'ext.wikia.adEngine.utils.eventDispatcher',
	'wikia.log'
], function (eventDispatcher, log) {
	'use strict';

	var context = {},
		logGroup = 'ext.wikia.adEngine.context.uapContext',
		mainSlotName = 'TOP_LEADERBOARD';

	function setUapId(uap) {
		context.uapId = uap;
	}

	function getUapId() {
		return context.uapId;
	}

	function setType(type) {
		context.type = type;
	}

	function getType() {
		return context.type;
	}

	function isUapLoaded() {
		var isUapType = !!(context.type === 'uap' || context.type === 'vuap');

		return !!context.uapId && isUapType;
	}

	function isBfaaLoaded() {
		return !!context.uapId;
	}

	function reset() {
		context = {};
	}

	function shouldDispatchEvent(slotName) {
		return !context.eventDispatched && slotName.indexOf(mainSlotName) !== -1;
	}

	function dispatchEvent() {
		var eventName = isUapLoaded() ? 'wikia.uap' : 'wikia.not_uap';

		eventDispatcher.dispatch(eventName);
		context.eventDispatched = true;
		log(['dispatchEvent', eventName], 'info', logGroup);
	}

	return {
		dispatchEvent: dispatchEvent,
		getType: getType,
		getUapId: getUapId,
		isBfaaLoaded: isBfaaLoaded,
		isUapLoaded: isUapLoaded,
		reset: reset,
		setType: setType,
		setUapId: setUapId,
		shouldDispatchEvent: shouldDispatchEvent
	};
});
