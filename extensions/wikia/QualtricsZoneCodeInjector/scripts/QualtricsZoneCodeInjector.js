(function ( window ) {
	'use strict';

	if ( window.wgQualtricsZoneSampling >= ( Math.random() * 100 ) ) {
		require( ['jquery'], function( $ ) {
			$( function() {
				$('<script type="text/javascript" />')
					.attr('src', window.wgQualtricsZoneUrl)
					.appendTo('body');
			} );
		} );
	}
})( window );

