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
 */
ve.ui.WikiaUploadWidget.prototype.onFileChange = function () {
	if ( !this.$file[0].files[0] ) {
		return;
	}
	var formData = new FormData( this.$form[0] );
	$.ajax( {
		'url': mw.util.wikiScript( 'api' ) + '?action=apitempupload&type=temporary&format=json',
		'type': 'post',
		'cache': false,
		'contentType': false,
		'processData': false,
		'data': formData,
		'success': ve.bind( this.onUploadSuccess, this ),
		'error': ve.bind( this.onUploadError, this )
	} );
	this.showUploadAnimation();
	this.$file.attr( 'value', '' );
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
