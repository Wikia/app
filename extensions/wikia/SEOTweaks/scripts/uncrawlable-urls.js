require([
	'jquery',
	'wikia.window'
], function (
	$,
	window
) {
	'use strict';

	var $body = $('body'),
		$wikiaArticle = $('#WikiaArticle');

	function decodeUncrawlableURL(){

		// Handles middle click, ctrl+click and regular click
		$('a[data-uncrawlable-url]').on('mousedown', function () {
			var $this = $(this);
			var url = window.atob($this.attr('data-uncrawlable-url'));
			$this.attr('href', url);
		});
	}

	$(decodeUncrawlableURL);

	mw.hook('wikipage.content').add(decodeUncrawlableURL);

	if ($body.hasClass('page-Special_RecentChanges')) {

		// Decode uncrawlable URL for redlinks on RecentChanges which uses AjaxRC custom JS
		$wikiaArticle.on('mousedown', 'a', function () {
			var $this = $(this);
			var url = window.atob($this.attr('data-uncrawlable-url'));
			$this.attr('href', url);
		});
	}

});
