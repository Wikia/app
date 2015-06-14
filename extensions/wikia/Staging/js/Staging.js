if ( window.wgStagingEnvironment ) {
	(function( document ){
		'use strict';

		var stagingEnvName = window.location.hostname.split( '.' )[0],
			stagingURLPart = '://' + stagingEnvName + '.',
			links = document.getElementsByTagName('a' ),
			i = 0,
			//match all occurrences of wikia.com between :// and /
			//use case: links in share icons have wikia.com but as URL parameter not domain name
			pattern=/^\w*:?\/\/[^\/]*wikia\.com/gi,
			href;

		for ( ; i < links.length; i++ ) {
			href = links[i].getAttribute('href');

			if ( href && href.indexOf( stagingURLPart ) === -1 && pattern.test(href)) {
				links[i].setAttribute( 'href', href.replace( '://', stagingURLPart ) );
			}

		}
	})( document );
}
