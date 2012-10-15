jQuery( function( $ ) {
	if( $( '#t-shorturl' ).length ) {
		var url = $( '#t-shorturl a' ).attr( 'href' );
		/* Add protocol for proto-relative urls */
		var protoNonRelative = ( new mw.Uri( url ) ).toString();
		$( '#firstHeading' ).append( 
			$( '<div class="title-shortlink-container"></div>')
				.append( $( '<a>' )
				.addClass( 'title-shortlink' )
				.attr( 'href', url )
				.text( protoNonRelative )
			)
		);
	}
});
