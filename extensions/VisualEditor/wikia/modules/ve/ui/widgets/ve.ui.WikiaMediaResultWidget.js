/*!
 * VisualEditor UserInterface WikiaMediaResultWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global require */

/**
 * Creates an ve.ui.WikiaMediaResultWidget object.
 *
 * @class
 * @extends ve.ui.MWMediaResultWidget
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
	ve.ui.MWMediaResultWidget.call( this, data, config );

	this.image = new Image();
	this.$image = this.$$( this.image );
	this.$image
		.load( ve.bind( this.onThumbnailLoad, this ) )
		.error( ve.bind( this.onThumbnailError, this ) );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaResultWidget, ve.ui.MWMediaResultWidget );

/* Methods */

/**
 * Build a thumbnail.
 *
 * @method
 * @returns {jQuery} Thumbnail element
 */
ve.ui.WikiaMediaResultWidget.prototype.buildThumbnail = function () {
	var	$back = this.$$( '<div>' );
	this.$front = this.$$( '<div>' );
	var	$thumb = $back.add( this.$front );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		this.image.src = thumbnailer.getThumbURL(
			this.data.url,
			'image',
			this.size,
			this.size
		);

		$thumb.addClass( 've-ui-mwMediaResultWidget-thumbnail' );
		$thumb.addClass( 've-ui-WikiaMediaResultWidget-thumbnail' );
		$thumb.last().css( 'background-image', 'url(' + this.image.src + ')' );

	}, this ) );

	return $thumb;
};

ve.ui.WikiaMediaResultWidget.prototype.onThumbnailLoad = function () {
	// Parent method
	ve.ui.MWMediaResultWidget.prototype.onThumbnailLoad.call( this );

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
