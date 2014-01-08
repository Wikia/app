require( [
		'views.videohomepage.featured',
		'views.videohomepage.search',
        'views.videopagetool.carousel'
], function( FeaturedVideoView, SearchView, CarouselView ) {

	'use strict';
	// mock a global object in lieu of having one already
	var views = {
			videohomepage: {}
		},
		$categoriesContainer = $( '.latest-videos-wrapper' );

	$( function() {
		views.videohomepage.featured = new FeaturedVideoView( {
			el: '#featured-video-slider',
			$bxSlider: $( '#featured-video-bxslider' ),
			$thumbs: $( '#featured-video-thumbs' )
		} );

		views.videohomepage.search = new SearchView();

		views.videohomepage.categorycarousels = [];

		_.each( Wikia.videoHomePage.categoryData, function( value ) {
			var view = new CarouselView( {
				thumbnails: value.thumbnails,
				displayTitle: value.displayTitle
			} );

			views.videohomepage.categorycarousels.push( view );
			$categoriesContainer.append( view.$el );
		} );
	} );
} );


