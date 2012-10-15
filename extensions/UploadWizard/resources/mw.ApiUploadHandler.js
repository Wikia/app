/**
 * An attempt to refactor out the stuff that does API-via-iframe transport
 * In the hopes that this will eventually work for AddMediaWizard too
 */

// n.b. if there are message strings, or any assumption about HTML structure of the form.
// then we probably did it wrong

/**
 * Represents an object which configures a form to upload its files via an iframe talking to the MediaWiki API.
 * @param an UploadInterface object, which contains a .form property which points to a real HTML form in the DOM
 */
mw.ApiUploadHandler = function( upload, api ) {
	this.upload = upload;
	this.api = api;
	this.$form = $j( this.upload.ui.form );
	this.configureForm();

	// the Iframe transport is hardcoded for now because it works everywhere
	// can also use Xhr Binary depending on browser
	var _this = this;
	this.transport = new mw.IframeTransport(
		this.$form,
		function( fraction ) { 
			_this.upload.setTransportProgress( fraction ); 
		},
		function( result ) { 	
			_this.upload.setTransported( result ); 
		}
	);

};

mw.ApiUploadHandler.prototype = {
	/**
	 * Configure an HTML form so that it will submit its files to our transport (an iframe)
	 * with proper params for the API
	 * @param callback
	 */
	configureForm: function() {
		var _this = this;

		_this.addFormInputIfMissing( 'action', 'upload' );

		// force stash
		_this.addFormInputIfMissing( 'stash', 1 );

		// XXX TODO - remove; if we are uploading to stash only, a comment should not be required - yet.
		_this.addFormInputIfMissing( 'comment', 'DUMMY TEXT' );
		
		// we use JSON in HTML because according to mdale, some browsers cannot handle just JSON
		_this.addFormInputIfMissing( 'format', 'jsonfm' );
	},

	/** 
	 * Modify our form to have a fresh edit token.
	 * If successful, return true to a callback.
	 * @param callback to return true on success
	 */
	configureEditToken: function( callerOk, err ) {
		var _this = this;

		var ok = function( token ) { 
			_this.addFormInputIfMissing( 'token', token );
			callerOk();
		};

		_this.api.getEditToken( ok, err );
	},

	/**
	 * Add a hidden input to a form  if it was not already there.
	 * @param name  the name of the input
	 * @param value the value of the input
	 */
	addFormInputIfMissing: function( name, value ) {
		if ( this.$form.find( "[name='" + name + "']" ).length === 0 ) {
			this.$form.append( $j( '<input type="hidden" />' ) .attr( { 'name': name, 'value': value } ));
		}		
	},

	/**
	 * Kick off the upload!
	 */
	start: function() {
		var _this = this;
		var ok = function() {
			_this.beginTime = ( new Date() ).getTime();
			_this.upload.ui.setStatus( 'mwe-upwiz-transport-started' );
			_this.upload.ui.showTransportProgress();
			_this.$form.submit();
		};
		var err = function( code, info ) {
			_this.upload.setError( code, info );
		}; 
		this.configureEditToken( ok, err );
	}
};



