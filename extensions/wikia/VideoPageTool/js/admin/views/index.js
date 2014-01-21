require( [
	'wikia.querystring',
	'videopageadmin.views.featured',
	'videopageadmin.views.category'
], function( QueryString, FeaturedView, CategoryView ) {
	'use strict';

	var qs = new QueryString(),
		section = qs.getVal( 'section' ),
		view;

	$( function() {
		if ( section === 'category' ) {
			view = new CategoryView( {
				el: '#LatestVideos'
			} );
		} else if ( section === 'featured' ) {
			view = new FeaturedView( {
				el: '.vpt-form'
			} );
		}
	} );
} );