require([
	'jquery',
	'wikia.window',
	'wikia.cache',
	'wikia.tracker'
], function ($, win, cache, tracker) {
	'use strict';

	function overrideStyles() {
		$('#WikiaPage').addClass('community-full-width-page');
	}

	$(function () {
		overrideStyles();
	});
});
