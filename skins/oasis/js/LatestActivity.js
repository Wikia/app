$(window).load(function() {
    LatestActivity.init();
});

var LatestActivity = {
		init: function() {
			LatestActivity.lazyLoadContent();
	},
	
	lazyLoadContent: function() {
		$.get(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=LatestActivity&actionName=Index&outputType=html',
			function(data) {
				// IE would lose styling otherwise
				if ($.browser.msie) {
					$("section.WikiaActivityModule:not(.UserProfileRailModule_RecentActivity)").empty().append(data);
				}
				else {
					$('section.WikiaActivityModule:not(.UserProfileRailModule_RecentActivity)').replaceWith(data);
				}
			
			}
		);
	}
}