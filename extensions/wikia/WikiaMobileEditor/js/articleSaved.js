document.addEventListener( 'DOMContentLoaded', function () {
	'use strict';

	require( [ 'toast', 'JSMessages' ], function ( toast, msg ) {
		toast.show( msg( 'wikiamobileeditor-on-success' ) );
	} );
} );
