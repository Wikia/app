/*!
 * VisualEditor UserInterface DialogAction class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
 * Open a Dialog.
 *
 * @method
 * @param {string} name Symbolic name of dialog to open
 * @param {Object} [data] Dialog opening data
 */
ve.ui.DialogAction.prototype.open = function ( name, data ) {
	var fragment = this.surface.getModel().getFragment( null, true ),
		dir = fragment.getRange() ?
			this.surface.getView().getDocument().getDirectionFromRange( fragment.getRange() ) :
			this.surface.getModel().getDocument().getDir();

	data = ve.extendObject( { 'dir': dir }, data );

	// HACK: This shouldn't be needed, but thar be dragons yonder in the Window class
	this.surface.getView().getDocument().getDocumentNode().$element[0].blur();

	this.surface.getDialogs().getWindow( name ).open( fragment, data );
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.DialogAction );
