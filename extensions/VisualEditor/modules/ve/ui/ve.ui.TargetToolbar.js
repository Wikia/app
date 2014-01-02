/*!
 * VisualEditor UserInterface TargetToolbar class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface target toolbar.
 *
 * @class
 * @extends ve.ui.SurfaceToolbar
 *
 * @constructor
 * @param {ve.init.Target} target Target to control
 * @param {ve.ui.Surface} surface Surface to control
 * @param {Object} [options] Configuration options
 */
ve.ui.TargetToolbar = function VeUiTargetToolbar( target, surface, options ) {
	// Parent constructor
	ve.ui.SurfaceToolbar.call( this, surface, options );

	// Properties
	this.target = target;
};

/* Inheritance */

ve.inheritClass( ve.ui.TargetToolbar, ve.ui.SurfaceToolbar );

/* Methods */

/**
 * Gets the target which the toolbar controls.
 *
 * @returns {ve.init.Target} Target being controlled
 */
ve.ui.TargetToolbar.prototype.getTarget = function () {
	return this.target;
};
