/*global define*/
define('wikia.viewportObserver', [
	'wikia.document',
	'wikia.window'
], function (doc, win) {
	'use strict';

	function addListener(element, callback) {
		var listener = {element: element, callback: callback, inViewport: false};

		window.addEventListener('scroll', function() {
			updateInViewport(listener);
		});

		updateInViewport(listener);
	}

	/**
	 * Element is considered as in the viewport
	 * when at least 50% of its height is in the viewport
	 */
	function updateInViewport(listener) {
		var newInViewport = isInViewport(listener.element);

		if (newInViewport !== listener.inViewport) {
			listener.callback(newInViewport);
			listener.inViewport = newInViewport;
		}
	}

	function isInViewport(element) {
		var elementHeight = element.offsetHeight,
			topElement = getTopOffset(element),
			bottomElement = topElement + elementHeight,
			topViewport = win.scrollY,
			bottomViewport = win.scrollY + Math.max(document.documentElement.clientHeight, win.innerHeight || 0);

		return (topElement >= topViewport - elementHeight/2 && bottomElement <= bottomViewport + elementHeight/2);
	}

	function getTopOffset(el) {
		var topPos = 0;

		for (; el !== null; el = el.offsetParent) {
			topPos += el.offsetTop;
		}

		return topPos;
	}

	/**
	 * return API to add a new listener
	 */
	return {
		addListener: addListener
	};
});
