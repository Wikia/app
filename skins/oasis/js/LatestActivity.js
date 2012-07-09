var LatestActivity = {
	init: function() {
		LatestActivity.lazyLoadContent();
	},

	lazyLoadContent: function() {
		$.nirvana.sendRequest({
			controller: 'LatestActivity',
			method: 'Index',
			format: 'html',
			type: 'GET',
			callback: function(html) {
				// IE would lose styling otherwise
				if ($.browser.msie) {
					$("section.WikiaActivityModule:not(.UserProfileRailModule_RecentActivity)").empty().append(html);
				}
				else {
					$('section.WikiaActivityModule:not(.UserProfileRailModule_RecentActivity)').replaceWith(html);
				}
			}
		});
	}
};

$(window).load(function() {
    LatestActivity.init();
});
