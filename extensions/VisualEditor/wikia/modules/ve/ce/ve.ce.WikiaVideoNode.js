/*!
 * VisualEditor ContentEditable WikiaVideoNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw: false */

/**
 * VisualEditor ContentEditable Wikia video node.
 * This is an abstract class and as such should not be instantiated directly.
 *
 * @abstract
 * @class
 *
 * @constructor
 * @param {jQuery} [$image] jQuery object to append/prepend to
 */
ve.ce.WikiaVideoNode = function VeCeWikiaVideoNode( $image ) {

	// Properties
	this.$image = $image || this.$image || this.$;
	this.$wikiaVideoElements = $( [] );

	// The minimum allowable width for the information overlay to be displayed
	this.minWidth = 320;

	// These widths determine the play button sprite to use
	this.playButtonSmallWidth = 170;
	this.playButtonLargeWidth = 360;

	// Events
	this.connect( this, {
		'setup': 'onWikiaVideoSetup',
		'teardown': 'onWikiaVideoTeardown'
	} );
};

/* Static Properties */

ve.ce.WikiaVideoNode.static = {};

/* Methods */

/**
 * Creates and returns a jQuery object for the video information overlay.
 *
 * @method
 * @returns {jQuery}
 */
ve.ce.WikiaVideoNode.prototype.createOverlay = function () {
	var $br, $overlay, $title, $views,
		width = this.model.getAttribute( 'width' );

	$overlay = this.$$( '<span>' )
		.addClass( 'info-overlay' )
		.css( 'max-width', width );

	$title = this.$$( '<span>' )
		.addClass( 'info-overlay-title ve-no-shield' )
		.css( 'width', width - 60 )
		.text( this.model.getAttribute( 'title' ) );

	$br = this.$$( '<br>' );

	$views = this.$$( '<span>' )
		.addClass( 'info-overlay-views' )
		.text( mw.message( 'videohandler-video-views', this.model.getAttribute( 'views' ) ).plain() );

	return $overlay
		.append( $title )
		.append( $br )
		.append( $views );
};

/**
 * Creates and returns a jQuery object for the video play button.
 *
 * @method
 * @returns {jQuery}
 */
ve.ce.WikiaVideoNode.prototype.createPlayButton = function () {
	var $image, $wrapper,
		width = this.model.getAttribute( 'width' ),
		// This logic is from the function videoPlayButtonOverlay() in WikiaFileHelper.class.php
		size = (
			width <= this.playButtonSmallWidth ? 'small' : this.playButtonLargeWidth > 360 ? 'large' : ''
		);

	$wrapper = this.$$( '<div>' )
		.addClass( 'Wikia-video-play-button ve-no-shield' )
		.css( {
			'line-height': this.model.getAttribute( 'height' ) + 'px',
			'width': width
		} );

	$image = this.$$( '<img>' )
		.addClass( 'sprite play' )
		.attr( 'src', mw.config.get( 'wgBlankImgUrl' ) );

	if ( size ) {
		$image.addClass( size );
	}

	return $wrapper.append( $image );
};

/**
 * Handle setting up.
 *
 * @method
 */
ve.ce.WikiaVideoNode.prototype.onWikiaVideoSetup = function () {
	var $parent, title, width;

	if ( !this.$wikiaVideoElements.length ) {
		$parent = this.$image
			.addClass( 'Wikia-video-thumb' ).parent().addClass( 'video' );

		// Play button
		this.$wikiaVideoElements.add(
			this.createPlayButton().prependTo( $parent )
		);

		// TODO: implement title
		// title = this.model.getAttribute( 'title' );
		width = this.model.getAttribute( 'width' );

		// Information overlay
		// This logic is from the function videoInfoOverlay() in WikiaFileHelper.class.php
		if ( title && width > this.minWidth ) {
			this.$wikiaVideoElements.add(
				this.createOverlay().appendTo( $parent )
			);
		}
	}
};

/**
 * Handle tearing down.
 *
 * @method
 */
ve.ce.WikiaVideoNode.prototype.onWikiaVideoTeardown = function () {
	var $parent;

	if ( this.$wikiaVideoElements.length ) {
		$parent = this.$image
			.removeClass( 'Wikia-video-thumb' ).parent().removeClass( 'video' );

		this.$wikiaVideoElements.remove();
		this.$wikiaVideoElements = $( [] );
	}
};
