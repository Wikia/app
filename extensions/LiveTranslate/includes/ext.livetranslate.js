/**
 * JavasSript for the Live Translate extension.
 * @see http://www.mediawiki.org/wiki/Extension:Live_Translate
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

window.liveTranslate = new( function() {
	
	this.debug = function( message ) {
		if ( window.ltDebugMessages ) {
			if ( typeof console === 'undefined' ) {
				document.title = 'Live Translate: ' + message;
			}
			else {
				console.log( 'Live Translate: ' + message );
			}
		}
	};
	
	this.msg = function() {
		if ( typeof mediaWiki === 'undefined' ) {
			message = window.wgLTEMessages[arguments[0]];
			
			for ( var i = arguments.length - 1; i > 0; i-- ) {
				message = message.replace( '$' + i, arguments[i] );
			}
			
			return message;
		}
		else {
			return mediaWiki.msg.apply( this, arguments );
		}
	};
	
} )();

(function( $ ) { $( document ).ready( function() {

	$( '#livetranslatediv' ).liveTranslate( {} );
	
} ); })( jQuery );
