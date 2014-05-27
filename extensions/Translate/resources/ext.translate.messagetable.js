jQuery( function( $ ) {
	// BC for MW < 1.18
	if ( !mw.util.wikiScript ) {
		mw.util.wikiScript = function( str ) {
			return mw.config.get( 'wgScriptPath' ) + '/' + ( str || 'index' ) + mw.config.get( 'wgScriptExtension' );
		}
	}

	$( ".mw-translate-messagereviewbutton" ).click( function() {
		var $b = $(this);

		var successFunction = function( data, textStatus ) {
			if ( data.error ) {
				var reason = mw.msg( "api-error-" + data.error.code );
				$b.val( mw.msg( "translate-messagereview-failure", reason ) );
			} else {
				$b.val( mw.msg( "translate-messagereview-done" ) );
			}
		};

		var failFunction = function( jqXHR, textStatus ) {
			$b.val( mw.msg( "translate-messagereview-failure", jqXHR.statusText ) );
		};

		var params = {
			action: "translationreview",
			token: $b.data( "token" ),
			revision: $b.data( "revision" ),
			format: "json"
		};
		$b.val( mw.msg( "translate-messagereview-progress" ) );
		// BC for MW < 1.18
		if ( typeof $b.prop === "undefined" ) {
			$b.attr( "disabled", "disabled" );
		} else {
			$b.prop( "disabled", true );
		}
		$.post( mw.util.wikiScript( "api" ), params, successFunction ).fail( failFunction );
	} );
} );
