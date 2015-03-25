/*!
 * VisualEditor CommandRegistry class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
 * @param {ve.ui.Command} command Command object
 * @throws {Error} If command is not an instance of ve.ui.Command
 */
ve.ui.CommandRegistry.prototype.register = function ( command ) {
	// Validate arguments
	if ( !( command instanceof ve.ui.Command ) ) {
		throw new Error(
			'command must be an instance of ve.ui.Command, cannot be a ' + typeof command
		);
	}

	OO.Registry.prototype.register.call( this, command.getName(), command );
};

/**
 * Returns the primary command for for node.
 *
 * @param {ve.ce.Node} node Node to get command for
 * @returns {ve.ui.Command}
 */
ve.ui.CommandRegistry.prototype.getCommandForNode = function ( node ) {
	return this.lookup( node.constructor.static.primaryCommandName );
};

/* Initialization */

ve.ui.commandRegistry = new ve.ui.CommandRegistry();

/* Registrations */

ve.ui.commandRegistry.register(
	new ve.ui.Command( 'undo', 'history', 'undo' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'redo', 'history', 'redo' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'bold', 'annotation', 'toggle', 'textStyle/bold' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'italic', 'annotation', 'toggle', 'textStyle/italic' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'code', 'annotation', 'toggle', 'textStyle/code' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'strike', 'annotation', 'toggle', 'textStyle/strike' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'underline', 'annotation', 'toggle', 'textStyle/underline' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'subscript', 'annotation', 'toggle', 'textStyle/subscript' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'superscript', 'annotation', 'toggle', 'textStyle/superscript' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'link', 'window', 'open', 'link' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'specialcharacter', 'window', 'open', 'specialcharacter' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'clear', 'annotation', 'clearAll' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'indent', 'indentation', 'increase' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'outdent', 'indentation', 'decrease' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'number', 'list', 'toggle', 'number' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'bullet', 'list', 'toggle', 'bullet' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'commandHelp', 'window', 'open', 'commandHelp' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'code', 'annotation', 'toggle', 'textStyle/code' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'strikethrough', 'annotation', 'toggle', 'textStyle/strike' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'language', 'window', 'open', 'language' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'paragraph', 'format', 'convert', 'paragraph' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading1', 'format', 'convert', 'heading', { 'level': 1 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading2', 'format', 'convert', 'heading', { 'level': 2 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading3', 'format', 'convert', 'heading', { 'level': 3 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading4', 'format', 'convert', 'heading', { 'level': 4 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading5', 'format', 'convert', 'heading', { 'level': 5 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading6', 'format', 'convert', 'heading', { 'level': 6 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'preformatted', 'format', 'convert', 'preformatted' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'pasteSpecial', 'content', 'pasteSpecial' )
);
