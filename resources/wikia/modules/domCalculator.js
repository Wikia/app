/*global define*/
define('wikia.domCalculator', [
	'wikia.document',
	'wikia.window'
], function (doc, win) {
	'use strict';

	/**
	 * Returns element's offset of given element depending on offset parameter name
	 *
	 * @param element - DOM element
	 * @param offsetParameter - node element parameter to count overall offset
	 * @returns {number} - offset in pixels
	 */
	function getElementOffset(element, offsetParameter) {
		var borderPos = 0,
			elementWindow = element.ownerDocument.defaultView;

		do {

			borderPos += element[offsetParameter];
			element = element.offsetParent;
		} while (element !== null);

		if (elementWindow && elementWindow.frameElement) {
			borderPos += getElementOffset(elementWindow.frameElement, offsetParameter);
		}

		return borderPos;
	}

	/**
	 * Returns element's offset of given element from the top of the page
	 *
	 * @param element - DOM element
	 * @returns {number} - offset in pixels
	 */
	function getTopOffset(element) {
		return getElementOffset(element, 'offsetTop');
	}

	/**
	 * Returns element's offset of given element from the left of the page
	 *
	 * @param element - DOM element
	 * @returns {number} - offset in pixels
	 */
	function getLeftOffset(element) {
		return getElementOffset(element, 'offsetLeft');
	}

	/**
	 * Element is considered as in the viewport
	 * when at least 50% of its height is in the viewport.
	 * We take into account global navigation height as it covers page elements so they're not visible.
	 *
	 * @param element - DOM element
	 * @returns {boolean} - true if element is in viewport
	 */
	function isInViewport(element) {
		var globalNavHeight = 55, // keep in sync with $wds-global-navigation-height
			elementHeight = element.offsetHeight,
			topElement = getTopOffset(element),
			bottomElement = topElement + elementHeight,
			scrollPosition = win.scrollY,
			topViewport = scrollPosition + globalNavHeight,
			bottomViewport = scrollPosition + Math.max(doc.documentElement.clientHeight, win.innerHeight || 0);

		return topElement >= (topViewport - elementHeight / 2) &&
			bottomElement <= (bottomViewport + elementHeight / 2);
	}

	/**
	 * Returns element's offset of given element from the left of the page
	 *
	 * @param number - number to check
	 * @param from - range start
	 * @param length - range length
	 * @returns {boolean} - true if number is between from and from+length
	 */
	function isBetween(number, from, length) {
		return number >= from && number <= (from + length);
	}

	/**
	 * Returns viewport left offset
	 *
	 * @returns {number} - offset in pixels
	 */
	function getScrollX() {
		return win.scrollX || win.pageXOffset;
	}

	/**
	 * Returns viewport top offset
	 *
	 * @returns {number} - offset in pixels
	 */
	function getScrollY() {
		return win.scrollY || win.pageYOffset;
	}

	/**
	 * Checks if floating element is in conflict with given element
	 *
	 * @param floating - DOM element
	 * @param element - DOM element
	 * @returns {boolean} - true if floating is in conflict with element
	 */
	function isFloatingInConflict(floating, element) {
		if (!floating || !element) {
			return false;
		}

		floating = {
			l: getLeftOffset(floating) + getScrollX(),
			t: getTopOffset(floating) + getScrollY(),
			w: floating.offsetWidth,
			h: floating.offsetHeight
		};
		element = {
			l: getLeftOffset(element),
			t: getTopOffset(element),
			w: element.offsetWidth,
			h: element.offsetHeight
		};

		if (!floating.w || !floating.h || !element.w || !element.h) {
			return false;
		}

		return isBetween(floating.l, element.l, element.w) && (
			isBetween(floating.t, element.t, element.h) ||
			isBetween(floating.t + floating.h, element.t, element.h) ||
			(floating.t < element.t && floating.t + floating.h > element.t + element.h) ||
			(floating.t > element.t && floating.t + floating.h < element.t + element.h)
		);
	}

	return {
		getTopOffset: getTopOffset,
		getLeftOffset: getLeftOffset,
		isFloatingInConflict: isFloatingInConflict,
		isInViewport: isInViewport
	};
});
