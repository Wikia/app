/**
 * view for video home page
 */
require( [
		'views.videohomepage.featured',
		'views.videohomepage.search',
        'views.videohomepage.carousels'
], function( FeaturedVideoView, SearchView, CarouselsView ) {

	'use strict';

	// mock a global object in lieu of having one already
	var views = {
		videohomepage: {}
	};

	function init() {
		views.videohomepage.search = new SearchView();

		views.videohomepage.featured = new FeaturedVideoView( {
			el: '#featured-video-slider',
			$bxSlider: $( '#featured-video-bxslider' ),
			$thumbs: $( '#featured-video-thumbs' )
		} );

		views.videohomepage.categories = new CarouselsView( {
			el: '#latest-videos-wrapper'
		} );
	}

	$( init );

} );


