/*!
 * VisualEditor UserInterface Command class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Command that executes an action.
 *
 * @class
 *
 * @constructor
 * @param {string} action Action to execute when command is triggered
 * @param {string} method Method to call on action when executing
 * @param {Mixed...} [data] Additional data to pass to the action when executing
 * @throws {Error} Action must be a string
 * @throws {Error} Method must be a string
 */
ve.ui.Command = function VeUiCommand( action, method ) {
	if ( typeof action !== 'string' ) {
		throw new Error( 'action must be a string, cannot be a ' + typeof action );
	}
	if ( typeof method !== 'string' ) {
		throw new Error( 'method must be a string, cannot be a ' + typeof method );
	}
	this.action = action;
	this.method = method;
	this.data = Array.prototype.slice.call( arguments, 2 );
};

/* Methods */

/**
 * Execute command on a surface.
 *
 * @param {ve.ui.Surface} surface Surface to execute command on
 * @returns {Mixed} Result of command execution.
 */
ve.ui.Command.prototype.execute = function ( surface ) {
	return surface.execute.apply( surface, [ this.action, this.method ].concat( this.data ) );
};

/**
 * Get command action.
 *
 * @returns {string} action Action to execute when command is triggered
 */
ve.ui.Command.prototype.getAction = function () {
	return this.action;
};

/**
 * Get command method.
 *
 * @returns {string} method Method to call on action when executing
 */
ve.ui.Command.prototype.getMethod = function () {
	return this.method;
};

/**
 * Get command data.
 *
 * @returns {Array} data Additional data to pass to the action when executing
 */
ve.ui.Command.prototype.getData = function () {
	return this.data;
};
