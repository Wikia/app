/*!
 * VisualEditor UserInterface InspectorAction class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Inspector action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.InspectorAction = function VeUiInspectorAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.ui.InspectorAction, ve.ui.Action );

/* Static Properties */

ve.ui.InspectorAction.static.name = 'inspector';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.InspectorAction.static.methods = [ 'open' ];

/* Methods */

/**
 * Open an inspector.
 *
 * @method
 * @param {string} name Symbolic name of inspector to open
 */
ve.ui.InspectorAction.prototype.open = function ( name ) {
	this.surface.getContext().openInspector( name );
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.InspectorAction );
