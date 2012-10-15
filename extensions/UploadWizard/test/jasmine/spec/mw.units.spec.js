( function( mw ) {

	// matches the current system
	mediaWiki.messages.set( {
		"size-bytes": "$1 B",
		"size-kilobytes": "$1 KB",
		"size-megabytes": "$1 MB",
		"size-gigabytes": "$1 GB"
	} );

	window.gM = mw.language.getMessageFunction();

	// assumes english language selected
	describe( "mw.units.bytes", function() {
		it( "should say 0 B", function() { 
			expect( mw.units.bytes( 0 ) ).toEqual( '0 B' );
		} );

		it( "should say B", function() { 
			expect( mw.units.bytes( 7 ) ).toEqual( '7 B' );
		} );

		it( "should say B (900)", function() { 
			expect( mw.units.bytes( 900 ) ).toEqual( '900 B' );
		} );

		it( "should say 1023 = 1023 bytes", function() { 
			expect( mw.units.bytes( 1023 ) ).toEqual( '1023 B' );
		} );

		it( "should say 1024 = 1 KB", function() { 
			expect( mw.units.bytes( 1024 ) ).toEqual( '1 KB' );
		} );

		it( "should say MB", function() { 
			expect( mw.units.bytes( 2 * 1024 * 1024 ) ).toEqual( '2.00 MB' );
		} );

		it( "should say GB", function() { 
			expect( mw.units.bytes( 3.141592 * 1024 * 1024 * 1024 ) ).toEqual( '3.14 GB' );
		} );

		it( "should say GB even when much larger", function() { 
			expect( mw.units.bytes( 3.141592 * 1024 * 1024 * 1024 * 1024 ) ).toEqual( '3216.99 GB' );
		} );

		it( "should round up", function() { 
			expect( mw.units.bytes( 1.42857 * 1024 * 1024 * 1024 ) ).toEqual( '1.43 GB' );
		} );


	} );

} )( mediaWiki );

