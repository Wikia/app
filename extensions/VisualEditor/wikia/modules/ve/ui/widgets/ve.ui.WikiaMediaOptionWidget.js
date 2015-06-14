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
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaMediaOptionWidget = function VeUiWikiaMediaOptionWidget( config ) {
	// Parent constructor
	ve.ui.WikiaMediaOptionWidget.super.call( this, config );

	// Properties
	this.data = config.data;
	this.size = config.size || 158;
	this.mwTitle = new mw.Title( this.data.title ).getNameText();
	this.image = new Image();
	this.$image = this.$( this.image );
	this.$back = this.$( '<div>' );
	this.$front = this.$( '<div>' );
	this.$thumb = this.$back.add( this.$front );
	this.$metaData = this.$( '<div>' );
	this.$preview = this.$( '<div>' );
	this.$previewIcon = this.$( '<span>' );
	this.$previewText = this.$( '<span>' );
	// TODO: Presence of checkbox perhaps should depend on the configuration
	this.check = new OO.ui.ButtonWidget( {
		$: this.$,
		icon: 'unchecked',
		frameless: true
	} );

	// Events
	this.$image
		.load( this.onThumbnailLoad.bind( this ) )
		.error(this.onThumbnailError.bind( this ) );
	this.check.on( 'click', function () {
		this.emit( 'check', this );
	}.bind( this ) );
	this.$metaData.on( 'mousedown', function ( event ) {
		this.emit( 'metadata', this, event );
	}.bind( this ) );
	this.$label.on( 'mousedown', function ( event ) {
		this.emit( 'label', this, event );
	}.bind( this ) );

	// Initialization
	this.loadThumbnail();
	this.setLabel( this.mwTitle );
	this.$label.attr( 'title', this.mwTitle );
	this.check.$element.addClass( 've-ui-wikiaMediaOptionWidget-check' );
	this.$previewIcon.addClass( 've-ui-wikiaMediaOptionWidget-preview-icon' );
	this.$previewText.addClass( 've-ui-wikiaMediaOptionWidget-preview-text' );
	this.$preview
		.addClass( 've-ui-wikiaMediaOptionWidget-preview' )
		.append( this.$previewIcon, this.$previewText );
	this.$metaData
		.addClass( 've-ui-wikiaMediaOptionWidget-metaData' )
		.append( this.$preview )
		.insertBefore( this.$label );
	this.$element
		.addClass( 've-ui-mwMediaResultWidget ve-ui-texture-pending ' + this.data.type )
		.css( { width: this.size, height: this.size } )
		.prepend( this.$thumb, this.check.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaOptionWidget, OO.ui.OptionWidget );

ve.ui.WikiaMediaOptionWidget.newFromData = function ( config ) {
	switch ( config.data.type ) {
		case 'photo':
			return new ve.ui.WikiaPhotoOptionWidget( config );
		case 'video':
			return new ve.ui.WikiaVideoOptionWidget( config );
		case 'map':
			return new ve.ui.WikiaMapOptionWidget( config );
		default:
			throw new Error( 'Uknown type: ' + config.data.type );
	}
};

/* Methods */

/**
 * Load image thumbnails.
 *
 * @method
 */
ve.ui.WikiaMediaOptionWidget.prototype.loadThumbnail = function () {
	require( ['wikia.thumbnailer'], function ( thumbnailer ) {
		var src = thumbnailer.getThumbURL( this.data.url, 'image', this.size - 2, this.size - 2);
		// FIXME: Using Thumbnailer should not require this trick of adding "thumb"
		if ( src.indexOf( '/thumb/') === -1 && src.indexOf( 'vignette') === -1 ) {
			src = src.split( '/' );
			src.splice( src.length - 2, 0, 'thumb' );
			src = src.join( '/' );
		}
		this.image.src = src;
		this.$thumb.addClass(
			've-ui-mwMediaResultWidget-thumbnail ve-ui-WikiaMediaOptionWidget-thumbnail'
		);
		this.$thumb.last().css( 'background-image', 'url(' + this.image.src + ')' );
	}.bind( this ) );
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
			width: '100%',
			height: '100%'
		} );
	} else {
		this.$thumb.eq(0).css( {
			width: this.size - 2,
			height: this.size - 2
		} );
		this.$thumb.eq(1).css( {
			width: this.image.width,
			height: this.image.height,
			left: '50%',
			top: '50%',
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
