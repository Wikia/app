define('wikia.nodeFinder', function() {
	'use strict';
	/**
	 * Find first element described by selector after set offset top value.
	 *
	 * @param {Node} container parent container
	 * @param {String} selector selector to search
	 * @param {Integer} boundaryOffsetTop boundary offset top value
	 * @return {Node} first element after set offset top value
	 */
	function getChildByOffsetTop(container, selector, boundaryOffsetTop) {
		var elements = container.querySelectorAll(selector),
			length = elements.length,
			i;
		for (i = 0; i < length; i++) {
			if (elements[i].offsetTop > boundaryOffsetTop) {
				return elements[i];
			}
		}
		return null;
	}
	/**
	 * Find the last visible element.
	 *
	 * @param {Node} container parent container
	 * @return {Bool}
	 */
	function getLastVisibleChild(container) {
		var child = container.lastChild;
		while (child && !isVisible(child)) {
			child = child.previousElementSibling;
		}
		return child;
	}
	/**
	 * Simple check if an element is visible.
	 *
	 * @param {Node} element node to be checked
	 * @return {Bool}
	 */
	function isVisible(element) {
		return element.offsetWidth > 0 && element.offsetHeight > 0;
	}
	return {
		getChildByOffsetTop: getChildByOffsetTop,
		getLastVisibleChild: getLastVisibleChild
	};
});
