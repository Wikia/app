/* global define */
define('wikia.dom', ['wikia.document'], function(doc) {
	'use strict';

	/**
	 * Find closest element to provided one with given class
	 * @param {Node} element - starting element
	 * @param {String} targetParentByClass - class for parent element
	 * @param {Number} maxParentsCount - max number of parents
	 * @returns {Node|Boolean} returns Node or false in case element not found
	 */
	function closestByClassName(element, targetParentByClass, maxParentsCount) {
		var nodesUp = 0,
			maxNodesUp = maxParentsCount || 5;
		while (element && nodesUp <= maxNodesUp) {
			if (element.classList.contains(targetParentByClass)) {
				return element;
			}
			element = element.parentNode;
			nodesUp++;
		}
		return false;
	}

	/**
	 * Create given element with provided classes
	 * @param {String} tag - tag for element
	 * @param {Array} classes - list of classes which should be added to element
	 * @returns {Node}
	 */
	function createElementWithClass(tag, classes) {
		var element = doc.createElement(tag),
			classCount = classes.length,
			i;

		if (classes instanceof Array) {
			for (i=0; i<classCount; i++) {
				element.classList.add(classes[i]);
			}
		} else {
			throw new Error('Not supported format');
		}

		return element;
	}

	return {
		closestByClassName: closestByClassName,
		createElementWithClass: createElementWithClass
	};
});
