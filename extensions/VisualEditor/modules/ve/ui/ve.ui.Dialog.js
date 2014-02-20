/*!
 * VisualEditor UserInterface Dialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog with an associated surface.
 *
 * @class
 * @abstract
 * @extends OO.ui.Dialog
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.Dialog = function VeUiDialog( windowSet, config ) {
	// Parent constructor
	OO.ui.Dialog.call( this, windowSet, config );

	// Properties
	this.surface = windowSet.getSurface();
};

/* Inheritance */

OO.inheritClass( ve.ui.Dialog, OO.ui.Dialog );
