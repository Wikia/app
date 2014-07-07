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

	// Initialization
	this.$globalOverlay.append( this.context.$element );
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
