/*global require*/
require([
'jquery', 'venus.lightboxLoader', 'scrollableTables'], function($, lightboxLoader, scrollableTables) {
	'use strict';

	$(function() {
		//initialize lightbox
		lightboxLoader.init();
		//scan for tables in article and if table is too wide add scrollbar
		scrollableTables.scanForTables();

		$(window)
			.on('resize', $.debounce( 50, scrollableTables.scanForTables))
			.on('wikiaTabClicked', scrollableTables.scanForTables);
	});
});
