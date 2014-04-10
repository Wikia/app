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
	this.$image = $image || this.$image || this.$element;
	this.$wikiaVideoElements = $( [] );

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
 * Creates and returns a jQuery object for the video play button.
 *
 * @method
 * @returns {jQuery}
 */
ve.ce.WikiaVideoNode.prototype.createPlayButton = function () {
	return this.$( '<span>' ).addClass( 'play-circle ve-no-shield' );
};

/**
 * Handle setting up.
 *
 * @method
 */
ve.ce.WikiaVideoNode.prototype.onWikiaVideoSetup = function () {
	var $parent;

	if ( !this.$wikiaVideoElements.length ) {
		$parent = this.$image.parent().addClass( 'video video-thumbnail' );

		// Play button
		this.$wikiaVideoElements.add(
			this.createPlayButton().appendTo( $parent )
		);
	}
};

/**
 * Handle tearing down.
 *
 * @method
 */
ve.ce.WikiaVideoNode.prototype.onWikiaVideoTeardown = function () {
	if ( this.$wikiaVideoElements.length ) {
		this.$image.parent().removeClass( 'video video-thumbnail' );

		this.$wikiaVideoElements.remove();
		this.$wikiaVideoElements = $( [] );
	}
};
