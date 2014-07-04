if ( window.wgStagingEnvironment ) {
	(function(){
		'use strict';

		var stagingEnvName = window.location.hostname.split( '.' )[0],
			stagingURLPart = '://' + stagingEnvName + '.';

		$('a').each(function() {
			var $this = $( this ),
				href = $this.attr( 'href' );

			if ( href.indexOf( '://' ) > -1 && href.indexOf( 'wikia.com' ) > -1 && href.indexOf( stagingURLPart ) === -1 ) {
				$this.attr( 'href', href.replace( '://', stagingURLPart ) );
			}
		});
	})();
}
