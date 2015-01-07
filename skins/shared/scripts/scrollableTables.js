/* global define */
define('scrollableTables', ['wikia.window', 'wikia.dom'], function (win, dom) {
	'use strict';

	/**
	 * Add or remove scroll from table
	 * @param {HTMLElement} table - table node.
	 * @param {Number} articleWidth - width of article
	 */
	function adjustScroll(table, articleWidth) {
		var scrollable = dom.closestByClassName(table, 'table-scrollable', 3),
			isWide = table.offsetWidth > articleWidth;

		// wrap table if not wrapped and is wide enough
		if (isWide && !scrollable) {
			wrap(table);
		} else if (!isWide && scrollable) {
			unwrap(table);
		}
	}

	/**
	 * Wrap provided element with two table wrappers
	 * @param {HTMLElement} element - element to be wrapped
	 */
	function wrap(element) {
		var parent = element.parentNode,
			sibling = element.nextSibling,
			tableWrapper = dom.createElementWithClass('div', ['table-scrollable-wrapper', 'table-is-wide']),
			tableScrollable = dom.createElementWithClass('div', ['table-scrollable']);

		tableWrapper.appendChild(tableScrollable);
		tableScrollable.appendChild(element);

		if (sibling) {
			parent.insertBefore(tableWrapper, sibling);
		} else {
			parent.appendChild(tableWrapper);
		}
	}

	/**
	 * Unwrap provided element from two table wrappers
	 * @param {HTMLElement} element - element to be unwrapped
	 */
	function unwrap(element) {
		var tableWrapper = dom.closestByClassName(element, 'table-scrollable-wrapper'),
			parent;

		if (tableWrapper) {
			parent = tableWrapper.parentNode;
			parent.insertBefore(element, tableWrapper);
			parent.removeChild(tableWrapper);
		}
	}

	return {
		adjustScroll: adjustScroll
	};
});
