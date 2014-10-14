/*global require*/
require([
'jquery', 'venus.lightboxLoader', 'scrollableTables', 'wikia.window'], function($, lightboxLoader, scrollableTables, w) {
	'use strict';

	function scanTables() {
		var article = document.getElementById('WikiaArticle'),
			tables = article.getElementsByClassName('article-table');

		[].forEach.call(tables, scrollableTables.adjustScroll);
	}

	$(function() {
		//initialize lightbox
		lightboxLoader.init();
		//scan for tables in article and if table is too wide add scrollbar
		scanTables();

		$(w)
			.on('resize', $.debounce(50, scanTables))
			.on('wikiaTabClicked', scanTables);
	});
});
