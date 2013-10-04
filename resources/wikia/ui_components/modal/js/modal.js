define( 'wikia.ui.modal', [ 'jquery', 'wikia.window' ], function( $, w ) {
	"use strict";

	function Modal() {

		if( !( this instanceof Modal ) ) {
			return new Modal;
		}
	}

	/** Public API */
	return Modal;
});
