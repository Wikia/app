( function ($) {
	'use strict';

	function handleClick( val ) {
		$( '.ebs-container' ).hide();
		return $.nirvana.postJson( 'EmergencyBroadcastSystemController', 'saveUserResponse', { val: val } );
	}

	$( '.ebs-primary-action' ).click( function(){
		handleClick( 1 ).then( function() {
			window.location = this.href;
		}.bind( this ) );
		return false;
	} );

	$( '.ebs-secondary-action' ).click( function() {
		handleClick( 0 );
		return false;
	} );
} )( jQuery );
