/*!
 * VisualEditor UserInterface WikiaUploadWidget class.
 */

/* global mw */

/**
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaUploadWidget = function VeUiWikiaUploadWidget( config ) {
	var uploadButtonConfig;

	// Parent constructor
	ve.ui.Widget.call( this, config );

	uploadButtonConfig = {
		'$$': this.$$,
		'label': ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-upload-button' ),
		'flags': ['constructive']
	};
	if ( !config.hideIcon ) {
		uploadButtonConfig.icon = 'upload-small';
	}

	// Properties
	this.$uploadIcon = this.$$( '<span>' )
		.addClass( 've-ui-icon-upload' );

	this.$uploadLabel = this.$$( '<span>' )
		.text( ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-upload-label' ) );

	this.uploadButton = new ve.ui.ButtonWidget( uploadButtonConfig );

	this.$form = this.$$( '<form>' );
	this.$file = this.$$( '<input>' ).attr( {
		'type': 'file',
		'name': 'file'
	} );

	// Events
	this.$.on( 'click', ve.bind( this.onClick, this ) );
	this.uploadButton.on( 'click', ve.bind( this.onClick, this ) );
	this.$file.on( 'change', ve.bind( this.onFileChange, this ) );

	// Initialization
	this.$form.append( this.$file );
	this.$
		.addClass( 've-ui-wikiaUploadButtonWidget' )
		.append( this.$uploadIcon )
		.append( this.$uploadLabel )
		.append( this.uploadButton.$ )
		.append( this.$form );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaUploadWidget, ve.ui.Widget );

/* Events */

/**
 * @event change
 */

/**
 * @event upload
 * @param {Object} data The API response data.
 */

/* Static methods */

/**
 * Check file for size and filetype errors
 * @method
 * @param {File} file File object containing properties of user uploaded file
 * @returns {Array} Array of error strings. May return empty array
 */
ve.ui.WikiaUploadWidget.static.validateFile = function ( file ) {
	var errors = [],
		maxUploadSize = mw.config.get( 'wgMaxUploadSize' ),
		fileExtensions = mw.config.get( 'wgFileExtensions' ),
		filetype = fileExtensions[ ve.indexOf( file.type.substr( file.type.indexOf( '/' ) + 1 ), fileExtensions ) ];

	if ( ve.isPlainObject( maxUploadSize ) ) {
		maxUploadSize = maxUploadSize[ maxUploadSize[ filetype ] ? filetype : '*' ];
	}
	if ( file.size > maxUploadSize ) {
		// Convert maxUploadSize from bytes to MB rounded to two decimals.
		errors.push( [ 'size', Math.round( maxUploadSize / 1048576 * 100 ) / 100 ] );
	}
	if ( !filetype ) {
		errors.push( [ 'filetype',  fileExtensions.join( ', ' ) ] );
	}

	return errors;
};

/* Methods */

/**
 * Handle click event
 *
 * @method
 */
ve.ui.WikiaUploadWidget.prototype.onClick = function () {
	this.$file[0].click();
};

/**
 * Handle input file change event
 *
 * @method
 * @fires success
 */
ve.ui.WikiaUploadWidget.prototype.onFileChange = function () {
	var fileErrors;

	if ( !this.$file[0].files[0] ) {
		return;
	}

	fileErrors = this.constructor.static.validateFile( this.$file[0].files[0] );

	if ( fileErrors.length ) {
		mw.config.get( 'GlobalNotification' ).show(
			// show filetype message first if multiple errors exist
			ve.msg(
				'wikia-visualeditor-dialog-wikiamediainsert-upload-error-' + fileErrors[ fileErrors.length - 1 ][ 0 ],
				 fileErrors[ fileErrors.length - 1 ][ 1 ]
			),
			'error',
			$( '.ve-ui-frame' ).contents().find( '.ve-ui-window-body' )
		);
	} else {
		$.ajax( {
			'url': mw.util.wikiScript( 'api' ) + '?action=apitempupload&type=temporary&format=json',
			'type': 'post',
			'cache': false,
			'contentType': false,
			'processData': false,
			'data': new FormData( this.$form[0] ),
			'success': ve.bind( this.onUploadSuccess, this ),
			'error': ve.bind( this.onUploadError, this )
		} );
		this.showUploadAnimation();
	}
	this.$file.attr( 'value', '' );
	this.emit( 'change' );
};

/**
 * Responds to upload success
 *
 * @method
 * @param {Object} data API response
 * @fires success
 */
ve.ui.WikiaUploadWidget.prototype.onUploadSuccess = function ( data ) {
	this.hideUploadAnimation();

	// Error response
	if ( data.error ) {
		window.alert( data.error.info );
		return;
	}

	// Success
	// TODO: this should probably fire 'success' not 'upload'
	this.emit( 'upload', data.apitempupload );
};

/**
 * Responds to upload error
 *
 * @method
 */
ve.ui.WikiaUploadWidget.prototype.onUploadError = function () {
	this.hideUploadAnimation();
	window.alert( ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-upload-error' ) );
};


/*
 * Shows upload animation
 *
 * @method
 */
ve.ui.WikiaUploadWidget.prototype.showUploadAnimation = function () {
	this.$.addClass( 've-ui-texture-pending' );
};

/*
 * Hides upload animation
 *
 * @method
 */
ve.ui.WikiaUploadWidget.prototype.hideUploadAnimation = function () {
	this.$.removeClass( 've-ui-texture-pending' );
};
