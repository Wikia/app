/**
* Javascript handler for the save-and-continue button
*
 * @author Stephan Gambke
*/

/*global validateAll */

( function ( $, mw ) {

	'use strict';

	var sacButtons;
	var form;

	function setChanged( event ) {
		sacButtons
			.removeAttr( 'disabled' )
			.addClass( 'sf-save_and_continue-changed' );

		return true;
	}

	/**
	 * Called when the server has sent the preview
	 */
	var resultReceivedHandler = function handleResultReceived( result, textStatus, jqXHR ) {

		// Store the target name
		var target = form.find( 'input[name="target"]' );

		if ( target.length === 0 ) {
			target = $( '<input type="hidden" name="target">' );
			form.append ( target );
		}

		target.attr( 'value', result.target );

		// Store the form name
		target = form.find( 'input[name="form"]' );

		if ( target.length === 0 ) {
			target = $( '<input type="hidden" name="form">' );
			form.append ( target );
		}

		target.attr( 'value', result.form.title );

		sacButtons
		.addClass( 'sf-save_and_continue-ok' )
		.removeClass( 'sf-save_and_continue-wait' )
		.removeClass( 'sf-save_and_continue-error' );

	};

	var resultReceivedErrorHandler = function handleError( jqXHR ){

		var errors = $.parseJSON( jqXHR.responseText ).errors;

		sacButtons
		.addClass( 'sf-save_and_continue-error' )
		.removeClass( 'sf-save_and_continue-wait' );

		// Remove all old error messages and set new ones
		$( '.errorbox' ).remove();


		if ( errors.length > 0 ){
			var i;
			for ( i = 0; i < errors.length; i += 1 ) {
				if ( errors[i].level < 2 ) { // show errors and warnings
					$( '#contentSub' )
					.append( '<div id="form_error_header" class="errorbox" style="font-size: medium"><img src="' + mw.config.get( 'sfgScriptPath' ) + '/skins/MW-Icon-AlertMark.png" />&nbsp;' + errors[i].message + '</div><br clear="both" />' );
				}
			}

			$( 'html, body' ).scrollTop( $( '#contentSub' ).offset().top );
		}
	};

	function collectData( form ) {
		var summaryfield = jQuery( '#wpSummary', form );
		var saveAndContinueSummary = mw.msg( 'sf_formedit_saveandcontinue_summary', mw.msg( 'sf_formedit_saveandcontinueediting' ) );
		var params;

		if ( summaryfield.length > 0 ) {

			var oldsummary = summaryfield.attr( 'value' );

			if ( oldsummary !== '' ) {
				summaryfield.attr( 'value', oldsummary + ' (' + saveAndContinueSummary + ')' );
			} else {
				summaryfield.attr( 'value', saveAndContinueSummary );
			}

			params = form.serialize();

			summaryfield.attr( 'value', oldsummary );
		} else {
			params = form.serialize();
			params += '&wpSummary=' + saveAndContinueSummary;
		}

		if  ( mw.config.get( 'wgAction' ) === 'formedit' ) {
			params += '&target=' + encodeURIComponent( mw.config.get( 'wgPageName' ) );
		} else if ( mw.config.get( 'wgCanonicalSpecialPageName' ) === 'FormEdit' ) {
			var url = mw.config.get( 'wgPageName' );

			var start = url.indexOf( '/' ) + 1; // find start of subpage
			var stop;

			if ( start >= 0 ) {
				stop = url.indexOf( '/', start ); // find end of first subpage
			} else {
				stop = -1;
			}

			if ( stop >= 0 ) {
				params += '&form=' + encodeURIComponent( url.substring( start, stop ) );

				start = stop + 1;
				params += '&target=' + encodeURIComponent( url.substr( start ) );

			} else {
				params += '&form=' + encodeURIComponent( url.substr( start ) );
			}
		}

		params += '&wpMinoredit=1';

		return params;
	}

	function handleSaveAndContinue( event ) {

		event.stopImmediatePropagation();

		// remove old error messages
		var el = document.getElementById( 'form_error_header' );

		if ( el ) {
			el.parentNode.removeChild( el );
		}

		if ( validateAll() ) {
			// disable save and continue button
			sacButtons
			.attr( 'disabled', 'disabled' )
			.addClass( 'sf-save_and_continue-wait' )
			.removeClass( 'sf-save_and_continue-changed' );

			var form = $( '#sfForm' );

			var data = {
				action: 'sfautoedit',
				format: 'json',
				query: collectData( form ) // add form values to the data
			};

			data.query +=  '&wpSave=' + encodeURIComponent( $( event.currentTarget ).attr( 'value' ) );

			$.ajax( {

				type: 'POST', // request type ( GET or POST )
				url: mw.util.wikiScript( 'api' ), // URL to which the request is sent
				data: data, // data to be sent to the server
				dataType: 'json', // type of data expected back from the server
				success: resultReceivedHandler, // function to be called if the request succeeds
				error: resultReceivedErrorHandler // function to be called on error
			} );

		}

		return false;
	}

	if ( mw.config.get( 'wgAction' ) === 'formedit' || mw.config.get( 'wgCanonicalSpecialPageName' ) === 'FormEdit' ) {
		form = $( '#sfForm' );

		sacButtons = $( '.sf-save_and_continue', form );
		sacButtons.click( handleSaveAndContinue );

		$( form )
		.on( 'keyup', 'input,select,textarea', function ( event ) {
			if ( event.which < 32 ){
				return true;
			}

			return setChanged( event );
		} )
		.on( 'change', 'input,select,textarea', setChanged )
		.on( 'click', '.multipleTemplateAdder,.removeButton,.rearrangerImage', setChanged )
		.on( 'mousedown', '.rearrangerImage',setChanged );

	}

}( jQuery, mediaWiki ) );
