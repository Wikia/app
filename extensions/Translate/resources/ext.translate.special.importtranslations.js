jQuery( function( $ ) {
	// BC for MW < 1.18
	if ( !mw.util.wikiScript ) {
		mw.util.wikiScript = function( str ) {
			return mw.config.get( 'wgScriptPath' ) + '/' + ( str || 'index' ) + mw.config.get( 'wgScriptExtension' );
		}
	}

	$(".mw-translate-import-inputs").change( function() {
		var id = $(this).attr( "id" ).replace( /-input/, "" );
		$( "input[name=upload-type]:checked" ).attr( "checked", false );
		$( "#" + id ).attr( "checked", "checked" );
	} );

	$( "#mw-translate-up-wiki-input" ).autocomplete( {
		source: function( request, response ) {
			var api = mw.util.wikiScript( "api" );
			var data = { action: "opensearch", format: "json", namespace: 6, search: request.term };
			var success = function( res ) {
				response( res[1] );
			};

			$.get( api, data, success );
		}
	} );
} );
