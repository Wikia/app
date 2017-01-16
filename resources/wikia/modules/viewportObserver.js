/*global define*/
define('wikia.viewportObserver', [
	'wikia.document',
	'wikia.window'
], function (doc, win) {
	'use strict';

	// TODO extract to new object and reuse in AdEngine
	function getTopOffset(element) {
		var topPos = 0,
			elementWindow = element.ownerDocument.defaultView || element.ownerDocument.parentWindow;

		do {
			topPos += element.offsetTop;
			element = element.offsetParent;
		} while (element !== null);

		if (elementWindow.frameElement) {
			topPos += getTopOffset(elementWindow.frameElement);
		}

		return topPos;
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
			topViewport = win.scrollY + globalNavHeight,
			bottomViewport = topViewport + Math.max(doc.documentElement.clientHeight, win.innerHeight || 0);

		return (topElement >= topViewport - elementHeight/2 && bottomElement <= bottomViewport + elementHeight/2);
	}

	function updateInViewport(listener) {
		var newInViewport = isInViewport(listener.element);

		if (newInViewport !== listener.inViewport) {
			listener.callback(newInViewport);
			listener.inViewport = newInViewport;
		}
	}

	function addListener(element, callback) {
		var listener = {
				element: element,
				callback: callback,
				inViewport: false
			},
			updateCallback = function() {
				updateInViewport(listener);
			};

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
