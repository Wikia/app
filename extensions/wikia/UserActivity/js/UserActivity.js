require([
	'jquery',
	'wikia.querystring'
], function ($) {

	'use strict';

	$(function () {
		var qs = Wikia.Querystring(),
			order = (qs.getVal('order') || '').split(':'),
			curColumn = order[0] || 'lastedit',
			curDirection = order[1] || 'desc';

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
			if (curColumn === column) {
				return curDirection === 'asc' ? 'selected up' : 'selected down';
			}

			return '';
		}

		function updateOrderFor(column) {
			var newVal;

			if (curColumn === column) {
				// Toggle sort order if same column is clicked
				curDirection = curDirection === 'asc' ? 'desc' : 'asc';
			} else {
				// Sort on new column, defaulting to ascending for title, descending otherwise
				curDirection = column === 'title' ? 'asc' : 'desc';
			}

			newVal = column + ':' + curDirection;
			qs.setVal('order', newVal, true);
			qs.goTo();
		}
	});
});
