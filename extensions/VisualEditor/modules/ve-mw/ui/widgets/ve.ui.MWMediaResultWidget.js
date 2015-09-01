/*!
 * VisualEditor UserInterface MWMediaResultWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWMediaResultWidget object.
 *
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {number} [rowHeight] Height of the row this result is part of
 * @cfg {number} [maxRowWidth] A limit for the width of the row this
 *  result is a part of.
 * @cfg {number} [minWidth] Minimum width for the result
 * @cfg {number} [maxWidth] Maximum width for the result
 */
ve.ui.MWMediaResultWidget = function VeUiMWMediaResultWidget( config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	OO.ui.OptionWidget.call( this, config );

	// Properties
	this.setRowHeight( config.rowHeight || 150 );
	this.maxRowWidth = config.maxRowWidth || 500;
	this.minWidth = config.minWidth || this.maxRowWidth / 5;
	this.maxWidth = config.maxWidth || this.maxRowWidth * 2 / 3;

	this.imageDimensions = {};

	this.isAudio = this.data.mediatype === 'AUDIO';

	// Store the thumbnail url
	this.thumbUrl = this.data.thumburl;
	this.src = null;
	this.row = null;

	this.$thumb = $( '<img>' )
		.addClass( 've-ui-mwMediaResultWidget-thumbnail' )
		.on( {
			load: this.onThumbnailLoad.bind( this ),
			error: this.onThumbnailError.bind( this )
		} );
	this.$overlay = $( '<div>' )
		.addClass( 've-ui-mwMediaResultWidget-overlay' );

	this.calculateSizing( this.data );

	// Get wiki default thumbnail size
	this.defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' )
		.defaultUserOptions.defaultthumbsize;

	// Initialization
	this.setLabel( new mw.Title( this.data.title ).getNameText() );
	this.$label.addClass( 've-ui-mwMediaResultWidget-nameLabel' );

	this.$element
		.addClass( 've-ui-mwMediaResultWidget ve-ui-texture-pending' )
		.prepend( this.$thumb, this.$overlay );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMediaResultWidget, OO.ui.OptionWidget );

/* Methods */
/** */
ve.ui.MWMediaResultWidget.prototype.onThumbnailLoad = function () {
	this.$thumb.first().addClass( 've-ui-texture-transparency' );
	this.$element
		.addClass( 've-ui-mwMediaResultWidget-done' )
		.removeClass( 've-ui-texture-pending' );
};

/** */
ve.ui.MWMediaResultWidget.prototype.onThumbnailError = function () {
	this.$thumb.last()
		.css( 'background-image', '' )
		.addClass( 've-ui-texture-alert' );
	this.$element
		.addClass( 've-ui-mwMediaResultWidget-error' )
		.removeClass( 've-ui-texture-pending' );
};

/**
 * Resize the thumbnail and wrapper according to row height and bounding boxes, if given.
 *
 * @param {Object} originalDimensions Original image dimensions with width and height values
 * @param {Object} [boundingBox] Specific bounding box, if supplied
 */
ve.ui.MWMediaResultWidget.prototype.calculateSizing = function ( originalDimensions, boundingBox ) {
	var wrapperPadding,
		imageDimensions = {};

	boundingBox = boundingBox || {};

	if ( this.isAudio ) {
		// HACK: We are getting the wrong information from the
		// API about audio files. Set their thumbnail to square 120px
		imageDimensions = {
			width: 120,
			height: 120
		};
	} else {
		// Get the image within the bounding box
		imageDimensions = ve.dm.MWImageNode.static.resizeToBoundingBox(
			// Image original dimensions
			{
				width: originalDimensions.width || originalDimensions.thumbwidth,
				height: originalDimensions.height || originalDimensions.thumbwidth
			},
			// Bounding box
			{
				width: boundingBox.width || this.getImageMaxWidth(),
				height: boundingBox.height || this.getRowHeight()
			}
		);
	}
	this.imageDimensions = imageDimensions;
	// Set the thumbnail size
	this.$thumb.css( this.imageDimensions );

	// Set the box size
	wrapperPadding = this.calculateWrapperPadding( this.imageDimensions );
	this.$element.css( wrapperPadding );
};

/**
 * Replace the empty .src attribute of the image with the
 * actual src.
 */
ve.ui.MWMediaResultWidget.prototype.lazyLoad = function () {
	if ( !this.hasSrc() ) {
		this.src = this.thumbUrl;
		this.$thumb.attr( 'src', this.thumbUrl );
	}
};

/**
 * Retrieve the store dimensions object
 *
 * @return {Object} Thumb dimensions
 */
ve.ui.MWMediaResultWidget.prototype.getDimensions = function () {
	return this.dimensions;
};

/**
 * Resize thumbnail and element according to the resize factor
 *
 * @param {number} resizeFactor The resizing factor for the image
 */
ve.ui.MWMediaResultWidget.prototype.resizeThumb = function ( resizeFactor ) {
	var boundingBox,
		imageOriginalWidth = this.imageDimensions.width,
		wrapperWidth = this.$element.width();
	// Set the new row height
	this.setRowHeight( Math.ceil( this.getRowHeight() * resizeFactor ) );

	boundingBox = {
		width: Math.ceil( this.imageDimensions.width * resizeFactor ),
		height: this.getRowHeight()
	};

	this.calculateSizing( this.data, boundingBox );

	// We need to adjust the wrapper this time to fit the "perfect"
	// dimensions, regardless of how small the image is
	if ( imageOriginalWidth < wrapperWidth ) {
		boundingBox.width = wrapperWidth * resizeFactor;
	}
	this.$element.css( this.calculateWrapperPadding( boundingBox ) );
};

/**
 * Adjust the wrapper padding for small images
 *
 * @param {Object} thumbDimensions Thumbnail dimensions
 * @return {Object} Css styling for the wrapper
 */
ve.ui.MWMediaResultWidget.prototype.calculateWrapperPadding = function ( thumbDimensions ) {
	var css = {
			height: this.rowHeight,
			width: thumbDimensions.width,
			lineHeight: this.getRowHeight() + 'px'
		};

	// Check if the image is too thin so we can make a bit of space around it
	if ( thumbDimensions.width < this.minWidth ) {
		css.width = this.minWidth;
	}

	return css;
};

/**
 * Set the row height for all size calculations
 *
 * @return {number} rowHeight Row height
 */
ve.ui.MWMediaResultWidget.prototype.getRowHeight = function () {
	return this.rowHeight;
};

/**
 * Set the row height for all size calculations
 *
 * @param {number} rowHeight Row height
 */
ve.ui.MWMediaResultWidget.prototype.setRowHeight = function ( rowHeight ) {
	this.rowHeight = rowHeight;
};

ve.ui.MWMediaResultWidget.prototype.setImageMaxWidth = function ( width ) {
	this.maxWidth = width;
};
ve.ui.MWMediaResultWidget.prototype.getImageMaxWidth = function () {
	return this.maxWidth;
};

/**
 * Set the row this result is in.
 *
 * @param {number} row Row number
 */
ve.ui.MWMediaResultWidget.prototype.setRow = function ( row ) {
	this.row = row;
};

/**
 * Get the row this result is in.
 *
 * @return {number} row Row number
 */
ve.ui.MWMediaResultWidget.prototype.getRow = function () {
	return this.row;
};

/**
 * Check if the image has a src attribute already
 *
 * @return {boolean} Thumbnail has its source attribute set
 */
ve.ui.MWMediaResultWidget.prototype.hasSrc = function () {
	return !!this.src;
};
