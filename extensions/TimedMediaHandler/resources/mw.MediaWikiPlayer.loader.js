( function( mw, $ ) {
	// Add MediaWikiSupportPlayer dependency on players with a mediaWiki title 
	$( mw ).bind( 'EmbedPlayerUpdateDependencies', function( event, embedPlayer, dependencySet ){
		if( $( embedPlayer ).attr( 'data-mwtitle' ) ){
			$.merge( dependencySet, ['mw.MediaWikiPlayerSupport'] );
		}
	});
} )( window.mediaWiki, jQuery );