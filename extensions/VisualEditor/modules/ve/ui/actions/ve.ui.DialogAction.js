/*!
 * VisualEditor UserInterface DialogAction class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.DialogAction = function VeUiDialogAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.DialogAction, ve.ui.Action );

/* Static Properties */

ve.ui.DialogAction.static.name = 'dialog';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.DialogAction.static.methods = [ 'open' ];

/* Methods */

/**
 * Open an Dialog.
 *
 * @method
 * @param {string} name Symbolic name of Dialog to open
 * @param {Object} [config] Configuration options for dialog setup
 */
ve.ui.DialogAction.prototype.open = function ( name, config ) {
	this.surface.getDialogs().getWindow( name ).open( config );
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.DialogAction );
