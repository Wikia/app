/*!
 * VisualEditor UserInterface WikiaMediaOptionWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global require,mw */

/**
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} model Item data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaMediaOptionWidget = function VeUiWikiaMediaOptionWidget( model, config ) {
	var $label, $labelMetadata;

	// Configuration intialization
	config = config || {};

	this.model = model;

	// Parent constructor
	ve.ui.WikiaMediaOptionWidget.super.call( this, this.model.title, config );

	// Properties
	this.size = config.size || 158;
	this.mwTitle = new mw.Title( this.model.title ).getNameText();
	this.image = new Image();
	this.$image = this.$( this.image );
	this.$back = this.$( '<div>' );
	this.$front = this.$( '<div>' );
	this.$thumb = this.$back.add( this.$front );
	this.check = new OO.ui.ButtonWidget( {
		'$': this.$,
		'icon': 'unchecked',
		'frameless': true
	} );

	// Events
	this.$image
		.load( ve.bind( this.onThumbnailLoad, this ) )
		.error( ve.bind( this.onThumbnailError, this ) );
	this.check.on( 'click', ve.bind( function () {
		this.emit( 'check', this );
	}, this ) );

	// Initialization
	this.loadThumbnail();
	$label = $( '<span>' )
		.attr( {
			'class': 've-ui-wikiaMediaOptionWidget-label-title',
			'title': this.mwTitle
			} )
		.text( this.mwTitle );
	$labelMetadata = $( '<span>' )
		.addClass( 've-ui-wikiaMediaOptionWidget-label-metadata' )
		.text( this.getSecondaryMetadata( this.model.type ) );
	$label.after( '<br>' );
	$label.after( $labelMetadata );
	this.setLabel( $label );
	this.check.$element.addClass( 've-ui-wikiaMediaOptionWidget-check' );
	this.$element
		.addClass( 've-ui-mwMediaResultWidget ve-ui-texture-pending ' + this.model.type )
		.css( { 'width': this.size, 'height': this.size } )
		.prepend( this.$thumb, this.check.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaOptionWidget, OO.ui.OptionWidget );

/* Methods */

/**
 * Load image thumbnails.
 *
 * @method
 */
ve.ui.WikiaMediaOptionWidget.prototype.loadThumbnail = function () {
	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		this.image.src = thumbnailer.getThumbURL( this.model.url, 'image', this.size - 2, this.size - 2 );
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
	this.$element
		.addClass( 've-ui-mwMediaResultWidget-done' )
		.removeClass( 've-ui-texture-pending' );

	if ( this.image.width >= this.size && this.image.height >= this.size ) {
		this.$front.addClass( 've-ui-mwMediaResultWidget-crop' );
		this.$thumb.css( {
			'width': '100%',
			'height': '100%'
		} );
	} else {
		this.$thumb.eq(0).css( {
			'width': this.size - 2,
			'height': this.size - 2
		} );
		this.$thumb.eq(1).css( {
			'width': this.image.width,
			'height': this.image.height,
			'left': '50%',
			'top': '50%',
			'margin-left': ( -this.image.width / 2 ) + 1,
			'margin-top': ( -this.image.height / 2 ) + 1
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
	if ( checked ) {
		this.$element.addClass( 've-ui-wikiaMediaOptionWidget-selected' );
	} else {
		this.$element.removeClass( 've-ui-wikiaMediaOptionWidget-selected' );
	}
};

ve.ui.WikiaMediaOptionWidget.prototype.getModel = function () {
	return this.model;
};

/**
 * Get the secondary metadata from the model. This is meant to be overridden by a child class.
 *
 * @method
 * @return {string}
 */
ve.ui.WikiaMediaOptionWidget.prototype.getSecondaryMetadata = function () {
	return '';
};

