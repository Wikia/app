// this is a bit problematic -- we are using a "real" MediaWiki server rather than mocking it out.
// jasmine has spies and such for mocking.
// also, how are we going to configure this test? Perhaps we'll need to have a special SpecRunner text input for API url, etc.

( function( mw, $j ) {

	$j.mockjaxSettings = {
		responseTime: 0,  // as fast as possible, for tests
		dataType: 'json'
	};

	describe( 'mw.Api', function() {

		var MAX_DELAY = 1000; // ms

		// typical globals made available
		// TODO this only works for me (NeilK)
		mw.config.set( 'wgScriptPath', '/w' );

		var pageUri = new mw.Uri( window.location );

		var apiUrl = new mw.Uri( { 
			protocol: pageUri.protocol, 
			host: pageUri.host, 
			path: mw.config.get( 'wgScriptPath' ) + '/api.php' 
		} );

		describe( "edit token", function() { 

			var deleteToken;
			var deleteTokenGetter = function( t ) {
				deleteToken = t;
			};


			it( "should fetch a token with simple callback", function() { 
				var api = new mw.Api( { url: apiUrl } );
				var token = undefined;
				var completion = false;
				runs( function() {
					api.getEditToken( 
						function( t ) {
							token = t;
							completion = true;
						},
						function() {
							completion = true;
						}
					);
				} );
				waitsFor( function() { return completion; }, "AJAX call completion", MAX_DELAY );
				runs( function() { 
					expect( token ).toBeDefined();
					expect( token ).toContain( '+\\' );
				} );
			} );



			it( "should deal with network timeout", function() {
				var token = undefined;
				var completion = false;
				var timedOut = false;

				runs( function() { 

					var ok = function( t ) {
						token = t;
						completion = true;
					};

					var err = function( code, info ) { 
						completion = true;
						if ( code == 'http' && info.textStatus == 'timeout' ) {
							timedOut = true;
						} else {
							console.log( "unexpected error that wasn't a timeout" );
						}
					};

					this.mock = $j.mockjax( { 
						// match every url 
						url: '*', 
						// with a timeout
						isTimeout: true
					} );
					
					var api = new mw.Api( { url: apiUrl } ); 
					api.getEditToken( ok, err );
				} );

				waitsFor( function() { return completion || timedOut; }, "mockjax call completion or timeout", MAX_DELAY );

				runs( function() {
					expect( timedOut ).toBe( true );
					$j.mockjaxClear( this.mock );
				} );

			} );
		

			it( "should deal with server error", function() {
				var token = undefined;
				var completion = false;
				var serverError = false;

				runs( function() { 

					var ok = function( t ) {
						token = t;
						completion = true;
					};

					var err = function( code, info ) { 
						completion = true;
						if ( code == 'http' && info && info.xhr && info.xhr.status == '500' ) {
							serverError = true;
						} else {
							console.log( "unexpected error that wasn't a server error" );
						}
					};

					this.mock = $j.mockjax( { 
						// match every url 
						url: '*', 
						// with a server error
						status: '500'
					} );
					
					var api = new mw.Api( { url: apiUrl } ); 
					api.getEditToken( ok, err );
				} );

				// the mock should time out instantly, but in practice, some delay seems necessary ?
				waitsFor( function() { return completion; }, "mockjax call completion", MAX_DELAY );

				runs( function() {
					expect( serverError ).toBe( true );
					$j.mockjaxClear( this.mock );
				} );

			} );

	/*
			it ( "should be able to create a page with an edit token", function() {
				var titles = [ 'Foo' ];
				api.getPageEditToken( titles, tokenGetter );
				api.editPage( titles );
				api.getDeleteToken( deleteTokenGetter ); 
			} );
	*/

		} );

	} );
} )( mediaWiki, jQuery );

