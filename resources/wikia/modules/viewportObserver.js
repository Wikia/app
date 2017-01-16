/*global define*/
define('wikia.viewportObserver', [
	'wikia.document',
	'wikia.domCalculator',
	'wikia.throttle',
	'wikia.window'
], function (doc, domCalculator, throttle, win) {
	'use strict';

	/**
	 * Element is considered as in the viewport
	 * when at least 50% of its height is in the viewport.
	 * We take into account global navigation height as it covers page elements so they're not visible.
	 */
	function isInViewport(element) {
		var globalNavHeight = 55, // keep in sync with $wds-global-navigation-height
			elementHeight = element.offsetHeight,
			topElement = domCalculator.getTopOffset(element),
			bottomElement = topElement + elementHeight,
			scrollPosition = win.scrollY,
			topViewport = scrollPosition + globalNavHeight,
			bottomViewport = scrollPosition + Math.max(doc.documentElement.clientHeight, win.innerHeight || 0);

		return (topElement >= topViewport - elementHeight/2 && bottomElement <= bottomViewport + elementHeight/2);
	}

	function updateInViewport(listener) {
		var newInViewport = isInViewport(listener.element);

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
		removeListener: removeListener,
		_isInViewport: isInViewport // exposed only for testing purpose
};
});
