( function ($) {
	'use strict';

	$( document ).ready( function() {
		function saveUserResponse( val ) {
			$( '.ebs-container' ).hide();
			return $.nirvana.postJson( 'EmergencyBroadcastSystemController', 'saveUserResponse', { val: val } );
		}

		$( '.ebs-primary-action' ).click( function(){
			saveUserResponse( 1 );
		} );

		$( '.ebs-secondary-action' ).click( function() {
			saveUserResponse( 0 );
		} );
	} );
} )( jQuery );
