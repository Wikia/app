/**
 * JavaScript for SRF namespace placeholder
 * @see http://www.semantic-mediawiki.org/wiki/Writing_result_printers
 *
 * @since 1.8
 * @release 0.2
 *
 * @file
 * @ingroup SRF
 *
 * @licence GNU GPL v2 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 * @author mwjames
 */
window.semanticFormats = new( function() {

	this.log = function( message ) {
		if ( typeof mediaWiki === 'undefined' ) {
			if ( typeof console !== 'undefined' ) {
				console.log( 'SRF: ' + message );
			}
		}
		else {
			return mediaWiki.log.call( mediaWiki.log, 'SRF: ' + message );
		}
	}

	this.msg = function() {
		if ( typeof mediaWiki === 'undefined' ) {
			message = window.wgSRFMessages[arguments[0]];

			for ( var i = arguments.length - 1; i > 0; i-- ) {
				message = message.replace( '$' + i, arguments[i] );
			}

			return message;
		}
		else {
			return mediaWiki.msg.apply( mediaWiki.msg, arguments );
		}
	}
} )();

// Alias
window.srf = window.semanticFormats;