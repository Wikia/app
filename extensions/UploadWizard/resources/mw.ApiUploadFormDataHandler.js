/**
 * Represents an object which configures an html5 FormData object to upload.
 * Large files are uploaded in chunks.
 * @param an UploadInterface object, which contains a .form property which points to a real HTML form in the DOM
 */
mw.ApiUploadFormDataHandler = function( upload, api ) {
    this.upload = upload;
    this.api = api;

    this.$form = $j( this.upload.ui.form );
    this.formData = {
        action: 'upload',
        stash: 1,
        format: 'json'
    };

    var _this = this;
    this.transport = new mw.FormDataTransport(
        this.$form[0].action,
        this.formData,
		this.upload,
        function( fraction ) { 
            _this.upload.setTransportProgress( fraction ); 
        },
        function( result ) {
            _this.upload.setTransported( result ); 
        }
    );

};

mw.ApiUploadFormDataHandler.prototype = {
    /** 
     * Optain a fresh edit token.
     * If successful, store token and call a callback.
     * @param ok callback on success
     * @param err callback on error
     */
    configureEditToken: function( callerOk, err ) {
        var _this = this;

        var ok = function( token ) { 
            _this.formData.token = token;
            callerOk();
        };

        _this.api.getEditToken( ok, err );
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
            _this.transport.upload();
        };
        var err = function( code, info ) {
            _this.upload.setError( code, info );
        }; 
        this.configureEditToken( ok, err );
    }
};



