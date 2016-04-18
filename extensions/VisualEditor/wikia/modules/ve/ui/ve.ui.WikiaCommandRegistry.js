/*!
 * VisualEditor Wikia CommandRegistry class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

ve.ui.CommandRegistry.prototype.getCommandByName = function ( name ) {
	return this.lookup( name );
};

/* Wikia Command Registrations */

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaSourceMode', 'window', 'open',
		{ args: ['wikiaSourceMode'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaMediaInsert', 'window', 'open',
		{ args: ['wikiaMediaInsert'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaImageInsert', 'window', 'open',
		{ args: ['wikiaImageInsert'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaVideoInsert', 'window', 'open',
		{ args: ['wikiaVideoInsert'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaSingleMedia', 'window', 'open',
		{ args: ['wikiaSingleMedia'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaMapInsert', 'window', 'open',
		{ args: ['wikiaMapInsert'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaInfoboxInsert', 'window', 'open',
		{ args: ['wikiaInfoboxInsert'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaInfobox', 'window', 'open',
		{ args: ['wikiaInfobox'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaTemplateInsert', 'window', 'open',
		{ args: ['wikiaTemplateInsert'] }
	)
);

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'wikiaInfoboxBuilder', 'window', 'open',
		{ args: ['wikiaInfoboxBuilder'] }
	)
);
