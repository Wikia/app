/*!
 * VisualEditor UserInterface DialogFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface Dialog factory.
 *
 * @class
 * @extends ve.Factory
 * @constructor
 */
ve.ui.DialogFactory = function VeUiDialogFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.DialogFactory, ve.Factory );

/* Initialization */

ve.ui.dialogFactory = new ve.ui.DialogFactory();
