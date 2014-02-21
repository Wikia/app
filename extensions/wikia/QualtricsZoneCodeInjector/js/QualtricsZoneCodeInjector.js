(function ( window, document ) {
	'use strict';

	if ( window.wgQualtricsZoneSampling >= ( Math.random() * 100 ) ) {
		var tag = document.createElement( 'script' );

		tag.src = window.wgQualtricsZoneUrl;
		tag.type = 'text/javascript';

		document.body.appendChild( tag );
	}

})( window, document );
