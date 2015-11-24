( function ($) {
	'use strict';

	function saveUserResponse( val ) {
		$( '.ebs-container' ).hide();
		return $.nirvana.postJson( 'EmergencyBroadcastSystemController', 'saveUserResponse', { val: val } );
	}

	$( '.ebs-primary-action' ).click( function(){
		saveUserResponse( 1 ).then( function() {
			window.location = this.href;
		}.bind( this ) );
		return false;
	} );

	$( '.ebs-secondary-action' ).click( function() {
		saveUserResponse( 0 );
	} );
} )( jQuery );
