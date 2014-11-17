/*!
 * VisualEditor UserInterface MobileSurface class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * A surface is a top-level object which contains both a surface model and a surface view.
 * This is the mobile version of the surface.
 *
 * @class
 * @extends ve.ui.Surface
 *
 * @constructor
 * @param {HTMLDocument|Array|ve.dm.LinearData|ve.dm.Document} dataOrDoc Document data to edit
 * @param {Object} [config] Configuration options
 */
ve.ui.MobileSurface = function VeUiMobileSurface() {
	// Parent constructor
	ve.ui.Surface.apply( this, arguments );

	// Events
	this.dialogs.connect( this, {
		'setup': 'showGlobalOverlay',
		// Dialogs emit this with a delay which causes hiding animation to fail
		// see https://bugzilla.wikimedia.org/show_bug.cgi?id=64775
		'teardown': 'hideGlobalOverlay'
	} );

	// Initialization
	this.$globalOverlay.append( this.context.$element )
		.addClass( 've-ui-mobileSurface-overlay ve-ui-mobileSurface-overlay-global' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MobileSurface, ve.ui.Surface );

/* Methods */

/**
 * Set up a context.
 *
 * @method
 * @returns {ve.ui.MobileContext} Context instance
 */
ve.ui.MobileSurface.prototype.setupContext = function () {
	this.context = new ve.ui.MobileContext( this, { '$': this.$ } );
};

/**
 * Make global overlay visible and cover the entire screen with it.
 * Also disables scrolling of underlying content.
 */
ve.ui.MobileSurface.prototype.showGlobalOverlay = function () {
	this.scrollPos = $( 'body' ).scrollTop();
	// overflow: hidden on 'body' alone is not enough for iOS Safari
	$( 'html, body' ).addClass( 've-ui-mobileSurface-overlay-global-enabled' );
	this.$globalOverlay.addClass( 've-ui-mobileSurface-overlay-global-visible' );
};

/**
 * Hide the global overlay and return underlying content to previous scroll
 * position.
 */
ve.ui.MobileSurface.prototype.hideGlobalOverlay = function () {
	this.$globalOverlay.removeClass( 've-ui-mobileSurface-overlay-global-visible' );
	$( 'html, body' ).removeClass( 've-ui-mobileSurface-overlay-global-enabled' );
	$( 'body' ).scrollTop( this.scrollPos );
};
