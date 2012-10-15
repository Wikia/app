console.log( 'ext.resourceLoaderTests.a' );

$( '#resourceloadertests-load-b' ).click( function() {
	console.log( 'loading... ext.resourceLoaderTests.b' );
	mw.loader.using( 'ext.resourceLoaderTests.b', function() { console.log( 'HELLO!' ); } );
	return false;
} );
