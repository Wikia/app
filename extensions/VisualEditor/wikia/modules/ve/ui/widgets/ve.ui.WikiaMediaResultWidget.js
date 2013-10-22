/*!
 * VisualEditor UserInterface WikiaMediaResultWidget class.
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
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaMediaResultWidget = function VeUiWikiaMediaResultWidget( data, config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.OptionWidget.call( this, data, config );

	// Properties
	this.size = config.size || 160;
	this.mwTitle = new mw.Title( this.data.title ).getNameText();
	this.image = new Image();
	this.$image = this.$$( this.image );
	this.$back = this.$$( '<div>' );
	this.$front = this.$$( '<div>' );
	this.$thumb = this.$back.add( this.$front );
	this.$overlay = this.$$( '<div>' );

	// Events
	this.$image
		.load( ve.bind( this.onThumbnailLoad, this ) )
		.error( ve.bind( this.onThumbnailError, this ) );

	// Initialization
	this.loadThumbnail();
	this.setLabel( this.mwTitle );
	this.$overlay.addClass( 've-ui-mwMediaResultWidget-overlay' );
	this.$
		.addClass( 've-ui-mwMediaResultWidget ve-ui-texture-pending' )
		.css( { 'width': this.size, 'height': this.size } )
		.prepend( this.$thumb, this.$overlay );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaResultWidget, ve.ui.OptionWidget );

/* Methods */

ve.ui.WikiaMediaResultWidget.prototype.loadThumbnail = function () {
	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		this.image.src = thumbnailer.getThumbURL( this.data.url, 'image', this.size, this.size );
		this.$thumb.addClass(
			've-ui-mwMediaResultWidget-thumbnail ve-ui-WikiaMediaResultWidget-thumbnail'
		);
		this.$thumb.last().css( 'background-image', 'url(' + this.image.src + ')' );
	}, this ) );
};

ve.ui.WikiaMediaResultWidget.prototype.onThumbnailLoad = function () {
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
ve.ui.WikiaMediaResultWidget.prototype.onThumbnailError =
	ve.ui.MWMediaResultWidget.prototype.onThumbnailError;
