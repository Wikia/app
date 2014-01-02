/*!
 * VisualEditor UserInterface MWMediaResultWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Creates an ve.ui.MWMediaResultWidget object.
 *
 * @class
 * @extends ve.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.MWMediaResultWidget = function VeUiMWMediaResultWidget( data, config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.OptionWidget.call( this, data, config );

	// Properties
	this.size = config.size || 150;
	this.$thumb = this.buildThumbnail();
	this.$overlay = this.$$( '<div>' );

	// Initialization
	this.setLabel( new mw.Title( this.data.title ).getNameText() );
	this.$overlay.addClass( 've-ui-mwMediaResultWidget-overlay' );
	this.$
		.addClass( 've-ui-mwMediaResultWidget ve-ui-texture-pending' )
		.css( { 'width': this.size, 'height': this.size } )
		.prepend( this.$thumb, this.$overlay );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWMediaResultWidget, ve.ui.OptionWidget );

/* Methods */

/** */
ve.ui.MWMediaResultWidget.prototype.onThumbnailLoad = function () {
	this.$thumb.first().addClass( 've-ui-texture-transparency' );
	this.$
		.addClass( 've-ui-mwMediaResultWidget-done' )
		.removeClass( 've-ui-texture-pending' );
};

/** */
ve.ui.MWMediaResultWidget.prototype.onThumbnailError = function () {
	this.$thumb.last()
		.css( 'background-image', '' )
		.addClass( 've-ui-texture-alert' );
	this.$
		.addClass( 've-ui-mwMediaResultWidget-error' )
		.removeClass( 've-ui-texture-pending' );
};

/**
 * Build a thumbnail.
 *
 * @method
 * @returns {jQuery} Thumbnail element
 */
ve.ui.MWMediaResultWidget.prototype.buildThumbnail = function () {
	var info = this.data.imageinfo[0],
		image = new Image(),
		$image = this.$$( image ),
		$back = this.$$( '<div>' ),
		$front = this.$$( '<div>' ),
		$thumb = $back.add( $front );

	// Preload image
	$image
		.load( ve.bind( this.onThumbnailLoad, this ) )
		.error( ve.bind( this.onThumbnailError, this ) );
	image.src = info.thumburl;

	$thumb.addClass( 've-ui-mwMediaResultWidget-thumbnail' );
	$thumb.last().css( 'background-image', 'url(' + info.thumburl + ')' );
	if ( info.width >= this.size && info.height >= this.size ) {
		$front.addClass( 've-ui-mwMediaResultWidget-crop' );
		$thumb.css( { 'width': '100%', 'height': '100%' } );
	} else {
		$thumb.css( {
			'width': info.thumbwidth,
			'height': info.thumbheight,
			'left': '50%',
			'top': '50%',
			'margin-left': Math.round( -info.thumbwidth / 2 ),
			'margin-top': Math.round( -info.thumbheight / 2 )
		} );
	}

	return $thumb;
};
