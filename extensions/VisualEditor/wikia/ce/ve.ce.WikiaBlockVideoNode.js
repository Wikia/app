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
ve.ce.WikiaBlockVideoNode.prototype.getOverlayElement = function () {
	var $br, $overlay, $title, $views;

	$overlay = this.$$( '<span>' )
		.addClass( 'info-overlay' )
		.css( 'max-width', this.model.getAttribute( 'width' ) );

	$title = this.$$( '<span>' )
		.addClass( 'info-overlay-title' )
		.css( 'width', this.model.getAttribute( 'width' ) - 60 );
		//.text( this.model.getAttribute( 'title' ) );

	$br = this.$$( '<br>' );

	$views = this.$$( '<span>' )
		.addClass( 'info-overlay-views' );
		//.text( this.model.getAttribute( 'views' ) );

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
	var $image, $wrapper;

	$wrapper = this.$$( '<div>' )
		.addClass( 'wikia-video-play-button' )
		.css({
			'line-height': this.model.getAttribute( 'height' ),
			'width': this.model.getAttribute( 'width' )
		});

	$image = this.$$( '<img>' )
		.addClass( 'sprite play' ) // TODO: support 'large'
		.attr( 'src', mw.config.get( 'wgBlankImgUrl' ) );

	return $wrapper.append( $image );
};

/**
 * Builds the play button element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockVideoNode.prototype.getPlayButtonElement = function () {
	var $image, $wrapper;

	$wrapper = this.$$( '<div>' )
		.addClass( 'Wikia-video-play-button' )
		.css({
			'line-height': this.model.getAttribute( 'height' ) + 'px',
			'width': this.model.getAttribute( 'width' )
		});

	$image = this.$$( '<img>' )
		.addClass( 'sprite play' ) // TODO: support 'large'
		.attr( 'src', mw.config.get( 'wgBlankImgUrl' ) );

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
	ve.ce.WikiaBlockMediaNode.prototype.update.call( this, replaceRoot );

	this.$anchor
		.append( this.getOverlayElement() )
		.prepend( this.getPlayButtonElement() );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaBlockVideoNode );