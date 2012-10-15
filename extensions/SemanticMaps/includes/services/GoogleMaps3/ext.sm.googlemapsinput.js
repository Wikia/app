/**
 * JavasSript for the Google Maps v3 form input in the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

jQuery(document).ready(function() {
	if ( true ) { // TODO
		for ( i in window.mwmaps.googlemaps3_forminputs ) {
			if ( window.mwmaps.googlemaps3_forminputs[i].ismulti ) {
				jQuery( '#' + i + '_forminput' ).gmapsmultiinput( i, window.mwmaps.googlemaps3_forminputs[i] );
			}
			else {
				jQuery( '#' + i + '_forminput' ).googlemapsinput( i, window.mwmaps.googlemaps3_forminputs[i] );
			}
		}
	}
	else {
		alert( mediaWiki.msg( 'maps-googlemaps3-incompatbrowser' ) );
		
		for ( i in window.mwmaps.googlemaps3_forminputs ) {
			jQuery( '#' + i + '_forminput' )
				.html( $( '<input />' )
					.attr( { 'name': i, 'value': semanticMaps.buildInputValue( window.mwmaps.googlemaps3_forminputs[i].locations ) } )
				);
		}
	}	
});
