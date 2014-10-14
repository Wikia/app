/**
 * Any mobile-specific js for file page goes here.
 * @author Liz Lee
 * @todo once VID-555 is fixed, look into adding tracking for the global usage section
 */

require( [ 'wikia.videoBootstrap', 'wikia.window'], function ( VideoBootstrap, window ) {
	'use strict';

	// Play video
	var filePageContainer = document.getElementById( 'file' );

	if ( filePageContainer && window.playerParams ) {
		new window.VideoBootstrap( filePageContainer, window.playerParams, 'filePage' );
	}
} );
