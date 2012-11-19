/**
 * VisualEditor CommandRegistry class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Command registry.
 *
 * @class
 * @constructor
 * @extends {ve.Registry}
 */
ve.CommandRegistry = function VeCommandRegistry() {
	// Parent constructor
	ve.Registry.call( this );
};

/* Inheritance */

ve.inheritClass( ve.CommandRegistry, ve.Registry );

/* Methods */

/**
 * Register a constructor with the factory.
 *
 * @method
 * @param {String|String[]} name Symbolic name or list of symbolic names
 * @param {String|String[]} trigger Command string of keys that should trigger the command
 * @param {String} action Action to execute when command is triggered
 * @param {String} method Method to call on action when executing
 * @param {Mixed} [...] Additional data to pass to the action when executing
 * @throws 'trigger must be a string or array'
 * @throws 'action must be a string'
 * @throws 'method must be a string'
 */
ve.CommandRegistry.prototype.register = function ( name, trigger, action, method ) {
	if ( typeof trigger !== 'string' && !ve.isArray( trigger ) ) {
		throw new Error( 'trigger must be a string or array, cannot be a ' + typeof trigger );
	}
	if ( typeof action !== 'string' ) {
		throw new Error( 'action must be a string, cannot be a ' + typeof action );
	}
	if ( typeof method !== 'string' ) {
		throw new Error( 'method must be a string, cannot be a ' + typeof method );
	}
	ve.Registry.prototype.register.call(
		this, name, { 'trigger': trigger, 'action': Array.prototype.slice.call( arguments, 2 ) }
	);
};

/* Initialization */

ve.commandRegistry = new ve.CommandRegistry();

// TODO: Move these somewhere else

ve.commandRegistry.register(
	'bold', ['cmd+b', 'ctrl+b'], 'annotation', 'toggle', 'textStyle/bold'
);
ve.commandRegistry.register(
	'italic', ['cmd+i', 'ctrl+i'], 'annotation', 'toggle', 'textStyle/italic'
);
ve.commandRegistry.register( 'link', ['cmd+k', 'ctrl+k'], 'inspector', 'open', 'link' );
ve.commandRegistry.register( 'undo', ['cmd+z', 'ctrl+z'], 'history', 'undo' );
ve.commandRegistry.register( 'redo', ['cmd+shift+z', 'ctrl+shift+z'], 'history', 'redo' );
ve.commandRegistry.register( 'indent', ['tab'], 'indentation', 'increase' );
ve.commandRegistry.register( 'unindent', ['shift+tab'], 'indentation', 'decrease' );
