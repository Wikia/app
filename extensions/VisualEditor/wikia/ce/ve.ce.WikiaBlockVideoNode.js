/*!
 * VisualEditor ContentEditable WikiaBlockVideoNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw: false */

/**
 * ContentEditable Wikia video node.
 *
 * @class
 * @extends ve.ce.WikiaBlockVideoNode
 *
 * @constructor
 * @param {ve.dm.WikiaBlockVideoNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaBlockVideoNode = function VeCeWikiaBlockVideoNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaBlockMediaNode.call( this, model, config );

	this.$overlay = null;
	this.$playButton = null;
};

/* Inheritance */

ve.inheritClass( ve.ce.WikiaBlockVideoNode, ve.ce.WikiaBlockMediaNode );

/* Static Properties */

ve.ce.WikiaBlockVideoNode.static.name = 'wikiaBlockVideo';

/* Methods */

/**
 * Builds the anchor element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockVideoNode.prototype.getAnchorElement = function () {
	return ve.ce.WikiaBlockMediaNode.prototype.getAnchorElement.call( this )
		.addClass( 'video' );
};

/**
 * Builds the image element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockVideoNode.prototype.getImageElement = function () {
	return ve.ce.WikiaBlockMediaNode.prototype.getImageElement.call( this )
		.addClass( 'wikia-video-thumb' );
};

/**
 * Builds the information overlay element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockVideoNode.prototype.getOverlayElement = function ( title, width ) {
	var $br, $overlay, $title, $views,
		// mocked for now
		views = 0; //this.model.getAttribute( 'views' );

	$overlay = this.$$( '<span>' )
		.addClass( 'info-overlay' )
		.css( 'max-width', width );

	$title = this.$$( '<span>' )
		.addClass( 'info-overlay-title' )
		.css( 'width', width - 60 )
		.text( title );

	$br = this.$$( '<br>' );

	$views = this.$$( '<span>' )
		.addClass( 'info-overlay-views' )
		.text( $.msg( 'videohandler-video-views', views ) );

	return $overlay
		.append( $title )
		.append( $br )
		.append( $views );
};

/**
 * Builds the play button element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockVideoNode.prototype.getPlayButtonElement = function () {
	var $image, $wrapper,
		width = this.model.getAttribute( 'width' ),
		// This logic is from the function videoPlayButtonOverlay() in WikiaFileHelper.class.php
		size = ( width <= 170 ? 'small' : width > 360 ? 'large' : '' );

	$wrapper = this.$$( '<div>' )
		.addClass( 'Wikia-video-play-button' )
		.css({
			'line-height': this.model.getAttribute( 'height' ) + 'px',
			'width': width
		});

	$image = this.$$( '<img>' )
		.addClass( 'sprite play' )
		.attr( 'src', mw.config.get( 'wgBlankImgUrl' ) );

	if ( size ) {
		$image.addClass( size );
	}

	return $wrapper.append( $image );
};

/**
 * Builds the view from scratch.
 *
 * @emits setup
 * @emits teardown
 * @method
 */
ve.ce.WikiaBlockVideoNode.prototype.update = function ( replaceRoot ) {
	var title, width;

	ve.ce.WikiaBlockMediaNode.prototype.update.call( this, replaceRoot );

	// Mocked for now
	title = 'Test Attribution'; //this.model.getAttribute( 'title' );
	width = this.model.getAttribute( 'width' );

	// This logic is from the function videoInfoOverlay() in WikiaFileHelper.class.php
	if ( width > 230 && title ) {
		this.$anchor.append( this.getOverlayElement( title, width ) );
	}

	this.$anchor.prepend( this.getPlayButtonElement() );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaBlockVideoNode );