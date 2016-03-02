/*!
 * VisualEditor UserInterface WikiaUploadWidget class.
 */

/* global mw */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaUploadWidget = function VeUiWikiaUploadWidget( config ) {
	var uploadButtonConfig;

	// Parent constructor
	ve.ui.WikiaUploadWidget.super.call( this, config );

	uploadButtonConfig = {
		$: this.$,
		label: ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-upload-button' ),
		flags: ['primary']
	};
	if ( config.icon ) {
		uploadButtonConfig.icon = 'upload-small';
	}

	// Properties
	this.$uploadIcon = this.$( '<span>' )
		.addClass( 'oo-ui-icon-upload' );

	this.$uploadLabel = this.$( '<span>' )
		.text( ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-upload-label' ) );

	this.uploadButton = new OO.ui.ButtonWidget( uploadButtonConfig );

	this.$form = this.$( '<form>' );
	this.$file = this.$( '<input>' ).attr( {
		type: 'file',
		name: 'file'
	} );

	// Events
	this.$element.on( 'click', this.onClick.bind( this ) );
	this.uploadButton.on( 'click', this.onClick.bind( this ) );
	this.$file.on( 'change', this.onFileChange.bind( this ) );

	// Initialization
	this.$form.append( this.$file );
	this.$element
		.addClass( 've-ui-wikiaUploadButtonWidget' )
		.append( this.$uploadIcon )
		.append( this.$uploadLabel )
		.append( this.uploadButton.$element )
		.append( this.$form );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaUploadWidget, OO.ui.Widget );

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
ve.ui.WikiaUploadWidget.prototype.onFileChange = function ( event, file ) {
	var fileErrors,
		form,
		BannerNotification;

	file = file || this.$file[0].files[0];
	if ( !file ) {
		return;
	}

	fileErrors = this.constructor.static.validateFile( file );

	if ( fileErrors.length ) {
		BannerNotification = mw.config.get( 'BannerNotification' );
		new BannerNotification(
			// show filetype message first if multiple errors exist
			ve.msg(
				'wikia-visualeditor-dialog-wikiamediainsert-upload-error-' + fileErrors[ fileErrors.length - 1 ][ 0 ],
				fileErrors[ fileErrors.length - 1 ][ 1 ]
			),
			'error',
			$( '.ve-ui-frame' ).contents().find( '.ve-ui-window-body' )
		).show();
	} else {
		form = new FormData( document.createElement( 'form' ) );
		form.append( 'file', file );
		form.append( 'action', 'addmediatemporary' );
		form.append( 'format', 'json' );
		form.append( 'type', 'image' );
		form.append( 'token', mw.user.tokens.get( 'editToken' ) );

		$.ajax( {
			url: mw.util.wikiScript( 'api' ),
			type: 'post',
			cache: false,
			contentType: false,
			processData: false,
			data: form,
			success: this.onUploadSuccess.bind( this ),
			error: this.onUploadError.bind( this )
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
	this.emit( 'upload', data.addmediatemporary );
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
	this.$element.addClass( 've-ui-texture-pending' );
};

/*
 * Hides upload animation
 *
 * @method
 */
ve.ui.WikiaUploadWidget.prototype.hideUploadAnimation = function () {
	this.$element.removeClass( 've-ui-texture-pending' );
};

/**
 * Getter for upload button.
 * @returns the upload button
 */
ve.ui.WikiaUploadWidget.prototype.getUploadButton = function () {
	return this.uploadButton;
};
