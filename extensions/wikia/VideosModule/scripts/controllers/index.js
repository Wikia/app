/**
 * Controller/entry point for Videos Module
 */
require( [
	'videosmodule.views.bottommodule',
	'videosmodule.models.videos'
], function( BottomModule, VideoData ) {
	'use strict';
	var view;
	// instantiate bottom view
	$( function() {
		view = new BottomModule( {
			el: document.getElementById( 'RelatedPagesModuleWrapper' ),
			model: new VideoData()
		} );
	} );
} );
