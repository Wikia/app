$(function() {
	PageHeader.init();
});

var PageHeader = {

	settings: {
		mouseoverDelay: 300,
		mouseoutDelay: 350
	},

	init: function() {
		PageHeader.history = $("#WikiaPageHeader").find(".history");
		PageHeader.history
			.one("mouseover", PageHeader.loadAvatars)
			.hover(PageHeader.historyMouseover, PageHeader.historyMouseout);

		// RT #70400: show .. ago only for edits made 2 weeks ago or later
		$("time.timeago").
			data('maxdiff', 14 * 86400 * 1000).
			timeago();
	},

	historyMouseover: function(event) {

		//stop the mouseout timer
		clearTimeout(PageHeader.mouseoutTimer);

		//delay before showing menu
		PageHeader.mouseoverTimer = setTimeout(function() {
			$(event.currentTarget).addClass("hover");

			$.tracker.byStr('pageheader/history/open');
		}, PageHeader.settings.mouseoverDelay);
	},

	historyMouseout: function(event) {

		//stop the mouseover timer
		clearTimeout(PageHeader.mouseoverTimer);

		//delay before hiding menu
		PageHeader.mouseoutTimer = setTimeout(function() {
			$(event.currentTarget).removeClass("hover");
		}, PageHeader.settings.mouseoutDelay);
	},

	loadAvatars: function() {
		$(".avatar", PageHeader.history).each(function() {
			$(this).attr("src", $(this).attr("data-realUrl"));
		});
	}

};
