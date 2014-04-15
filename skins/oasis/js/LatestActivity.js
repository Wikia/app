var LatestActivity = {
	wikiaRecentActivityContainer: null,
	init: function() {
		this.wikiaRecentActivityContainer = $('#WikiaRecentActivity');
		if( this.wikiaRecentActivityContainer.exists() ) {
			this.lazyLoadContent();
		}
	},

	lazyLoadContent: function() {
		$.nirvana.sendRequest({
			controller: 'LatestActivity',
			method: 'Index',
			format: 'html',
			type: 'GET',
			callback: $.proxy(function(html) {
				// IE would lose styling otherwise
				if ($.browser.msie) {
					this.wikiaRecentActivityContainer.empty().append($(html).children());
				} else {
					this.wikiaRecentActivityContainer.replaceWith(html);
				}
			}, this)
		});
	}
};

$(window).load(function() {
	$('.WikiaRail').on('afterLoad.rail', function() {
		LatestActivity.init();
	});
});

