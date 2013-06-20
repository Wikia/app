/**
 * This is the generic callback for ajax requests made by LVS
 */
define( 'lvs.containerdom', [], function() {
	"use strict";

	return function( $container, data ) {
		if( data.result == 'error' ) {
			window.GlobalNotification.show( data.msg, 'error' );
		} else {
			window.GlobalNotification.show( data.msg, 'confirm' );
			// update page html (this also gets rid of loading overlay)
			$container.html( data.html );
		}
	};
});