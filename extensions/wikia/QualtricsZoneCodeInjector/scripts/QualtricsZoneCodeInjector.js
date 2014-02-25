( function ( window ) {
	'use strict';
	if ( window.wgQualtricsZoneSampling >= ( Math.random() * 100 ) ) {
		require( ['jquery'], function( $ ) {
			$( function() {
				$.getScript( window.wgQualtricsZoneUrl );
			} );

		} );
	}

})( window );

