/*global define*/
define('ext.wikia.adEngine.context.uapContext', [
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'wikia.log'
], function (adEngineBridge, eventDispatcher, log) {
	'use strict';

	var eventDispatched = false,
		logGroup = 'ext.wikia.adEngine.context.uapContext',
		mainSlotName = 'TOP_LEADERBOARD';

	function reset() {
		adEngineBridge.universalAdPackage.reset();
		eventDispatched = false;
	}

	function getUapID() {
		return adEngineBridge.universalAdPackage.getUapId();
	}

	function isFanTakeoverLoaded() {
		return adEngineBridge.universalAdPackage.isFanTakeoverLoaded();
	}

	function shouldDispatchEvent(slotName) {
		return !eventDispatched && slotName.indexOf(mainSlotName) !== -1;
	}

	function dispatchEvent() {
		var eventName = isFanTakeoverLoaded() ? 'wikia.uap' : 'wikia.not_uap';

		eventDispatcher.dispatch(eventName);
		eventDispatched = true;
		log(['dispatchEvent', eventName], 'info', logGroup);
	}

	return {
		dispatchEvent: dispatchEvent,
		getUapId: getUapID,
		isFanTakeoverLoaded: isFanTakeoverLoaded,
		reset: reset,
		shouldDispatchEvent: shouldDispatchEvent
	};
});
