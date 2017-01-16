/*global define*/
define('wikia.viewportObserver', [
	'wikia.domCalculator',
	'wikia.throttle',
	'wikia.window'
], function (domCalculator, throttle, win) {
	'use strict';

	function updateInViewport(listener) {
		var newInViewport = domCalculator.isInViewport(listener.element);

		if (newInViewport !== listener.inViewport) {
			listener.callback(newInViewport);
			listener.inViewport = newInViewport;
		}
	}

	function addListener(element, callback, throttleThreshold) {
		var listener = {
				element: element,
				callback: callback,
				inViewport: false
			},
			updateCallback = throttle(function() {
				updateInViewport(listener);
			}, throttleThreshold);

		win.addEventListener('scroll', updateCallback);
		updateCallback();

		return updateCallback;
	}

	function removeListener(listener) {
		win.removeEventListener('scroll', listener);
	}

	/**
	 * return API to add a new/remove listener
	 */
	return {
		addListener: addListener,
		removeListener: removeListener
	};
});
