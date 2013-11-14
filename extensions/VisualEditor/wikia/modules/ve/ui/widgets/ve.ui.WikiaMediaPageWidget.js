/*!
 * VisualEditor UserInterface WikiaMediaPageWidget class.
 */

/* global require */

/**
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} model Page item model
 * @param {Object} config Configuration options
 * @param {jQuery} $license jQuery object containing license dropdown
 * @param {boolean} [config.editable] Whether or not the page should be editable. Editable pages
 * will have inputs and textareas instead of text blocks.
 */
ve.ui.WikiaMediaPageWidget = function VeUiWikiaMediaPageWidget( model, config ) {
	var titleParts = model.title.match( /^(?:[^:]*\:)?(.*?)(\.[^.]+)?$/ );

	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.editable = !!config.editable;
	this.fieldset = new ve.ui.FieldsetLayout( { '$$': this.$$ } );
	this.image = null;
	this.model = model;
	this.removeButton = new ve.ui.ButtonWidget( {
		'$$': this.$$,
		'label': 'Remove from the cart', //TODO: i18n
		'flags': ['destructive']
	} );
	this.title = new ve.ui.TextInputWidget( {
		'$$': this.$$,
		'readOnly': !this.editable,
		'value': titleParts[1]
	} );
	this.titleLabel = new ve.ui.InputLabelWidget( {
		'$$': this.$$,
		'input': this.title,
		'label': 'Title' // TODO: i18n
	} );

	this.$extension = this.$$( '<span>' );
	this.$item = null;
	this.$itemWrapper = this.$$( '<div>' );
	this.$license = null;
	this.$licenseLabel = null;
	this.$licenseSelect = null;
	this.$overlay = null;

	// Events
	this.$itemWrapper.on( 'click', ve.bind( this.onItemClick, this ) );
	this.removeButton.connect( this, { 'click': 'onRemoveButtonClick' } );

	// Initialization
	this.$itemWrapper.addClass( 've-ui-wikiaMediaPageWidget-item' );
	this.$extension
		.addClass( 've-ui-wikiaMediaPageWidget-item-extension' )
		.text( titleParts[2] );
	this.title.$.append( this.$extension );
	this.fieldset.$.append( this.titleLabel.$, this.title.$ );
	if ( this.model.type === 'photo' && this.editable ) {
		this.setupLicense( config.$license );
	}
	this.fieldset.$.append( this.removeButton.$ );
	this.$
		.addClass( 've-ui-wikiaMediaPageWidget ' + this.model.type )
		.append( this.$itemWrapper, this.fieldset.$ );

	this.setupImage();
	if ( this.model.type === 'video' ) {
		// TODO: support embdedded video
		this.setupVideoOverlay();
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaPageWidget, ve.ui.Widget );

/* Events */

/**
 * @event remove
 * @param {ve.dm.WikiaCartItem} item The cart item to be removed.
 */

/* Methods */

/** */
ve.ui.WikiaMediaPageWidget.prototype.getModel = function () {
	return this.model;
};

/**
 * Handle image load.
 *
 * @method
 */
ve.ui.WikiaMediaPageWidget.prototype.onImageLoad = function () {
	this.$itemWrapper.removeClass( 've-ui-texture-pending' );

	// TODO: if we have image dimensions available on the model, we could request the proper
	// thumbnail size without having to scale height in the browser.
	if ( this.image.height > 325 ) {
		this.image.height = 325;
	}
};

/**
 * Handle clicks on the media item.
 *
 * @method
 */
ve.ui.WikiaMediaPageWidget.prototype.onItemClick = function () {
	window.alert( ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-preview-alert' ) );
};

/** */
ve.ui.WikiaMediaPageWidget.prototype.onLicenseSelectChange = function () {
	this.model.setLicense( this.$licenseSelect.val() );
};

/**
 * Handle clicks on the remove button
 *
 * @method
 * @fires remove
 */
ve.ui.WikiaMediaPageWidget.prototype.onRemoveButtonClick = function () {
	this.emit( 'remove', this.model );
};

/**
 * Handle image setup.
 *
 * @method
 */
ve.ui.WikiaMediaPageWidget.prototype.setupImage = function () {
	this.image = new Image();
	this.$item = this.$$( this.image );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		// TODO: (nice to have) be able to calculate the bounding box without hardcoded
		// values but we would need to know bounding box size up front for that.
		this.image.src = thumbnailer.getThumbURL( this.model.url, 'image', 365 );
	}, this ) );

	this.$item.load( ve.bind( this.onImageLoad, this ) );
	this.$itemWrapper
		.addClass( 've-ui-texture-pending' )
		.append( this.$item );
};

/**
 * Handle license setup.
 *
 * FIXME: should be a <select> widget with label
 *
 * @method
 */
ve.ui.WikiaMediaPageWidget.prototype.setupLicense = function ( $license ) {
	// Properties
	this.$license = this.$$( '<div>' );
	this.$licenseLabel = this.$$( '<label>' );
	this.$licenseSelect = $license;

	// Events
	this.$licenseSelect.on( 'change', ve.bind( this.onLicenseSelectChange, this ) );

	// Initialization
	this.$license
		.addClass( 've-ui-wikiaMediaPageWidget-item-license' )
		.append( this.$licenseSelect );
	this.$licenseLabel
		.addClass( 've-ui-widget ve-ui-labeledElement-label ve-ui-inputLabelWidget' )
		.text( 'License' ); // TODO: i18n
	this.fieldset.$.append( this.$licenseLabel, this.$license );
}

/**
 * Handle video setup.
 *
 * @method
 */
ve.ui.WikiaMediaPageWidget.prototype.setupVideoOverlay = function () {
	this.$overlay = this.$$( '<span>' )
		.addClass( 'play-circle' )
		.add(
			this.$$( '<span>' ).addClass( 'play-arrow' )
		);

	this.$itemWrapper
		.addClass( 'wikia-video-thumbnail' )
		.prepend( this.$overlay );
};
