require([
	'jquery',
	'wikia.window'
], function (
	$,
	window
) {
	'use strict';

	$(function () {
		// Handles middle click, ctrl+click and regular click
		$('a[data-category-url-encoded]').on('mousedown', function () {
			var $this = $(this);
			var url = window.atob( $this.attr('data-category-url-encoded') );
			$this.attr('href', url);
		});
	});
});
