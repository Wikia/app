/*!
 * VisualEditor UserInterface WindowAction class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Window action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.WindowAction = function VeUiWindowAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.WindowAction, ve.ui.Action );

/* Static Properties */

ve.ui.WindowAction.static.name = 'window';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.WindowAction.static.methods = [ 'open' ];

/* Methods */

/**
 * Open a window.
 *
 * @method
 * @param {string} name Symbolic name of window to open
 * @param {Object} [data] Window opening data
 */
ve.ui.WindowAction.prototype.open = function ( name, data ) {
	var win,
		windowClass = ve.ui.windowFactory.lookup( name ),
		fragment = this.surface.getModel().getFragment( null, true ),
		dir = fragment.getRange() ?
			this.surface.getView().getDocument().getDirectionFromRange( fragment.getRange() ) :
			this.surface.getModel().getDocument().getDir();

	data = ve.extendObject( { 'dir': dir }, data );

	if ( windowClass.prototype instanceof ve.ui.Dialog ) {
		win = this.surface.getDialogs().getWindow( name );
	} else if ( windowClass.prototype instanceof ve.ui.Inspector ) {
		win = this.surface.getContext().getInspector( name );
	}
	win.open( fragment, data, this.surface );
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.WindowAction );
