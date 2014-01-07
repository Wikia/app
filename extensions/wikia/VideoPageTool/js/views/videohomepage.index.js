require( [
		'views.videohomepage.featured',
		'views.videohomepage.search',
        'views.videopagetool.carousel'
], function( FeaturedVideoView, SearchView, CarouselView ) {

	'use strict';
	// mock a global object in lieu of having one already
	var views = {
		videohomepage: {}
	};

	$( function() {
		views.videohomepage.featured = new FeaturedVideoView( {
			el: '#featured-video-slider',
			$bxSlider: $( '#featured-video-bxslider' ),
			$thumbs: $( '#featured-video-thumbs' )
		} );

		views.videohomepage.search = new SearchView();

		views.videohomepage.categorycarousels = [];

		$.each( Wikia.videoHomePage.categoryData, function( index, value ) {
			views.videohomepage.categorycarousels.push(
				new CarouselView( {
					thumbnails: value.thumbnails,
					displayTitle: value.displayTitle
				} )
			);
		} );
	} );
} );


