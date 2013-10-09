require([
		'views.videohomepage.featured',
		'views.videohomepage.search'
	], function( FeaturedVideoView, SearchView ) {

		'use strict';
		// mock a global object in lieu of having one already
		var views = {
			videohomepage: {}
		};

		$(function() {
				views.videohomepage.featured = new FeaturedVideoView();
				views.videohomepage.search = new SearchView();
		});
});
