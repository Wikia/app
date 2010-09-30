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
		$("abbr.timeago").timeago();
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