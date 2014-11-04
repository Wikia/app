define('venus.moduleInsertion', ['wikia.document'], function(d) {
	'use strict';

	/**
	 * Create module container
	 *
	 * @param {String} id identifier for module container
	 * @param {String} className class name for module container
	 * @returns {Node} module container
	 */
	function createModuleContainer(id, className) {
		var container = d.createElement('div');

		container.id = id;
		container.classList.add(className);

		return container;
	}

	/**
	 * Find first element described by selector after set offset top value
	 *
	 * @param {Node} container parent container
	 * @param {String} selector selector to search
	 * @param {Integer} boundaryOffsetTop boundary offset top value
	 * @returns {Node} first element after set offset top value
	 */
	function findElementByOffsetTop(container, selector, boundaryOffsetTop) {
		var elements = container.querySelectorAll(selector),
			element = null, i = 0;

		for (i= 0; i < elements.length; i++) {
			if (elements[i].offsetTop > boundaryOffsetTop) {
				element = elements[i];
				break;
			}
		}

		return element;
	}

	/**
	 * Insert module before selected element
	 *
	 * @param {Node} container parent container
	 * @param {Node} module module to insert
	 * @param {Node} element element before which module will be inserted
	 */
	function insertModuleBeforeElement(container, module, element) {
		container.insertBefore(module, element);
	}

	/**
	 * Insert module as a last child in container
	 *
	 * @param container parent container
	 * @param module module to insert
	 */
	function insertModuleAsLastChild(container, module) {
		container.appendChild(module);
	}

	return {
		createModuleContainer: createModuleContainer,
		findElementByOffsetTop: findElementByOffsetTop,
		insertModuleBeforeElement: insertModuleBeforeElement,
		insertModuleAsLastChild: insertModuleAsLastChild
	};
});
