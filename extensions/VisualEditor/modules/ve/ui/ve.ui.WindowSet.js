/*!
 * VisualEditor UserInterface WindowSet class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface surface window set.
 *
 * @class
 * @extends OO.ui.WindowSet
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {OO.Factory} factory Window factory
 * @param {Object} [config] Configuration options
 */
ve.ui.WindowSet = function VeUiWindowSet( surface, factory, config ) {
	// Parent constructor
	OO.ui.WindowSet.call( this, factory, config );

	// Properties
	this.surface = surface;

	// Initialization
	this.$element.addClass( 've-ui-windowSet' );
};

/* Inheritance */

OO.inheritClass( ve.ui.WindowSet, OO.ui.WindowSet );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WindowSet.prototype.onWindowClose = function ( win, accept ) {
	this.surface.getView().focus();
	OO.ui.WindowSet.prototype.onWindowClose.call( this, win, accept );
};

/**
 * Get the surface.
 *
 * @method
 * @returns {ve.ui.Surface} Surface
 */
ve.ui.WindowSet.prototype.getSurface = function () {
	return this.surface;
};
