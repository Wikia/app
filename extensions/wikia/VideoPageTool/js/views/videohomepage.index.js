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
				views.videohomepage.featured = new FeaturedVideoView({
						el: '#featured-video-slider',
						$bxSlider: $( '#featured-video-bxslider' ),
						$thumbs: $( '#featured-video-thumbs' )
				});
				views.videohomepage.search = new SearchView();
		});
});
