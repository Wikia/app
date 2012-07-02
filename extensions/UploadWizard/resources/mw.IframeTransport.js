/**
 * Represents a "transport" for files to upload; in this case an iframe.
 * XXX dubious whether this is really separated from "ApiUploadHandler", which does a lot of form config.
 *
 * The iframe is made to be the target of a form so that the existing page does not reload, even though it's a POST.
 * @param form	jQuery selector for HTML form
 * @param progressCb	callback to execute when we've started. (does not do float here because iframes can't 
 *			  monitor fractional progress).
 * @param transportedCb	callback to execute when we've finished the upload
 */
mw.IframeTransport = function( $form, progressCb, transportedCb ) {
	this.$form = $form;
	this.progressCb = progressCb;
	this.transportedCb = transportedCb;

	this.iframeId = 'f_' + ( $j( 'iframe' ).length + 1 );
	
	//IE only works if you "create element with the name" ( not jquery style )
	var iframe;
	try {
		iframe = document.createElement( '<iframe name="' + this.iframeId + '">' );
	} catch ( ex ) {
		iframe = document.createElement( 'iframe' );
	}
	this.$iframe = $j( iframe );		

	// we configure form on load, because the first time it loads, it's blank
	// then we configure it to deal with an API submission	
	var _this = this;
	this.$iframe.attr( { 'src'   : 'javascript:false;', 
		             'id'    : this.iframeId,
		             'name'  : this.iframeId } )
		    .load( function() { _this.configureForm(); } )
		    .css( 'display', 'none' );

	$j( "body" ).append( iframe ); 
};

mw.IframeTransport.prototype = {
	/**
	 * Configure a form with a File Input so that it submits to the iframe
	 * Ensure callback on completion of upload
	 */
	configureForm: function() {
		// Set the form target to the iframe
		this.$form.attr( 'target', this.iframeId );

		// attach an additional handler to the form, so, when submitted, it starts showing the progress
		// XXX this is lame .. there should be a generic way to indicate busy status...
		this.$form.submit( function() { 
			// mw.log( "mw.IframeTransport::configureForm> submitting to iframe...", "debug" );
			return true;
		} );

		// Set up the completion callback
		var _this = this;
		$j( '#' + this.iframeId ).load( function() {
			// mw.log( "mw.IframeTransport::configureForm> received result in iframe", "debug" );
			_this.progressCb( 1.0 );
			_this.processIframeResult( $j( this ).get( 0 ) );
		} );			
	},

	/**
	 * Process the result of the form submission, returned to an iframe.
	 * This is the iframe's onload event.
	 *
	 * @param {Element} iframe iframe to extract result from 
	 */
	processIframeResult: function( iframe ) {
		var _this = this;
		var doc = iframe.contentDocument ? iframe.contentDocument : frames[iframe.id].document;
		// Fix for Opera 9.26
		if ( doc.readyState && doc.readyState != 'complete' ) {
			//mw.log( "mw.IframeTransport::processIframeResult>  not complete" );
			return;
		}
			
		// Fix for Opera 9.64
		if ( doc.body && doc.body.innerHTML == "false" ) {
			//mw.log( "mw.IframeTransport::processIframeResult> innerhtml" );
			return;
		}
		var response;
		if ( doc.XMLDocument ) {
			// The response is a document property in IE
			response = doc.XMLDocument;
		} else if ( doc.body ) {
			// Get the json string
			// We're actually searching through an HTML doc here -- 
			// according to mdale we need to do this
			// because IE does not load JSON properly in an iframe			
			json = $j( doc.body ).find( 'pre' ).text();
			// mw.log( "mw.IframeTransport::processIframeResult> iframe:json::" + json );
			// check that the JSON is not an XML error message 
			// (this happens when user aborts upload, we get the API docs in XML wrapped in HTML)
			if ( json && json.substring(0, 5) !== '<?xml' ) {
				response = window["eval"]( "( " + json + " )" );
			} else {
				response = {};
			}
		} else {
			// Response is a xml document
			response = doc;
		}
		// Process the API result
		_this.transportedCb( response );
	}
};


