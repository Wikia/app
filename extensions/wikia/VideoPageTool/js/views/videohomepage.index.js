/**
 * view for video home page
 */
require( [
		'views.videohomepage.featured',
		'views.videohomepage.search',
        'views.videopagetool.carousel',
        'collections.videopageadmin.category'
], function( FeaturedVideoView, SearchView, CarouselView, CategoriesCollection ) {

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

		// Catagory carousels
		views.videohomepage.categorycarousels = [];

		this.carousels = new CategoriesCollection( Wikia.videoHomePage.categoryData );

		this.carousels.each( function( carouselData ) {
			var carouselView = new CarouselView( {
				model: carouselData // data includes carousel title and list of thumbs
			} );

			// cache carousel view instances
			views.videohomepage.categorycarousels.push( carouselView );
			// append carousel wrapper DOM to home page
			$categoriesContainer.append( carouselView.$el );
		} );
	} );
} );


