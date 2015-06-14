/*!
 * VisualEditor CommandRegistry class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
 * Register a command with the factory.
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
	new ve.ui.Command(
		'bold', 'annotation', 'toggle',
		{ args: ['textStyle/bold'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'italic', 'annotation', 'toggle',
		{ args: ['textStyle/italic'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'code', 'annotation', 'toggle',
		{ args: ['textStyle/code'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'strikethrough', 'annotation', 'toggle',
		{ args: ['textStyle/strikethrough'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'underline', 'annotation', 'toggle',
		{ args: ['textStyle/underline'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'subscript', 'annotation', 'toggle',
		{ args: ['textStyle/subscript'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'superscript', 'annotation', 'toggle',
		{ args: ['textStyle/superscript'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'link', 'window', 'open',
		{ args: ['link'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'specialcharacter', 'window', 'open',
		{ args: ['specialcharacter'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'number', 'list', 'toggle',
		{ args: ['number'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'bullet', 'list', 'toggle',
		{ args: ['bullet'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'numberWrapOnce', 'list', 'wrapOnce',
		{ args: ['number', true], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'bulletWrapOnce', 'list', 'wrapOnce',
		{ args: ['bullet', true], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'commandHelp', 'window', 'open', { args: ['commandHelp'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'findAndReplace', 'window', 'toggle', { args: ['findAndReplace'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'code', 'annotation', 'toggle',
		{ args: ['textStyle/code'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'strikethrough', 'annotation', 'toggle',
		{ args: ['textStyle/strikethrough'], supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'language', 'window', 'open',
		{ args: ['language'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'paragraph', 'format', 'convert',
		{ args: ['paragraph'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading1', 'format', 'convert',
		{ args: ['heading', { level: 1 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading2', 'format', 'convert',
		{ args: ['heading', { level: 2 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading3', 'format', 'convert',
		{ args: ['heading', { level: 3 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading4', 'format', 'convert',
		{ args: ['heading', { level: 4 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading5', 'format', 'convert',
		{ args: ['heading', { level: 5 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading6', 'format', 'convert',
		{ args: ['heading', { level: 6 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'preformatted', 'format', 'convert',
		{ args: ['preformatted'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'blockquote', 'format', 'convert',
		{ args: ['blockquote'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'pasteSpecial', 'content', 'pasteSpecial',
		{ supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'selectAll', 'content', 'selectAll',
		{ supportedSelections: ['linear', 'table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'comment', 'window', 'open',
		{ args: ['comment'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'insertTable', 'table', 'create',
		{
			args: [ {
				header: true,
				rows: 3,
				cols: 4
			} ],
			supportedSelections: ['linear']
		}
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'deleteTable', 'table', 'delete',
		{ args: ['table'], supportedSelections: ['table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'insertRowBefore', 'table', 'insert',
		{ args: ['row', 'before'], supportedSelections: ['table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'insertRowAfter', 'table', 'insert',
		{ args: ['row', 'after'], supportedSelections: ['table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'deleteRow', 'table', 'delete',
		{ args: ['row'], supportedSelections: ['table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'insertColumnBefore', 'table', 'insert',
		{ args: ['col', 'before'], supportedSelections: ['table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'insertColumnAfter', 'table', 'insert',
		{ args: ['col', 'after'], supportedSelections: ['table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'deleteColumn', 'table', 'delete',
		{  args: ['col'], supportedSelections: ['table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'tableCellHeader', 'table', 'changeCellStyle',
		{ args: ['header'], supportedSelections: ['table'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'tableCellData', 'table', 'changeCellStyle',
		{ args: ['data'], supportedSelections: ['table'] }
	)
);
