$(function() {
	PageHeader.init();
});

var PageHeader = {

	settings: {
		mouseoverDelay: 300,
		mouseoutDelay: 350
	},

	init: function() {
		// setup history dropdowm
		PageHeader.history = $("#WikiaPageHeader").find(".history");
		PageHeader.history
			.one("mouseover", PageHeader.lazyLoadHistoryDropdown)
			.hover(PageHeader.historyMouseover, PageHeader.historyMouseout);

		// RT #70400: show .. ago only for edits made 2 weeks ago or later
		PageHeader.setupTimeAgo(PageHeader.history.find("time.timeago"));

		// RT #72155: resize FB like wrapper to match width of an iframe
		if (typeof FB != 'undefined') {
			FB.Event.subscribe('xfbml.render', function() {
				var likeWrapper = $('.commentslikes').children('.likes');

				// allow wrapper to resize
				likeWrapper.css('width', 'auto');
			});
		}
	},

	setupTimeAgo: function(node) {
		node.
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

	lazyLoadHistoryDropdown: function() {
		// RT #74319: lazy load entries in history dropdown
		$.get(wgScript, {
			action: 'ajax',
			rs: 'moduleProxy',
			moduleName: 'HistoryDropdown',
			actionName: 'PreviousEdits',
			outputType: 'html',
			title: wgPageName,
			cb: wgCurRevisionId,
			uselang: wgUserLanguage
		}, function(html) {
			PageHeader.history.find('.view-all').before(html);

			PageHeader.setupTimeAgo(PageHeader.history.find("time.timeago"));
		});

		// lazy load of avatars
		/*
		$(".avatar", PageHeader.history).each(function() {
			$(this).attr("src", $(this).attr("data-realUrl"));
		});
		*/
	}

};
