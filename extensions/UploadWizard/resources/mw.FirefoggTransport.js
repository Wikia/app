/**
 * Represents a "transport" for files to upload; in this case an firefogg.
 *
 * @param upload UploadInterface
 * @param api
 * @param fogg Firefogg instance
 * @param progressCb	callback to execute as the upload progresses 
 * @param transportedCb	callback to execute when we've finished the upload
 */
mw.FirefoggTransport = function( upload, api, fogg, progressCb, transportedCb ) {
	this.upload = upload;
	this.api = api;
	this.fogg = fogg;
	this.progressCb = progressCb;
	this.transportedCb = transportedCb;
};

mw.FirefoggTransport.prototype = {

	/**
	 * Do an upload
	 */
	doUpload: function() {
		var _this = this;
		//Encode or passthrough Firefogg before upload
		if (this.isUploadFormat()) {
			_this.doFormDataUpload(this.upload.ui.$fileInputCtrl[0].files[0]);
		} else {
			this.fogg.encode( JSON.stringify( this.getEncodeSettings() ),
				function(result, file) {
					result = JSON.parse(result);
					if(result.progress == 1) { //encoding done
						_this.doFormDataUpload(file);
					} else { //encoding failed
						var response = {
							error: {
								code: 500,
								info: 'Encoding failed'
							}
						};
						_this.transportedCb(response);
					}
				}, function(progress) { //progress
					progress = JSON.parse(progress);
					_this.progressCb( progress );
				}
			);
		}
	},
	doFormDataUpload: function(file) {
		this.upload.file = file;
		this.uploadHandler = new mw.ApiUploadFormDataHandler( this.upload, this.api );
		this.uploadHandler.start();
	},
	/**
	 * Check if the asset is in a format that can be upload without encoding.
	 */
	isUploadFormat: function(){
		// Check if the server supports webm uploads: 
		var wembExt = ( $j.inArray( 'webm', mw.UploadWizard.config[ 'fileExtensions'] ) !== -1 );
		// Determine passthrough mode
		if ( this.isOggFormat() || ( wembExt && this.isWebMFormat() ) ) {
			// Already Ogg, no need to encode
			return true;
		} else if ( this.isSourceAudio() || this.isSourceVideo() ) {
			// OK to encode
			return false;
		} else {
			// Not audio or video, can't encode
			return true;
		}
	},

	isSourceAudio: function() {
		return ( this.getSourceFileInfo().contentType.indexOf("audio/") != -1 );
	},

	isSourceVideo: function() {
		return ( this.getSourceFileInfo().contentType.indexOf("video/") != -1 );
	},

	isOggFormat: function() {
		var contentType = this.getSourceFileInfo().contentType;
		return ( contentType.indexOf("video/ogg") != -1
			|| contentType.indexOf("application/ogg") != -1 
			|| contentType.indexOf("audio/ogg") != -1);
	},
	isWebMFormat: function() {
		return (  this.getSourceFileInfo().contentType.indexOf('webm') != -1 );
	},
	
	/**
	 * Get the source file info for the current file selected into this.fogg
	 */
	getSourceFileInfo: function() {
		if ( !this.fogg.sourceInfo ) {
			mw.log( 'Error:: No firefogg source info is available' );
			return false;
		}
		try {
			this.sourceFileInfo = JSON.parse( this.fogg.sourceInfo );
		} catch ( e ) {
			mw.log( 'Error :: could not parse fogg sourceInfo' );
			return false;
		}
		return this.sourceFileInfo;
	},
	
	// Get the filename
	getFileName: function(){
		// If file is in a supported format don't change extension
		if( this.isUploadFormat() ){
			return this.fogg.sourceFilename;
		} else {			
			if( this.isSourceAudio() ){
				return this.fogg.sourceFilename.split('.').slice(0,-1).join('.') + '.oga';
			}
			if( this.isSourceVideo() ){
                var ext = this.getEncodeExt();
				return this.fogg.sourceFilename.split('.').slice(0,-1).join('.') + '.' + ext;
			}
		}
	},
	getEncodeExt: function(){
		var encodeSettings = mw.UploadWizard.config[ 'firefoggEncodeSettings' ];
		if( encodeSettings[ 'videoCodec' ] 
		            && 
		    encodeSettings[ 'videoCodec' ] == 'vp8' )
		{
			return 'webm';
		} else { 
			return 'ogv';
		}
	},
	
	/**
	 * Get the encode settings from configuration and the current selected video type 
	 */
	getEncodeSettings: function(){
		if( this.isUploadFormat() ){
			return { 'passthrough' : true };
		}
		// Get the default encode settings: 
		var encodeSettings = mw.UploadWizard.config[ 'firefoggEncodeSettings' ];
		// Update the format: 
		this.fogg.setFormat( ( this.getEncodeExt() == 'webm' ) ? 'webm' : 'ogg' );
		
		mw.log("FirefoggTransport::getEncodeSettings> " +  JSON.stringify(  encodeSettings ) );
		return encodeSettings;
	}
};
