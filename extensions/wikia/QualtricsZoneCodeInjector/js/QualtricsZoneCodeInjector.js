(function ( window, document ) {
	'use strict';

	if ( window.wgQualtricsZoneSampling >= Math.floor( (Math.random() * 1000 + 1) ) ) {
		var tag = document.createElement( 'script' );

		tag.src = window.wgQualtricsZoneUrl;
		tag.type = 'text/javascript';

		document.body.appendChild( tag );
	}

})( window, document );
