/**
 * JavasSript for the Yahoo! Maps form input in the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

jQuery(document).ready(function() {
	if ( true ) {
		for ( i in window.mwmaps.yahoomaps_forminputs ) {
			jQuery( '#' + i + '_forminput' ).yahoomapsinput( i, window.mwmaps.yahoomaps_forminputs[i] );
		}
	}
	else {
		alert( mediaWiki.msg( 'maps-yahoomaps-incompatbrowser' ) );
		
		for ( i in window.mwmaps.yahoomaps_forminputs ) {
			jQuery( '#' + i + '_forminput' ).text( mediaWiki.msg( 'maps-load-failed' ) );
		}
	}	
});
