/*!
 * VisualEditor CommandRegistry class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Command registry.
 *
 * @class
 * @extends ve.Registry
 * @constructor
 */
ve.ui.CommandRegistry = function VeCommandRegistry() {
	// Parent constructor
	ve.Registry.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.CommandRegistry, ve.Registry );

/* Methods */

/**
 * Register a constructor with the factory.
 *
 * @method
 * @param {string|string[]} name Symbolic name or list of symbolic names
 * @param {string} action Action to execute when command is triggered
 * @param {string} method Method to call on action when executing
 * @param {Mixed...} [data] Additional data to pass to the action when executing
 * @throws {Error} Action must be a string
 * @throws {Error} Method must be a string
 */
ve.ui.CommandRegistry.prototype.register = function ( name, action, method ) {
	if ( typeof name !== 'string' && !ve.isArray( name ) ) {
		throw new Error( 'name must be a string or array, cannot be a ' + typeof name );
	}
	if ( typeof action !== 'string' ) {
		throw new Error( 'action must be a string, cannot be a ' + typeof action );
	}
	if ( typeof method !== 'string' ) {
		throw new Error( 'method must be a string, cannot be a ' + typeof method );
	}
	ve.Registry.prototype.register.call(
		this, name, { 'action': Array.prototype.slice.call( arguments, 1 ) }
	);
};

/* Initialization */

ve.ui.commandRegistry = new ve.ui.CommandRegistry();
