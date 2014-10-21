/*global require*/
require([
	'jquery', 'venus.lightboxLoader', 'scrollableTables', 'wikia.window'
], function($, lightboxLoader, scrollableTables, win) {
	'use strict';
	var doc = win.document,
		$win = $(win);

	/** Look for all tables on article and add or remove scrollbar if needed */
	function scanTables() {
		var innerArticle = doc.getElementById('mw-content-text'),
			tables = innerArticle.getElementsByClassName('article-table');

		[].forEach.call(tables, function(table) {
			scrollableTables.adjustScroll(table, innerArticle.offsetWidth);
		});
	}

	//init lightbox
	lightboxLoader.init();

	//scan for tables in article and if table is too wide add scrollbar
	scanTables();

		$win
			.on('resize', $.throttle(100, scanTables))
			// wikiaTabClicked event is triggered when user switches between different tabs in article
			.on('wikiaTabClicked', scanTables);
});
