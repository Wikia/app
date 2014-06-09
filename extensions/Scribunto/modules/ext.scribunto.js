( function ( $, mw ) {

	mw.scribunto = {
		errors: null,

		'setErrors': function ( errors ) {
			this.errors = errors;
		},

		'init': function () {
			var regex = /^mw-scribunto-error-(\d+)/,
				that = this,
				dialog = $( '<div>' );

			dialog.dialog( {
				title: mw.msg( 'scribunto-parser-dialog-title' ),
				autoOpen: false
			} );

			$( '.scribunto-error' ).each( function ( index, span ) {
				var matches = regex.exec( span.id );
				if ( matches === null ) {
					console.log( "mw.scribunto.init: regex mismatch!" );
					return;
				}
				var errorId = parseInt( matches[1] );
				$( span )
					.css( 'cursor', 'pointer' )
					.bind( 'click', function ( evt ) {
						if ( typeof that.errors[ errorId ] !== 'string' ) {
							console.log( "mw.scribunto.init: error " + matches[1] + " not found, " +
								"mw.loader.using() callback may not have been called yet." );
							return;
						}
						var error = that.errors[ errorId ];
						dialog
							.dialog( 'close' )
							.html( error )
							.dialog( 'option', 'position', [ evt.clientX + 5, evt.clientY + 5 ] )
							.dialog( 'open' );
					} );
			} );
		}
	};

	$( document ).ready( function () {
		mw.scribunto.init();
	} );

} ) ( jQuery, mediaWiki );

