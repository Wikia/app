( function( mw, $ ) { 
	describe( "mw.pubsub", function() { 

		it( "should allow subscription", function() {
			var sub1data = [ 'foo', 'bar' ];
			var result;
			$.subscribe( 'sub1', function( arg ) { 
				result = arg;
			} );
			$.publish( 'sub1', sub1data );
			expect( result ).toBe( sub1data );
		} );

		it( "should allow multiple subscription", function() {
			var sub1data = [ 'foo', 'bar' ];
			var result;
			var result2;
			$.subscribe( 'sub1', function( arg ) { 
				result = arg;
			} );
			$.subscribe( 'sub1', function( arg ) { 
				result2 = arg;
			} );
			$.publish( 'sub1', sub1data );
			expect( result ).toBe( sub1data );
			expect( result2 ).toBe( sub1data );
		} );

		it( "should allow ready subscription with publishing after subscription", function() {
			var sub2data = [ 'quux', 'pif' ];
			var result;
			$.subscribeReady( 'sub2', function( arg ) { 
				result = arg;
			} );
			$.publishReady( 'sub2', sub2data );
			expect( result ).toBe( sub2data );
		} );


		it( "should allow ready subscription with subscription after publishing", function() {
			var sub3data = [ 'paf', 'klortho' ];
			var result;
			$.publishReady( 'sub3', sub3data );
			$.subscribeReady( 'sub3', function( arg ) { 
				result = arg;
			} );
			expect( result ).toBe( sub3data );
		} );

		it( "should not allow a ready event to happen twice", function() {
			var first = [ 'paf' ];
			var second = [ 'glom' ];
			var result;
			$.publishReady( 'sub4', first );
			$.publishReady( 'sub4', second );
			$.subscribeReady( 'sub4', function( arg ) { 
				result = arg;
			} );
			expect( result ).toBe( first );
		} );

		it( "should purge subscriptions", function() {
			var data = [ 'paf' ];
			var result1, result2;
			$.subscribeReady( 'sub5', function( arg ) { 
				result1 = arg;
			} );
			$.purgeSubscriptions();
			$.subscribeReady( 'sub5', function( arg ) { 
				result2 = arg;
			} );
			$.publishReady( 'sub5', data );
			expect( result1 ).not.toBeDefined();
			expect( result2 ).toBe( data );
		} );

		it( "should purge ready events", function() {
			var data1 = [ 'paf' ];
			var data2 = [ 'paf' ];
			$.publishReady( 'sub6', data1 );
			$.purgeReadyEvents();
			$.publishReady( 'sub6', data2 );
			$.subscribeReady( 'sub6', function( arg ) { 
				result = arg;
			} );
			expect( result ).toBe( data2 );
		} );

	} );

} )( mediaWiki, jQuery );
