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
			maxNodesUp = maxParentsCount || 5,
			classListSupported = element.classList,
			webkitMatchesSelectotSupported = element.webkitMatchesSelector;
		while (element && nodesUp <= maxNodesUp) {
			if (classListSupported && element.classList.contains(targetParentByClass)) {
				return element;
			//Support for Android 2.3
			} else if (webkitMatchesSelectotSupported && element.webkitMatchesSelector('.' + targetParentByClass)) {
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
			addToClassList(element, classes[i]);
		}

		return element;
	}

	/**
	 * Add class to given element classes. Use classList if defined or append to className
	 * @param {Element} element - element which should have new class added
	 * @param {String} className - class which should be added to provided element
	 */
	function addToClassList(element, className) {
		if (element.classList) {
			element.classList.add(className);
		} else {
			if (element.className.length > 0) {
				element.className += ' ' + className;
			} else {
				element.className += className;
			}
		}
	}

	return {
		closestByClassName: closestByClassName,
		createElementWithClass: createElementWithClass
	};
});
