define('wikia.nodeFinder', function () {
	'use strict';

	/**
	 * Find first element described by selector after set offset top value which width is 100% of container.
	 *
	 * @param {Element} container parent container
	 * @param {String} selector selector to search
	 * @param {Integer} boundaryOffsetTop boundary offset top value
	 * @return {Node} first element after set offset top value
	 */
	function getFullWidthChildByOffsetTop(container, selector, boundaryOffsetTop) {
		var elements = container.querySelectorAll(selector),
			length = elements.length,
			containerWidth = container.offsetWidth,
			i;

		for (i = 0; i < length; i++) {
			if (elements[i].offsetTop > boundaryOffsetTop &&
				elements[i].offsetWidth >= containerWidth) {

				return elements[i];
			}
		}

		return null;
	}

	/**
	 * Find the closest previous visible element.
	 *
	 * @param {Node} referenceNode node to start searching from (exclusively)
	 * @return {Node} or null if not found
	 */
	function getPreviousVisibleSibling(referenceNode) {
		var node = referenceNode.previousSibling;

		while (node && !hasDimension(node)) {
			node = node.previousSibling;
		}

		return node;
	}

	/**
	 * Find the last visible element.
	 *
	 * @param {Node} container parent container
	 * @return {Node} or null if not found
	 */
	function getLastVisibleChild(container) {
		var child = container.lastChild;

		if (hasDimension(child)) {
			return child;
		}

		return getPreviousVisibleSibling(child);
	}

	/**
	 * Simple check if an element is rendered.
	 * This method works well with modules like Sloth
	 * while still avoiding the actual dependency.
	 *
	 * @param {Node} element node to be checked
	 * @return {Bool}
	 */
	function hasDimension(element) {
		return element.scrollWidth || element.scrollHeight;
	}

	return {
		getFullWidthChildByOffsetTop: getFullWidthChildByOffsetTop,
		getPreviousVisibleSibling: getPreviousVisibleSibling,
		getLastVisibleChild: getLastVisibleChild
	};
});
