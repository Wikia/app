require([
	'jquery',
	'wikia.window'
], function (
	$,
	window
) {
	'use strict';

	const decodeUncrawlableURL = function() {

		// Handles middle click, ctrl+click and regular click
		$('a[data-uncrawlable-url]').on('mousedown', function () {
			var $this = $(this);
			var url = window.atob($this.attr('data-uncrawlable-url'));
			$this.attr('href', url);
		});
	};

	$(decodeUncrawlableURL);

	$( window ).on( 'EditPageAfterRenderPreview', decodeUncrawlableURL);

});
