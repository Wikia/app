/*global define*/
define('wikia.viewportObserver', [
	'wikia.document',
	'wikia.domCalculator',
	'wikia.throttle',
	'wikia.window'
], function (doc, domCalculator, throttle, win) {
	'use strict';

	function updateInViewport(listener) {
		var newInViewport = domCalculator.isInViewport(listener.element);

		if (newInViewport !== listener.inViewport) {
			listener.callback(newInViewport);
			listener.inViewport = newInViewport;
		}
	}

	function sameViewport(element, otherElements) {
		element = doc.getElementById(element);

		var windowHeight = win.innerHeight || doc.documentElement.clientHeight || doc.body.clientHeight,
			elementOffset = domCalculator.getTopOffset(element),
			elementHeight = element.offsetHeight,
			found = false;

		otherElements.forEach(function (other) {
			other = doc.getElementById(other);

			var otherOffset = domCalculator.getTopOffset(other),
				otherHeight = other.offsetHeight;

			if (elementOffset < otherOffset) {
				if (otherOffset - elementOffset - elementHeight < windowHeight) {
					found = true;
				}
			} else {
				if (elementOffset - otherOffset - otherHeight < windowHeight) {
					found = true;
				}
			}
		});

		return found;
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
		sameViewport: sameViewport,
		addListener: addListener,
		removeListener: removeListener
	};
});
