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

/* Registrations */

ve.ui.commandRegistry.register( 'bold', 'annotation', 'toggle', 'textStyle/bold' );
ve.ui.commandRegistry.register( 'italic', 'annotation', 'toggle', 'textStyle/italic' );
ve.ui.commandRegistry.register( 'code', 'annotation', 'toggle', 'textStyle/code' );
ve.ui.commandRegistry.register( 'strikethrough', 'annotation', 'toggle', 'textStyle/strike' );
ve.ui.commandRegistry.register( 'underline', 'annotation', 'toggle', 'textStyle/underline' );
ve.ui.commandRegistry.register( 'subscript', 'annotation', 'toggle', 'textStyle/subscript' );
ve.ui.commandRegistry.register( 'superscript', 'annotation', 'toggle', 'textStyle/superscript' );
ve.ui.commandRegistry.register( 'clear', 'annotation', 'clearAll' );
ve.ui.commandRegistry.register( 'indent', 'indentation', 'increase' );
ve.ui.commandRegistry.register( 'outdent', 'indentation', 'decrease' );
ve.ui.commandRegistry.register( 'link', 'inspector', 'open', 'link' );
ve.ui.commandRegistry.register( 'language', 'inspector', 'open', 'language' );
ve.ui.commandRegistry.register( 'redo', 'history', 'redo' );
ve.ui.commandRegistry.register( 'undo', 'history', 'undo' );
ve.ui.commandRegistry.register( 'paragraph', 'format', 'convert', 'paragraph' );
ve.ui.commandRegistry.register( 'heading1', 'format', 'convert', 'heading', { 'level': 1 } );
ve.ui.commandRegistry.register( 'heading2', 'format', 'convert', 'heading', { 'level': 2 } );
ve.ui.commandRegistry.register( 'heading3', 'format', 'convert', 'heading', { 'level': 3 } );
ve.ui.commandRegistry.register( 'heading4', 'format', 'convert', 'heading', { 'level': 4 } );
ve.ui.commandRegistry.register( 'heading5', 'format', 'convert', 'heading', { 'level': 5 } );
ve.ui.commandRegistry.register( 'heading6', 'format', 'convert', 'heading', { 'level': 6 } );
ve.ui.commandRegistry.register( 'preformatted', 'format', 'convert', 'preformatted' );
