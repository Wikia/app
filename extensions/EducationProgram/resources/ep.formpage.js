/**
 * JavasSript for the Education Program MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Education_Program
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) { 

	$( document ).ready( function() {
		
		$( '#bodyContent' ).find( '[type="submit"]' ).button();
		
		$( '#cancelEdit' ).click( function( event ) {
			window.location = $( this ).attr( 'target-url' );
			event.preventDefault();
		} );

		//$( 'textarea.wiki-editor-input' ).attr( 'class', 'wiki-editor' ).wikiEditor( 'addModule', $.wikiEditor.modules.toolbar.config.getDefaultConfig() );

	} );
	
})( window.jQuery, window.mediaWiki );