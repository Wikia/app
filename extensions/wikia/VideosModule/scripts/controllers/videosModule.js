/**
 * Controller/entry point for Videos Module
 */
require( [
	'videosmodule.views.bottommodule',
    'videosmodule.models.videos'
], function( BottomModule, VideoData ) {
	'use strict';
console.log( VideoData );
	var view,
		rail = false,
		bottom = true,
		verticalOnly = true;

	if ( bottom ) {
		// instantiate bottom view
		$( function() {
			view = new BottomModule( {
				el: document.getElementById( 'WikiaArticleFooter' ),
				model: new VideoData( { verticalOnly: verticalOnly  } )
			} );
		} );
	} else if ( rail ) {
		// instatiat rail view
	}

} );