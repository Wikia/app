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
	var image = new Image(),
		$image = this.$$( image ),
		$back = this.$$( '<div>' ),
		$front = this.$$( '<div>' ),
		$thumb = $back.add( $front );

	// Preload image
	$image
		.load( ve.bind( this.onThumbnailLoad, this ) )
		.error( ve.bind( this.onThumbnailError, this ) );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		image.src = thumbnailer.getThumbURL( this.data.url, 'image', this.size, this.size );

		$thumb.addClass( 've-ui-WikiaMediaResultWidget-thumbnail' );
		$thumb.last().css( 'background-image', 'url(' + image.src + ')' );
		$front.addClass( 've-ui-mwMediaResultWidget-crop' );
		$thumb.css( {
			'height': '100%',
			'left': 0,
			'position': 'absolute',
			'top': 0,
			'width': '100%'
		} );
	}, this ) );

	return $thumb;
};
