require( [
		'views.videohomepage.featured',
		'views.videohomepage.search',
        'views.videohomepage.categories'
], function( FeaturedVideoView, SearchView, CategoriesView ) {

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

		views.videohomepage.categories = [];

		$.each( Wikia.videoHomePage.categoryData, function( index, value ) {
			views.videohomepage.categories.push(
				new CategoriesView( {
					el: '.latest-videos-wrapper',
					thumbnails: value.thumbnails,
					displayTitle: value.displayTitle
				} )
			);
		} );
	} );
} );


