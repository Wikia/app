/* global define */
define('scrollableTables', ['jquery'], function($) {
	'use strict';

	function adjustScroll(table) {
		var scrollable = closestByClassName(table, 'table-scrollable', 3),
			articleContent = document.getElementById('mw-content-text'),
			isWide = table.offsetWidth > articleContent.offsetWidth;

		// wrap table if not wrapped and is wide enough
		if (isWide && !scrollable) {
			wrap(table);
		} else if (!isWide && scrollable) {
			unwrap(table);
		}

		if (scrollable) {
			$(scrollable).floatingScrollbar(isWide);
		}
	}

	function wrap(element) {
		var parent, sibling, tableWrapper, tableScrollable;

		parent = element.parentNode;
		sibling = element.nextSibling;
		tableWrapper = document.createElement('div');
		tableWrapper.className = 'table-scrollable-wrapper table-is-wide';
		tableScrollable = document.createElement('div');
		tableScrollable.className = 'table-scrollable';
		tableWrapper.appendChild(tableScrollable);

		tableScrollable.appendChild(element);

		if (sibling) {
			parent.insertBefore(tableWrapper, sibling);
		} else {
			parent.appendChild(tableWrapper);
		}
	}

	function unwrap(element) {
		var tableWrapper, parent;

		tableWrapper = closestByClassName(element, 'table-scrollable-wrapper');
		if (tableWrapper) {
			parent  = tableWrapper.parentNode;
			parent.insertBefore(element, tableWrapper);
			parent.removeChild(tableWrapper);
		}
	}

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
		return undefined;
	}

	return {
		adjustScroll: adjustScroll
	};
});
