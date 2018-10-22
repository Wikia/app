require([
	'jquery'
], function (
	$
) {
	'use strict';

	$(function () {
		// Handles middle click, ctrl+click and regular click
		$('a[data-category-url]').on('mousedown', function () {
			var $this = $(this);
			$this.attr('href', $this.attr('data-category-url'));
		});
	});
});
