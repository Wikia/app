require([
	'jquery'
], function ($) {

	'use strict';

	$(function () {
		var orderMatch = /order=([^:]+):(desc|asc)/i,
			results,
			curOrder,
			curDirection,
			curLocation = window.location;

		results = curLocation.href.match(orderMatch);
		if (results) {
			curOrder = results[1] || 'lastedit';
			curDirection = results[2] || 'desc';
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
			if (typeof curOrder === 'undefined' && column === 'lastedit') {
				return 'selected down';
			} else if (curOrder === column) {
				return curDirection === 'asc' ? 'selected up' : 'selected down';
			} else {
				return '';
			}
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

			if (typeof curOrder === 'undefined') {
				newURL = curLocation.href + (curLocation.href.indexOf('?') === -1 ? '?' : '&') + orderParam;
			} else {
				newURL = curLocation.href.replace(orderMatch, orderParam);
			}
			window.location.assign(newURL);
		}
	});
});
