/*global define*/
define('wikia.domCalculator', [
	'wikia.document',
	'wikia.window'
], function (doc, win) {
	'use strict';

	function getTopOffset(element) {
		var topPos = 0,
			elementWindow = element.ownerDocument.defaultView;

		do {
			topPos += element.offsetTop;
			element = element.offsetParent;
		} while (element !== null);

		if (elementWindow && elementWindow.frameElement) {
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
			scrollPosition = win.scrollY,
			topViewport = scrollPosition + globalNavHeight,
			bottomViewport = scrollPosition + Math.max(doc.documentElement.clientHeight, win.innerHeight || 0);

		return topElement >= (topViewport - elementHeight/2) &&
			bottomElement <= (bottomViewport + elementHeight/2);
	}

	return {
		getTopOffset: getTopOffset,
		isInViewport: isInViewport
	};
});
