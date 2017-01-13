/**

 */
define('wikia.viewportObserver', ['wikia.window', 'wikia.onScroll'], function (win, onScroll) {
	'use strict';

	function addListener(element, callback) {
		var listener = {element: element, callback: callback, inViewport: false};

		onScroll.bind(function() {
			updateInViewport(listener);
		});

		updateInViewport(listener);
	}

	function updateInViewport(listener) {
		var newInViewport = isInViewport(listener.element);

		if (newInViewport !== listener.inViewport) {
			listener.callback(newInViewport);
			listener.inViewport = newInViewport;
		}
	}
	/**
	 * Element is considered as in the viewport
	 * when at least 50% of its height is in the viewport.
	 * We take into account global navigation height as it covers page elements so they're not visible.
	 */
	function isInViewport(element) {
		var globalNavHeight = 55, // keep in sync with $wds-global-navigation-height
			elementHeight = element.offsetHeight,
			topElement = getTopOffset(element),
			bottomElement = topElement + elementHeight,
			topViewport = window.scrollY + globalNavHeight,
			bottomViewport = topViewport + Math.max(document.documentElement.clientHeight, window.innerHeight || 0);

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
	}
});
