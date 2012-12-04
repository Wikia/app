/**
 * VisualEditor InspectorAction class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * List action.
 *
 * @class
 * @constructor
 * @extends {ve.Action}
 * @param {ve.Surface} surface Surface to act on
 */
ve.InspectorAction = function VeListAction( surface ) {
	// Parent constructor
	ve.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.InspectorAction, ve.Action );

/* Static Members */

/**
 * List of allowed methods for this action.
 *
 * @static
 * @member
 */
ve.InspectorAction.static.methods = ['open', 'close'];

/* Methods */

/**
 * Opens an inspector.
 *
 * @method
 * @param {String} name Symbolic name of inspector
 */
ve.InspectorAction.prototype.open = function ( name ) {
	this.surface.getContext().openInspector( name );
};

/**
 * Wraps content in a list.
 *
 * If changes are not accepted, the inspector will close without modifying the document.
 *
 * @method
 * @param {Boolean} accept Accept changes
 */
ve.InspectorAction.prototype.close = function ( accept ) {
	this.surface.getContext().closeInspector( accept );
};

/* Registration */

ve.actionFactory.register( 'inspector', ve.InspectorAction );
