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
 * @extends OO.Registry
 * @constructor
 */
ve.ui.CommandRegistry = function VeCommandRegistry() {
	// Parent constructor
	OO.Registry.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ui.CommandRegistry, OO.Registry );

/* Methods */

/**
 * Register a constructor with the factory.
 *
 * @method
 * @param {string|string[]} name Symbolic name or list of symbolic names
 * @param {ve.ui.Command} command Command object
 * @throws {Error} If command is not an instance of ve.ui.Command
 */
ve.ui.CommandRegistry.prototype.register = function ( name, command ) {
	// Validate arguments
	if ( !( command instanceof ve.ui.Command ) ) {
		throw new Error(
			'command must be an instance of ve.ui.Command, cannot be a ' + typeof command
		);
	}

	OO.Registry.prototype.register.call( this, name, command );
};

/* Initialization */

ve.ui.commandRegistry = new ve.ui.CommandRegistry();

/* Registrations */

ve.ui.commandRegistry.register(
	'bold', new ve.ui.Command( 'annotation', 'toggle', 'textStyle/bold' )
);
ve.ui.commandRegistry.register(
	'italic', new ve.ui.Command( 'annotation', 'toggle', 'textStyle/italic' )
);
ve.ui.commandRegistry.register(
	'code', new ve.ui.Command( 'annotation', 'toggle', 'textStyle/code' )
);
ve.ui.commandRegistry.register(
	'strikethrough', new ve.ui.Command( 'annotation', 'toggle', 'textStyle/strike' )
);
ve.ui.commandRegistry.register(
	'underline', new ve.ui.Command( 'annotation', 'toggle', 'textStyle/underline' )
);
ve.ui.commandRegistry.register(
	'subscript', new ve.ui.Command( 'annotation', 'toggle', 'textStyle/subscript' )
);
ve.ui.commandRegistry.register(
	'superscript', new ve.ui.Command( 'annotation', 'toggle', 'textStyle/superscript' )
);
ve.ui.commandRegistry.register(
	'clear', new ve.ui.Command( 'annotation', 'clearAll' )
);
ve.ui.commandRegistry.register(
	'indent', new ve.ui.Command( 'indentation', 'increase' )
);
ve.ui.commandRegistry.register(
	'outdent', new ve.ui.Command( 'indentation', 'decrease' )
);
ve.ui.commandRegistry.register(
	'link', new ve.ui.Command( 'inspector', 'open', 'link' )
);
ve.ui.commandRegistry.register(
	'language', new ve.ui.Command( 'inspector', 'open', 'language' )
);
ve.ui.commandRegistry.register(
	'redo', new ve.ui.Command( 'history', 'redo' )
);
ve.ui.commandRegistry.register(
	'undo', new ve.ui.Command( 'history', 'undo' )
);
ve.ui.commandRegistry.register(
	'paragraph', new ve.ui.Command( 'format', 'convert', 'paragraph' )
);
ve.ui.commandRegistry.register(
	'heading1', new ve.ui.Command( 'format', 'convert', 'heading', { 'level': 1 } )
);
ve.ui.commandRegistry.register(
	'heading2', new ve.ui.Command( 'format', 'convert', 'heading', { 'level': 2 } )
);
ve.ui.commandRegistry.register(
	'heading3', new ve.ui.Command( 'format', 'convert', 'heading', { 'level': 3 } )
);
ve.ui.commandRegistry.register(
	'heading4', new ve.ui.Command( 'format', 'convert', 'heading', { 'level': 4 } )
);
ve.ui.commandRegistry.register(
	'heading5', new ve.ui.Command( 'format', 'convert', 'heading', { 'level': 5 } )
);
ve.ui.commandRegistry.register(
	'heading6', new ve.ui.Command( 'format', 'convert', 'heading', { 'level': 6 } )
);
ve.ui.commandRegistry.register(
	'preformatted', new ve.ui.Command( 'format', 'convert', 'preformatted' )
);
