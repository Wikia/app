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
 * @extends ve.NamedClassFactory
 * @constructor
 */
ve.ui.DialogFactory = function VeUiDialogFactory() {
	// Parent constructor
	ve.NamedClassFactory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.DialogFactory, ve.NamedClassFactory );

/* Initialization */

ve.ui.dialogFactory = new ve.ui.DialogFactory();
