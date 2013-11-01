/*!
 * VisualEditor UserInterface WikiaMediaOptionWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global require,mw */

/**
 * @class
 * @extends ve.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} model Item data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaMediaOptionWidget = function VeUiWikiaMediaOptionWidget( model, config ) {
	// Configuration intialization
	config = config || {};

	this.model = model

	// Parent constructor
	ve.ui.OptionWidget.call( this, this.model.title, config );

	// Properties
	this.size = config.size || 160;
	this.mwTitle = new mw.Title( this.model.title ).getNameText();
	this.image = new Image();
	this.$image = this.$$( this.image );
	this.$back = this.$$( '<div>' );
	this.$front = this.$$( '<div>' );
	this.$thumb = this.$back.add( this.$front );
	this.check = new ve.ui.IconButtonWidget( { 'icon': 'unchecked' } );

	// Events
	this.$image
		.load( ve.bind( this.onThumbnailLoad, this ) )
		.error( ve.bind( this.onThumbnailError, this ) );

	// Initialization
	this.loadThumbnail();
	this.setLabel( this.mwTitle );
	this.check.$.addClass( 've-ui-wikiaMediaOptionWidget-check' );
	this.$
		.addClass( 've-ui-mwMediaResultWidget ve-ui-texture-pending ' + this.model.type )
		.css( { 'width': this.size, 'height': this.size } )
		.prepend( this.$thumb, this.check.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaOptionWidget, ve.ui.OptionWidget );

/* Methods */

/**
 * Load image thumbnails.
 *
 * @method
 */
ve.ui.WikiaMediaOptionWidget.prototype.loadThumbnail = function () {
	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		this.image.src = thumbnailer.getThumbURL( this.model.url, 'image', this.size, this.size );
		this.$thumb.addClass(
			've-ui-mwMediaResultWidget-thumbnail ve-ui-WikiaMediaOptionWidget-thumbnail'
		);
		this.$thumb.last().css( 'background-image', 'url(' + this.image.src + ')' );
	}, this ) );
};

/**
 * Handle when thumbnails are loaded.
 *
 * @method
 */
ve.ui.WikiaMediaOptionWidget.prototype.onThumbnailLoad = function () {
	this.$thumb.first().addClass( 've-ui-texture-transparency' );
	this.$
		.addClass( 've-ui-mwMediaResultWidget-done' )
		.removeClass( 've-ui-texture-pending' );

	if ( this.image.width >= this.size && this.image.height >= this.size ) {
		this.$front.addClass( 've-ui-mwMediaResultWidget-crop' );
		this.$thumb.css( { 'width': '100%', 'height': '100%' } );
	} else {
		this.$thumb.css( {
			'width': this.image.width,
			'height': this.image.height,
			'left': '50%',
			'top': '50%',
			'margin-left': Math.round( -this.image.width / 2 ),
			'margin-top': Math.round( -this.image.height / 2 )
		} );
	}
};

/**
 * Handle thumbnail loading errors.
 *
 * @method
 * @see {@link ve.ui.MWMediaResultWidget.prototype.onThumbnailError}
 */
ve.ui.WikiaMediaOptionWidget.prototype.onThumbnailError =
	ve.ui.MWMediaResultWidget.prototype.onThumbnailError;

/**
 * Show the correct icon
 *
 * @method
 * @param {boolean} checked Should the item be checked?
 */

ve.ui.WikiaMediaOptionWidget.prototype.setChecked = function ( checked ) {
	this.check.setIcon( checked ? 'checked' : 'unchecked' );
};

ve.ui.WikiaMediaOptionWidget.prototype.getModel = function () {
	return this.model;
};
