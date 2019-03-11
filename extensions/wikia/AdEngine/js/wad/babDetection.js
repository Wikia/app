/*global define*/
define('ext.wikia.adEngine.wad.babDetection', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.tracker',
	'wikia.window'
], function (adContext, doc, lazyQueue, log, tracker, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wad.babDetection',
		detectionCompleted = false,
		onResponseCallbacks = [];

	function getName() {
		return 'babDetection';
	}

	function isEnabled() {
		return adContext.get('opts.babDetectionDesktop') || adContext.get('opts.babDetectionMobile');
	}

	function addResponseListener(callback) {
		onResponseCallbacks.push(callback);
	}

	function resetState() {
		detectionCompleted = false;
		onResponseCallbacks = [];
		lazyQueue.makeQueue(onResponseCallbacks, function (callback) {
			callback();
		});
	}

	function dispatchDetectionEvent(eventName) {
		var event = doc.createEvent('Event');
		event.initEvent(eventName, true, false);

		doc.dispatchEvent(event);
	}

	function setRuntimeParams(isAdBlockDetected) {
		win.ads.runtime = win.ads.runtime || {};
		win.ads.runtime.bab = win.ads.runtime.bab || {};
		win.ads.runtime.bab.blocking = isAdBlockDetected;
	}

	function initDetection(isAdBlockDetected) {
		var eventName = isAdBlockDetected ? 'bab.blocking' : 'bab.not_blocking';

		log(['BlockAdBlock detection, adBlock detected:', isAdBlockDetected], 'debug', logGroup);

		setRuntimeParams(isAdBlockDetected);
		dispatchDetectionEvent(eventName);

		tracker.track({
			category: 'ads-babdetector-detection',
			action: 'impression',
			label: isAdBlockDetected ? 'Yes' : 'No',
			value: 0,
			trackingMethod: 'internal'
		});

		if (!detectionCompleted) {
			detectionCompleted = true;
			onResponseCallbacks.start();
		}
	}

	function isBlocking() {
		if (win.ads && win.ads.runtime && win.ads.runtime.bab) {
			return win.ads.runtime.bab.blocking;
		}

		return undefined;
	}

	resetState();

	return {
		addResponseListener: addResponseListener,
		getName: getName,
		initDetection: initDetection,
		isBlocking: isBlocking,
		wasCalled: isEnabled
	};
});
