/*!
 * VisualEditor CommandRegistry class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* Wikia Command Registrations */

ve.ui.commandRegistry.register(
	new ve.ui.Command( 'wikiaMediaInsert', 'window', 'open', 'wikiaMediaInsert' )
);

ve.ui.commandRegistry.register(
	new ve.ui.Command( 'wikiaMapInsert', 'window', 'open', 'wikiaMapInsert' )
);

ve.ui.commandRegistry.register(
	new ve.ui.Command( 'wikiaSourceMode', 'window', 'open', 'wikiaSourceMode' )
);

ve.ui.commandRegistry.register(
	new ve.ui.Command( 'wikiaTemplateInsert', 'window', 'open', 'wikiaTemplateInsert' )
);

ve.ui.commandRegistry.register(
	new ve.ui.Command( 'wikiaSingleMedia', 'window', 'open', 'wikiaSingleMedia' )
);
