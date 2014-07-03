if ( window.wgStagingEnvironment ) {
	(function(){
		'use strict';

		var stagingEnvName = window.location.hostname.split( '.' )[0];

		$('a').each(function() {
			var $this = $( this ),
				href = $this.attr( 'href' );

			if ( href.indexOf( '://' ) > -1 && href.indexOf( stagingEnvName ) === -1 ) {
				$this.attr( 'href', href.replace( '://', '://' + stagingEnvName + '.' ) );
			}
		});
	})();
}
