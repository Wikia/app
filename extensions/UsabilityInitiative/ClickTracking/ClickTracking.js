(function($) {
	if( !wgClickTrackingIsThrottled ) {
		// creates 'track action' function to call the clicktracking API and send the ID
		$.trackAction = function ( id ) {
			$j.post( wgScriptPath + '/api.php', { 'action': 'clicktracking', 'eventid': id, 'token': wgTrackingToken } );
		};
		
		// Clicktrack the left sidebar links
		$j(document).ready( function() {
			$( '#p-logo a, #p-navigation a, #p-tb a' ).click( function() {
				var id = 'leftnav-' + skin + '-' +
					( $(this).attr( 'id' ) || $(this).parent().attr( 'id' ) );
				var href = $(this).attr( 'href' );
				// Don't attach to javascript: URLs and the like,
				// only to local URLs (start with a /), http:// ,
				// https:// and same-protocol URLs (start with //)
				if ( href[0] == '/' || href.match( /^https?:\/\// ) )
					window.location =  wgScriptPath +
						'/api.php?action=clicktracking&eventid=' +
						id + '&token=' + wgTrackingToken +
						'&redirectto=' + escape( href );
			});
		});
	}

})(jQuery);
