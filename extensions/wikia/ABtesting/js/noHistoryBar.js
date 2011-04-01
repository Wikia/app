(function() {
	if ($("#WikiaPageHeader details .view-all").exists()) {
	
		var header = $("#WikiaPageHeader");
		
		if (!header.children(".wikia-menu-button").exists()) {
			// Make menu button
			header.find(".wikia-button:first")
				.removeClass("wikia-button")
				.wrap('<ul class="wikia-menu-button"><li></li></ul>')
				.closest(".wikia-menu-button")
					.find("li").append('<img src="' + wgBlankImgUrl + '" class="chevron"><ul></ul>');
		}	
			
		// Append history.
		$("#WikiaPageHeader details .view-all").prependTo("#WikiaPageHeader > .wikia-menu-button ul").click(trackHistory);
		
	}
	
	var trackHistory = function() {
		$.tracker.byStr('action/history');
	}
})();