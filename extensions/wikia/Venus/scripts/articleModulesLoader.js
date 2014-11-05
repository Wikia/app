/*global require*/
require(
	['wikia.window', 'wikia.document', 'jquery', 'venus.lightboxLoader', 'scrollableTables',  'wikia.venusToc'],
	function (win, doc, $, lightboxLoader, scrollableTables, tocModule) {
		'use strict';

		var $win = $(win);

		/** Look for all tables on article and add or remove scrollbar if needed */
		function scanTables() {
			var innerArticle = doc.getElementById('mw-content-text'),
				tables = innerArticle.getElementsByClassName('article-table');

			[].forEach.call(tables, function (table) {
				scrollableTables.adjustScroll(table, innerArticle.offsetWidth);
			});
		}

		// initialize TOC in left navigation
		// Right now it is commented out because it is breaking pages when headers are not present
//		tocModule.init('leftNavToc');

		//scan for tables in article and if table is too wide add scrollbar
		scanTables();
		$win
			.on('resize', $.throttle(100, scanTables))
			// wikiaTabClicked event is triggered when user switches between different tabs in article
			.on('wikiaTabClicked', scanTables);

		$(function () {
			//Lightbox initialization needs to be done after DOMReady
			//in order to be sure that Bucky is in place
			lightboxLoader.init();
		});
	}
);
