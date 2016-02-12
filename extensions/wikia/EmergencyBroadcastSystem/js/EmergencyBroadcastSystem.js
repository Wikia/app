( function ($) {
	'use strict';

	$( document ).ready( function() {
		function saveUserResponse( val ) {
			var data = {
				val: val,
				token: mw.user.tokens.get('editToken')
			};

			$( '.ebs-container' ).hide();
			return $.nirvana.postJson( 'EmergencyBroadcastSystemController', 'saveUserResponse', data );
		}

		$( '.ebs-primary-action' ).click( function(){
			saveUserResponse( 1 );
		} );

		$( '.ebs-secondary-action' ).click( function() {
			saveUserResponse( 0 );
		} );
	} );
} )( jQuery );
