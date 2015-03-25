/*!
 * VisualEditor UserInterface DesktopSurface class.
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
 */
ve.ui.DesktopSurface = function VeUiDesktopSurface() {
	// Parent constructor
	ve.ui.Surface.apply( this, arguments );

	// Properties
	this.$localOverlayMenus = this.$( '<div>' );

	// Initialization
	this.$localOverlay.append( this.$localOverlayMenus );
	this.$localOverlayMenus.append( this.context.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.DesktopSurface, ve.ui.Surface );

/* Methods */

/**
 * Set up a context.
 *
 * @method
 */
ve.ui.DesktopSurface.prototype.setupContext = function () {
	this.context = new ve.ui.DesktopContext( this, { '$': this.$ } );
};
