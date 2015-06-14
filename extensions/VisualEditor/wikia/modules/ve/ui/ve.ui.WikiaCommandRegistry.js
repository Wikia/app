/*!
 * VisualEditor Wikia CommandRegistry class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

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
		'wikiaTemplateInsert', 'window', 'open',
		{ args: ['wikiaTemplateInsert'] }
	)
);
