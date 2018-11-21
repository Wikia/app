require([
	'jquery',
	'wikia.window'
], function (
	$,
	window
) {
	'use strict';
	$(function () {
		$('a[data-uncrawlable-url]').on('mousedown', function () {

			var $this = $(this);
			var url = window.atob($this.attr('data-uncrawlable-url'));
			$this.attr('href', url);
		});
	});

});
