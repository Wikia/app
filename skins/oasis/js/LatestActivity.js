var LatestActivity = {
	wikiaRecentActivityContainer: null,
	init: function() {
		if( $('#WikiaRecentActivity').children().length === 0 ) {
			LatestActivity.lazyLoadContent();
		}
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
					$('#WikiaRecentActivity').empty().append($(html).children());
				} else {
					$('#WikiaRecentActivity').replaceWith(html);
				}
			}
		});
	}
};

$(window).load(function() {
	LatestActivity.init();
});
