/*!
 * VisualEditor UserInterface MWDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki dialog.
 *
 * @class
 * @abstract
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWDialog = function VeUiMWDialog( windowSet, config ) {
	// Parent constructor
	ve.ui.Dialog.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWDialog, ve.ui.Dialog );
