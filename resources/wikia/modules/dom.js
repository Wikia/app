/* global define */
define('wikia.dom', ['wikia.document'], function (doc) {
	'use strict';
	var addToClassList, selectorMatches;

	/**
	 * Check if provided element contains given class
	 * using classList.contains if available or webkitMatchesSelector if not.
	 * @param {Element} element - element which is checked
	 * @param {String} className - class which should be contained by element
	 */
	selectorMatches = function (element, className) {
		var selector;

		if (!!element.classList) {
			selectorMatches = function (element, className) {
				return element.classList.contains(className);
			};
		} else if (!!element.webkitMatchesSelector) {
			//Support for Android 2.3
			selectorMatches = function (element, className) {
				selector = '.' + className;
				return element.webkitMatchesSelector(selector);
			};
		} else {
			throw new Error('Browser not supported');
		}
		return selectorMatches(element, className);
	};

	/**
	 * Add class to given element classes. Use classList if defined or append to className
	 * @param {Element} element - element which should have new class added
	 * @param {String} className - class which should be added to provided element
	 */
	addToClassList = function (element, className) {
		if (!!element.classList) {
			addToClassList = function (element, className) {
				element.classList.add(className);
			};
		} else {
			addToClassList = function (element, className) {
				element.className = element.className.split(' ').push(className).join(' ');
			};
		}
		return addToClassList(element, className);
	};

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

		while (!!element && nodesUp <= maxNodesUp) {
			if (selectorMatches(element, targetParentByClass)) {
				return element;
			}
			element = element.parentNode;
			nodesUp++;
		}

		return false;
	}

	/**
	 * Find closest element to provided one with given tag name
	 * @param {Node} element - starting element
	 * @param {String} targetParentByTag - tag name for parent element
	 * @param {Number=} maxParentsCount - max number of parents, default value is 5
	 * @returns {Node|Boolean} returns Node or false in case element not found
	 */
	function closestByTagName(element, targetParentByTag, maxParentsCount) {
		var nodesUp = 0,
			maxNodesUp = maxParentsCount || 5;

		targetParentByTag = targetParentByTag.toUpperCase();

		while (!!element && nodesUp <= maxNodesUp) {
			if (element.tagName === targetParentByTag) {
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
		for (i = 0; i < classCount; i++) {
			addToClassList(element, classes[i]);
		}

		return element;
	}

	return {
		closestByClassName: closestByClassName,
		closestByTagName: closestByTagName,
		createElementWithClass: createElementWithClass
	};
});
