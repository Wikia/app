/* global define */
define('wikia.dom', ['wikia.document'], function(doc) {
	'use strict';

	/**
	 * Find closest element to provided one with given class
	 * @param {Node} element - starting element
	 * @param {String} targetParentByClass - class for parent element
	 * @param {Number=} maxParentsCount - max number of parents, default value is 5
	 * @returns {Node|Boolean} returns Node or false in case element not found
	 */
	function closestByClassName(element, targetParentByClass, maxParentsCount) {
		var nodesUp = 0,
			maxNodesUp = maxParentsCount || 5;
		while (element && nodesUp <= maxNodesUp) {
			if (element.classList && element.classList.contains(targetParentByClass)) {
				return element;
			//Support for Android 2.3
			} else if (element.webkitMatchesSelector && element.webkitMatchesSelector('.' + targetParentByClass)) {
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
		var element, classCount, i;

		if (!Array.isArray(classes)) {
			throw new Error('Classes argument must be an array');
		}

		classCount = classes.length;
		element = doc.createElement(tag);
		for (i=0; i<classCount; i++) {
			element.classList.add(classes[i]);
		}

		return element;
	}

	return {
		closestByClassName: closestByClassName,
		createElementWithClass: createElementWithClass
	};
});
