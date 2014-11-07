define('videosmodule.controllers.nodeFinder', function() {
	'use strict';

	/**
	 * Find first element described by selector after set offset top value
	 *
	 * @param {Node} container parent container
	 * @param {String} selector selector to search
	 * @param {Integer} boundaryOffsetTop boundary offset top value
	 * @returns {Node} first element after set offset top value
	 */
	function findNodeByOffsetTop(container, selector, boundaryOffsetTop) {
		var elements = container.querySelectorAll(selector),
			length = elements.length,
			i;

		for (i = 0; i < length; i++) {
			if (elements[i].offsetTop > boundaryOffsetTop) {
				return elements[i];
			}
		}

		return container.lastChild;
	}

	return {
		findNodeByOffsetTop: findNodeByOffsetTop
	};
});
