/**
 * Preview page script
 */
(function( $, mw ) {
	"use strict";

	var showPreview = function () {
		var font = $( 'select#webfonts-font-chooser' ).val();
		if ( font === null ) {
			return true;
		}
		
		var $downloadLink = $( 'a#webfonts-preview-download' );
		var $previewBox = $( 'div#webfonts-preview-area' );
		mw.webfonts.addFont( font );
		$previewBox.css( 'font-family', font ).addClass( 'webfonts-lang-attr' );
		$previewBox.css( 'font-size', parseInt( $( 'select#webfonts-size-chooser' ).val(), 10 ) );
		var fontconfig = mw.webfonts.config.fonts[font];
		var base = mw.config.get( 'wgExtensionAssetsPath' ) + '/WebFonts/fonts/';
		$downloadLink.prop( 'href', base + fontconfig.ttf ).removeClass( 'disabled' );
		return true;
	};
	
	var getFontsForLang = function ( language ) {
		var $fontChooser = $( 'select#webfonts-font-chooser' );
		var $downloadLink = $( 'a#webfonts-preview-download' );
		$fontChooser.empty();
		var languages = mw.webfonts.config.languages;
		var fonts = languages[language];
		if( !fonts ) {
			$downloadLink.removeAttr( 'href' ).addClass( 'disabled' );
			return false;
		}
		$.each( fonts, function( key, value ) {   
			$fontChooser.append( $( '<option>', { value: value } )
				.text( value ) ); 
		} );
		showPreview();
		return true;
	};
	
	$( document ).ready( function () {
		$( 'select#wpUserLanguage' ).change( function () {
			var language = $( 'select#wpUserLanguage' ).val();
			getFontsForLang( language );
		} );

		$( 'select#webfonts-font-chooser, select#webfonts-size-chooser' ).change( function () {
			showPreview();
		} );

		$( 'button#webfonts-preview-bold' ).click( function () {
			document.execCommand( 'bold', false, null );
		} );
		
		$( 'button#webfonts-preview-italic' ).click( function () {
			document.execCommand( 'italic', false, null );
		} );

		$( 'button#webfonts-preview-underline' ).click( function () {
			document.execCommand( 'underline', false, null );
		} );

		getFontsForLang( $( 'select#wpUserLanguage' ).val() );
		showPreview();
	} );
	
} )( jQuery, mediaWiki );
