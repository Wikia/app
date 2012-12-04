/**
 * VisualEditor Action class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic action.
 *
 * An action is built around a surface for one-time use. It is a generic way of extending the
 * functionality of a surface. Actions are accessible via {ve.Surface.prototype.execute}.
 *
 * @class
 * @constructor
 * @param {ve.Surface} surface Surface to act on
 */
ve.Action = function VeAction( surface ) {
	// Properties
	this.surface = surface;
};

/* Static Members */

ve.Action.static = {};

/**
 * List of allowed methods for this action.
 *
 * To avoid use of methods not intended to be executed via surface.execute(), the methods must be
 * whitelisted here. This information is checked by ve.Surface before executing an action.
 *
 * If a method returns a value, it will be cast to boolean and be used to determine if the action
 * was canceled. Not returning anything, or returning undefined will be treated the same as
 * returning true. A canceled action will yield to other default behavior. For example, when
 * triggering an action from a keystroke, a canceled action will allow normal insertion behavior to
 * be carried out.
 *
 * @static
 * @member
 */
ve.Action.static.methods = [];
