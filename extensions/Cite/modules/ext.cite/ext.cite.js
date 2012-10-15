( function($) {
	$( function() {
		$('.biblio-cite-link,sup.reference a').tooltip({
				bodyHandler: function() {
					return $( '#' + this.hash.substr(1) + ' > .reference-text' )
						.html();
				},
				showURL : false
			} );
	} );
	
} )( jQuery );
