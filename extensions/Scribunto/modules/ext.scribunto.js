( function ( $, mw ) {

	mw.scribunto = {
		errors: null,

		'setErrors': function ( errors ) {
			this.errors = errors;
		},

		'init': function () {
			var regex = /^mw-scribunto-error-(\d+)/,
				that = this;

			$( '.scribunto-error' ).each( function ( index, span ) {
				var matches = regex.exec( span.id );
				if ( matches === null ) {
					console.log( "mw.scribunto.init: regex mismatch!" );
					return;
				}
				var errorId = parseInt( matches[1] );
				$( span )
					.css( 'cursor', 'pointer' )
					.bind( 'click', function () {
						if ( typeof that.errors[ errorId ] !== 'string' ) {
							console.log( "mw.scribunto.init: error " + matches[1] + " not found, " +
								"mw.loader.using() callback may not have been called yet." );
							return;
						}
						var error = that.errors[ errorId ];
						// Wikia change begin - use our own modal to display errors as it works in both skins (CE-889)
						require( [ 'wikia.ui.factory' ], function( uiFactory ) {
							uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
								var scribuntoErrorConfig = {
									vars: {
										id: 'ScribuntoErrorModal',
										size: 'small',
										content: error,
										title: mw.message( 'scribunto-parser-dialog-title' ).escaped(),
									}
								};

								uiModal.createComponent( scribuntoErrorConfig, function( scribuntoErrorModal ) {
									scribuntoErrorModal.show();
								} );
							} );
						} );
						// Wikia change - end
					} );
			} );
		}
	};

	$( document ).ready( function () {
		mw.scribunto.init();
	} );

} ) ( jQuery, mediaWiki );

