require([
	'jquery',
	'wikia.querystring'
], function ($) {

	'use strict';

	$(function () {
		var orderMatch = /order=([^:]+):(desc|asc)/i,
			queryMatches,
			curOrder = 'lastedit',
			curDirection = 'desc',
			curLocation = window.location;

		queryMatches = curLocation.search.match(orderMatch);
		if (queryMatches) {
			curOrder = queryMatches[1] || 'lastedit';
			curDirection = queryMatches[2] || 'desc';
		}

		$('#title-header')
			.addClass(function () {
				return updateHighlightFor('title');
			})
			.click(function () {
				updateOrderFor('title');
			});
		$('#edits-header')
			.addClass(function () {
				return updateHighlightFor('edits');
			})
			.click(function () {
				updateOrderFor('edits');
			});
		$('#last-edit-header')
			.addClass(function () {
				return updateHighlightFor('lastedit');
			})
			.click(function () {
				updateOrderFor('lastedit');
			});

		function updateHighlightFor(column) {
			if (curOrder === column) {
				return curDirection === 'asc' ? 'selected up' : 'selected down';
			}

			return '';
		}

		function updateOrderFor(column) {
			var newURL,
				orderParam;

			if (curOrder === column) {
				curDirection = curDirection === 'asc' ? 'desc' : 'asc';
			} else {
				// Default to ascending for title, descending for everything else
				curDirection = column === 'title' ? 'asc' : 'desc';
			}

			orderParam = 'order=' + column + ':' + curDirection;

			if (queryMatches) {
				newURL = curLocation.href.replace(orderMatch, orderParam);
			} else {
				newURL = curLocation.href + (curLocation.href.indexOf('?') === -1 ? '?' : '&') + orderParam;
			}
			window.location.assign(newURL);
		}
	});
});
