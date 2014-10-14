/* global define */
define('scrollableTables', ['jquery'], function($) {
	'use strict';

	var article, tables, scanForTables, wrap, unwrap, closest;

	article = document.getElementById('WikiaArticle');
	tables = article.getElementsByClassName('article-table');

	scanForTables = function() {
		[].forEach.call(tables, function(table) {
			var scrollable = closest(table, 'table-scrollable', 3),
				isWide = table.offsetWidth > article.offsetWidth;

			// wrap table if not wrapped and is wide enough
			if (isWide && !scrollable) {
				wrap(table);
			} else if (!isWide && scrollable) {
				unwrap(table);
			}

			if (scrollable) {
				$(scrollable).floatingScrollbar(isWide);
			}
		});
	};

	wrap = function(element) {
		var parent, sibling, tableWrapper, tableScrollable;

		parent = element.parentNode;
		sibling = element.nextSibling;
		tableWrapper = document.createElement('div');
		tableWrapper.className = 'table-scrollable-wrapper table-is-wide';
		tableScrollable = document.createElement('div');
		tableScrollable.className = 'table-scrollable';
		tableWrapper.appendChild(tableScrollable);

		console.log(tableWrapper);
		tableScrollable.appendChild(element);

		if (sibling) {
			parent.insertBefore(tableWrapper, sibling);
		} else {
			parent.appendChild(tableWrapper);
		}
	};

	unwrap = function(element) {
		var tableWrapper, parent;

		tableWrapper = closest(element, 'table-scrollable-wrapper');
		if (tableWrapper) {
			parent  = tableWrapper.parentNode;
			parent.insertBefore(element, tableWrapper);
			parent.removeChild(tableWrapper);
		}
	};

	closest = function(element, targetParentByClass, maxParentsCount) {
		var nodesUp = 0;
		while (element && nodesUp <= maxParentsCount) {
			if (element.classList.contains(targetParentByClass)) {
				return element;
			}
			element = element.parentNode;
			nodesUp++;
		}
		return undefined;
	};

	return {
		scanForTables: scanForTables
	};
});
