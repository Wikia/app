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

	function isUapLoaded() {
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
		getUapId: getUapId,
		isUapLoaded: isUapLoaded,
		reset: reset,
		setUapId: setUapId,
		shouldDispatchEvent: shouldDispatchEvent
	};
});
