/**
 * Handles dynamic Page Preview for Semantic Forms.
 *
 * @author Stephan Gambke
 */

/*global validateAll */

( function ( $, mw ) {

	'use strict';

	var form;
	var previewpane;
	var previewHeight;

	/**
	 * Called when the content is loaded into the preview pane
	 */
	var loadFrameHandler = function handleLoadFrame() {

		var iframe = $( this );
		var iframecontents = iframe.contents();

		// find div containing the preview
		var content = iframecontents.find( '#wikiPreview' );

		var iframebody = content.closest( 'body' );
		var iframedoc = iframebody.parent();
		iframedoc.height( 'auto' );

		// this is not a normal MW page (or it uses an unknown skin)
		if ( content.length === 0 ) {
			content = iframebody;
		}

		content.parentsUntil( 'html' ).andSelf()
		.css( {
			margin: 0,
			padding: 0,
			width: '100%',
			height: 'auto',
			minWidth: '0px',
			minHeight: '0px',
			'float': 'none', // Cavendish skin uses floating -> unfloat content
			border: 'none',
			background: 'transparent'
		} )
		.siblings()
		.hide(); // FIXME: Some JS scripts don't like working on hidden elements

		// and attach event handler to adjust frame size every time the window
		// size changes
		$( window ).resize( function () {
			iframe.height( iframedoc.height() );
		} );

		previewpane.show();

		var newPreviewHeight = iframedoc.height();

		iframe.height( newPreviewHeight );

		$( 'html, body' )
		.scrollTop( $( 'html, body' ).scrollTop() + newPreviewHeight - previewHeight )
		.animate( {
			scrollTop: previewpane.offset().top
		}, 1000 );

		previewHeight = newPreviewHeight;

		return false;
	};

	/**
	 * Called when the server has sent the preview
	 */
	var resultReceivedHandler = function handleResultReceived( result ) {

		var htm = result.result;

		var iframe = previewpane.children();

		if ( iframe.length === 0 ) {

			// set initial height of preview area
			previewHeight = 0;

			iframe = $( '<iframe>' )
			.css( { //FIXME: Should this go in a style file?
				'width': '100%',
				'height': previewHeight,
				'border': 'none',
				'overflow': 'hidden'
			} )
			.load( loadFrameHandler )
			.appendTo( previewpane );

		}

		var ifr = iframe[0];
		var doc = ifr.contentDocument || ifr.contentWindow.document || ifr.Document;

		doc.open();
		doc.write( htm );
		doc.close();

	};

	/**
	 * Called when the preview button was clicked
	 */
	var previewButtonClickedHandler = function handlePreviewButtonClicked() {

		if ( !validateAll() ) {
			return;
		}

		// data array to be sent to the server
		var data = {
			action: 'sfautoedit',
			format: 'json'
		};

		// do we have a URL like .../index.php?title=pagename&action=formedit ?
		if ( mw.config.get( 'wgAction' ) === 'formedit' ) {

			// set the title, server has to find a suitable form
			data.target = mw.config.get( 'wgPageName' );

			// do we have a URL like .../Special:FormEdit/formname/pagename ?
		} else if ( mw.config.get( 'wgCanonicalNamespace' ) === 'Special' && mw.config.get( 'wgCanonicalSpecialPageName' ) === 'FormEdit' ) {

			// get the pagename and split it into parts
			var pageName = mw.config.get( 'wgPageName' );
			var parts = pageName.split( '/', 3 );

			if ( parts.length > 1 ) { // found a formname
				data.form = parts[1];
			}

			if ( parts.length > 2 ) { // found a pagename
				data.target = parts[2];
			}
		}

		// add form values to the data
		data.query = form.serialize();

		if ( data.query.length > 0 ) {
			data.query += '&';
		}

		data.query += 'wpPreview=' + encodeURIComponent( $( this ).attr( 'value' ) );

		$.ajax( {

			type: 'POST', // request type ( GET or POST )
			url: mw.util.wikiScript( 'api' ), // URL to which the request is sent
			data: data, // data to be sent to the server
			dataType: 'json', // type of data expected back from the server
			success: resultReceivedHandler // function to be called if the request succeeds
		} );
	};

	/**
	 * Register plugin
	 */
	$.fn.sfAjaxPreview = function () {

		form = this.closest( 'form' );
		previewpane = $( '#wikiPreview' );

		// do some sanity checks
		if ( previewpane.length === 0 || // no ajax preview without preview area
			previewpane.contents().length > 0 || // preview only on an empty previewpane
			form.length === 0 ) { // no ajax preview without form

			return this;
		}

		// IE does not allow setting of the 'type' attribute for inputs
		// => completely replace the original preview button
		var btn = $( '<input type=\'button\' />' ).insertBefore( this );

		this.remove();

		// copy all explicitly specified attributes (except 'type' attribute)
		// from the old to the new button
		var oldBtnElement = this[0];
		var i;

		for ( i = 0; i < oldBtnElement.attributes.length; i = i + 1 ) {
			var attribute = oldBtnElement.attributes[i];
			if ( attribute.name !== 'type' ) {
				btn.attr( attribute.name,  attribute.value );
			}
		}

		// register event handler
		btn.click( previewButtonClickedHandler );

		return btn;
	};

	$( document ).ready( function () {
		if ( mw.config.get( 'wgAction' ) === 'formedit' ||
			mw.config.get( 'wgCanonicalSpecialPageName' ) === 'FormEdit' ) {
			$( '#wpPreview' ).sfAjaxPreview();
		}
	} );

}( jQuery, mediaWiki ) );
