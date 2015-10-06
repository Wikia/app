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
