if ( window.wgStagingEnvironment ) {
	(function( document ){
		'use strict';

		var stagingEnvName = window.location.hostname.split( '.' )[0],
			stagingURLPart = '://' + stagingEnvName + '.',
			links = document.getElementsByTagName('a' ),
			i = 0,
			href;

		for ( ; i < links.length; i++ ) {
			href = links[i].getAttribute('href');

			if ( href && href.indexOf( '://' ) > -1 && href.indexOf( 'wikia.com' ) > -1 &&
				href.indexOf( stagingURLPart ) === -1 ) {
				links[i].setAttribute( 'href', href.replace( '://', stagingURLPart ) );
			}

		}
	})( document );
}
